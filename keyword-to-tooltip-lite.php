<?php
/*
Plugin Name: Keyword to Tooltip Lite
Description: Create any keyword you want, and assign a description to it.
Version: 1.0.0
Plugin URI: http://codecanyon.net/item/wp-keywords-to-tooltip/6513598
Author: Andrei-Robert Rusu
Author URI: http://easy-development.com/
*/


class KeywordToTooltipLite {

  protected static $_instance;

  public static function getInstance() {
    if(self::$_instance == null)
      self::$_instance = new self();

    return self::$_instance;
  }

  public static function resetInstance() {
    self::$_instance = null;
  }

  public $scriptName          = 'Keyword To Tooltip Lite';
  public $scriptShortName     = "KToolTip Lite";
  public $scriptAlias    = "keyword-to-tooltip-lite";
  public $scriptBasePath = '';
  public $frontGeneratedStylePath          = '';
  public $frontGeneratedStyleFilePath      = '';
  public $frontGeneratedStyleLinkPath      = '';
  public $frontGeneratedStylePathPrefix    = 'keywordToTooltipLiteFrontGeneratedStyle';
  public $frontGeneratedStylePathPostfix   = '.css';
  public $frontGeneratedStyleClassicPath   = 'frontGeneratedStyle.css';

  /**
   * @var KeywordToTooltipLiteDatabase
   */
  public $database;

  /**
   * @var KeywordToTooltipLiteHook
   */
  public $hook;

  /**
   * @var KeywordToTooltipLiteSettings
   */
  public $settings;

  /**
   * @var KeywordToTooltipLitePageRequest
   */
  public $frontProcessing;

  /**
   * @var KeywordsToTooltipLiteBackendRequest
   */
  public $backendRequest;

  public $frontCSSToolTipSchema = '
    .keyword-to-tooltip-lite-{id} {
      color: {highlight_color};
    }

    .keyword-to-tooltip-lite-tip-{id} {
      background: {panel_color};
      {custom_advanced_animation_settings}
    }

    .keyword-to-tooltip-lite-tip-{id}:after {
      border-top: 10px solid {panel_color};
    }

    .keyword-to-tooltip-lite-tip-{id}.top:after {
      border-bottom: 10px solid {panel_color};
    }
  ';

  public $cssAnimationAttributes = array(
    'animation-name', 'animation-duration', 'animation-timing-function',
    'animation-delay', 'animation-iteration-count', 'animation-direction'
  );

  public $cssAnimationList = array(
    'None(Default)',
    'fadeInUp', 'fadeInRight', 'fadeInDown', 'fadeInLeft', 'fadeInUpBig', 'fadeInRightBig',
    'fadeInDownBig', 'fadeInLeftBig', 'bounceInUp', 'bounceInRight', 'bounceInDown', 'bounceInLeft', 'flipInX', 'flipInY',
    'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight',
    'swing', 'wobble', 'tada'
  );

  public $tooltipAvailableSkins = array(
    'classic'               => 'Classic ( No Border Radius ) ',
    'circle'                => 'Circle',
    'rounded'               => 'Rounded',
    'rounded-bottom'        => 'Rounded Bottom',
    'rounded-bottom-large'  => 'Rounded Bottom Large',
    'rounded-top'           => 'Rounded Top',
    'rounded-top-large'     => 'Rounded Top Large'
  );

  public $_runConstruct = 0;

  public function __construct() {
    if($this->_runConstruct == 0) {
      $this->scriptBasePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;

      $this->setFrontGeneratedStyleDependency()
           ->setDependencies()
           ->setWordPressHooks()
           ->_runConstruct = 1;
    }
  }

  public function setFrontGeneratedStyleDependency() {
    $this->frontGeneratedStylePath = $this->_getCurrentFrontGeneratedStylePath();

    if(!file_exists($this->scriptBasePath . $this->frontGeneratedStyleClassicPath))
      $this->frontGeneratedStyleClassicPath = false;

    $uploadDirectory = wp_upload_dir();

    $this->frontGeneratedStyleFilePath = $uploadDirectory['basedir'] . DIRECTORY_SEPARATOR . $this->frontGeneratedStylePath;
    $this->frontGeneratedStyleLinkPath = $uploadDirectory['baseurl'] . '/' . $this->frontGeneratedStylePath;

    if(!file_exists($uploadDirectory['basedir'] . DIRECTORY_SEPARATOR . $this->frontGeneratedStylePath))
      $this->frontGeneratedStylePath = false;

    return $this;
  }

  private function _getCurrentFrontGeneratedStylePath() {
    return (function_exists('is_multisite') && is_multisite()) ?
            $this->frontGeneratedStylePathPrefix . '-' . get_current_blog_id() . $this->frontGeneratedStylePathPostfix
            : $this->frontGeneratedStylePathPrefix . $this->frontGeneratedStylePathPostfix;
  }

  /**
   * @return KeywordToTooltip
   */
  public function setDependencies() {
    require_once($this->scriptBasePath . 'model/hook.php');
    require_once($this->scriptBasePath . 'model/database.php');
    require_once($this->scriptBasePath . 'model/settings.php');
    require_once($this->scriptBasePath . 'model/backendRequest.php');
    require_once($this->scriptBasePath . 'model/frontProcessing.php');

    $this->hook             = new KeywordToTooltipLiteHook();
    $this->database         = new KeywordToTooltipLiteDatabase();
    $this->settings         = new KeywordToTooltipLiteSettings();
    $this->backendRequest   = new KeywordsToTooltipLiteBackendRequest();
    $this->frontProcessing  = new KeywordToTooltipLitePageRequest();

    return $this;
  }

  public function setWordPressHooks() {
    register_activation_hook(__FILE__, array($this, '_wpActivationHook'));
    add_action( 'admin_menu', array( $this, '_addAdministrationMenu' ) );
    add_action( 'admin_enqueue_scripts', array($this, '_adminScripts') );

    return $this;
  }

  public function _adminScripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'keyword-to-tooltip-admin', plugins_url('admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_enqueue_script( 'bootstrap.js', plugins_url('bootstrap.min.js', __FILE__ ));
  }

  public function _addAdministrationMenu() {
    add_menu_page(
      $this->scriptName,
      '&nbsp;' . $this->scriptShortName,
      'manage_options',
      $this->scriptAlias,
      array(
        $this, 'displayAdministration'
      ),
      plugins_url( 'icon.png', __FILE__)
    );
  }

  public function displayAdministration() {
    $this->backendRequest->process();

    echo '<link rel="stylesheet" href="' . plugins_url('styles/front.css', __FILE__) . '" />';
    echo '<link rel="stylesheet" href="' . plugins_url('styles/style.css', __FILE__) . '" />';
    echo '<div class="bootstrap_environment">';
    require_once('_header.php');

    if(isset($_GET['sub-page']) && $_GET['sub-page'] == 'settings')
      require('views/admin-settings.php');
    else if(isset($_GET['sub-page']) && $_GET['sub-page'] == 'add-new')
      require('views/admin_add.php');
    else if(isset($_GET['sub-page']) && $_GET['sub-page'] == 'edit')
      require('views/admin_edit.php');
    else
      require('views/admin_index.php');

    echo '</div>';
  }

  public function fetchCurrentFrontCSS() {
    $cssTemplate = '';

    foreach($this->database->getKeywords() as $keyword) {
      $currentTemplate = $this->frontCSSToolTipSchema;

      // Cool Hook Node Replace
      foreach($keyword as $key => $value)
        if(is_string($value))
          $currentTemplate = str_replace('{' . $key . '}', $value, $currentTemplate);

      $cssTemplate .= "\n" . $currentTemplate;
    }

    return $cssTemplate;
  }

  public function generateFrontCSS() {
    if(file_exists($this->frontGeneratedStyleFilePath))
      unlink($this->frontGeneratedStyleFilePath);

    file_put_contents($this->frontGeneratedStyleFilePath, $this->fetchCurrentFrontCSS());

    chmod($this->frontGeneratedStyleFilePath, 0755);

    if(file_get_contents($this->frontGeneratedStyleFilePath) == '')
      file_put_contents($this->frontGeneratedStyleFilePath, $this->fetchCurrentFrontCSS());

    if($this->frontGeneratedStyleClassicPath != false
        && file_exists($this->scriptBasePath . $this->frontGeneratedStyleClassicPath)) {
      unlink($this->scriptBasePath . $this->frontGeneratedStyleClassicPath);
    }
  }

  public function _wpActivationHook($networkwide) {
    $this->_networkPropagationHook('_internalActivationHook', $networkwide);
  }

  public function _networkPropagationHook($propagationAction, $networkwide) {
    global $wpdb;

    if (function_exists('is_multisite') && is_multisite()) {
      if ($networkwide) {
        $old_blog = $wpdb->blogid;

        $blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");

        foreach ($blogids as $blog_id) {
          switch_to_blog($blog_id);
          $this->$propagationAction();
        }

        switch_to_blog($old_blog);
        return;
      }
    }

    $this->$propagationAction();
  }

  public function _internalActivationHook() {
    global $wpdb;

    $query = file_get_contents($this->scriptBasePath . 'model/query.txt');

    $query = str_replace($this->database->_table_prefix ,
                         $wpdb->base_prefix . $this->database->_table_prefix,
                         $query);

    $queries = explode(';', $query);


    foreach($queries as $query)
      if(strlen($query)> 20)
        $response = $wpdb->query($query);
  }

}

KeywordToTooltipLite::getInstance();
