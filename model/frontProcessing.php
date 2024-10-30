<?php

class KeywordToTooltipLitePageRequest {

  private $_keywordsList = null;

  public function __construct() {
    if(!is_admin())
      add_action('init', array($this, 'init'));
  }

  public function init() {
    add_filter('the_content', array($this, 'postContentParse'));

    $this->queStyle();
  }

  public function queStyle() {
    $this->_defaultQueAssets();
  }

  private function _defaultQueAssets() {
    wp_enqueue_style('keyword_to_tooltip_lite_front', plugins_url( 'styles/front.css', dirname(__FILE__)));

    if(KeywordToTooltipLite::getInstance()->frontGeneratedStyleClassicPath != false
        && KeywordToTooltipLite::getInstance()->frontGeneratedStylePath == false)
      wp_enqueue_style('keyword_to_tooltip_lite_front_skin', plugins_url( KeywordToTooltipLite::getInstance()->frontGeneratedStyleClassicPath, dirname(__FILE__)));
    if(KeywordToTooltipLite::getInstance()->frontGeneratedStylePath != false)
      wp_enqueue_style('keyword_to_tooltip_lite_front_skin', KeywordToTooltipLite::getInstance()->frontGeneratedStyleLinkPath);

    wp_enqueue_style('animate.css', plugins_url( 'styles/animate.css', dirname(__FILE__)));
    wp_enqueue_script('jquery');
    wp_enqueue_script('keyword_to_tooltip_lite_front_js', plugins_url( 'frontScript.js', dirname(__FILE__)));
  }

  public function postContentParse( $content ) {
    if(!is_single())
      return $content;

    return $this->_parseContent($content);
  }

  private function _parseContent($content) {
    $aKeywords = $this->_getKeywordsList();

    if(empty($aKeywords))
      return $content;

    //---------------------------------------------
    //Find all pre-existing selectors

    $aSelector = array();
    $aDebug = array();
    $i = 0;
    $startSelector = 0;
    $endSelector = 0;
    while( $i < strlen( $content ) ) {

      //We have found a selector ('<' followed by a non-space char)
      if ( ( substr($content, $i, 1) == '<' ) && ( substr($content, $i+1, 1) != ' ' ) ) {
        $startSelector = $i;

        //Anchor selectors
        //We want to mark the selector and its content
        if ( substr($content, $i, 2) == '<a' ) {
          while( $i < strlen( $content ) ) {
            if (substr($content, $i, 4) == '</a>') {
              $endSelector = $i + 4;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        } else {
          //Other selectors (all but anchors)
          //We only want to mark the selector, not its content.
          //Example: for '<p class="test">Test</p>' we only mark '<p class="test">' and '</p>', not 'Test'
          while( $i < strlen( $content ) ) {
            if ( substr($content, $i, 1) == '>') {
              $endSelector = $i+1;
              array_push( $aSelector, array( $startSelector, $endSelector ) );
              break;
            }
            $i++;
          }
        }
      }
      $i++;
    }

    //---------------------------------------------
    //Find all the keyword boundaries

    $aReplace = array();
    for ( $i=0; $i<count($aKeywords); $i++ ) {
      preg_match_all('/(?<=^|[^\p{Cyrillic}{Greek}{L}])' . preg_quote($aKeywords[$i][0],'/') . '(?=[^\p{Cyrillic}{Greek}{L}]|$)/ui', $content, $matches, PREG_OFFSET_CAPTURE);

      $aMatches = $matches[0];
      for ( $j=0; $j<count($aMatches); $j++ ) {
        $m = $aMatches[$j][1];
        $n = $m + strlen( $aMatches[$j][0] ) - 1;

        $inAnchor = 0;
        for ( $k=0; $k<count($aSelector); $k++ ) {
          $startAnchor = $aSelector[$k][0];
          $closeAnchor = $aSelector[$k][1];
          if ( ( $m > $startAnchor ) && ( $n < $closeAnchor ) ) { $inAnchor = 1;  break; }
        }

        if ( !$inAnchor ) {
          array_push( $aReplace, array( $m, $n, $aMatches[$j][0], $aKeywords[$i][1], $aKeywords[$i][2], $aKeywords[$i][3]));
        }
      }
    }

    usort($aReplace, 'KeywordToTooltipLiteContentCompareOrder');

    //---------------------------------------------
    //Replace keywords with their URLs

    $i = 0;
    $temp = '';
    for ( $j = 0; $j<count($aReplace); $j++ ) {
      $keywordStart = $aReplace[$j][0];

      if ( $keywordStart > $i
          || ($keywordStart == 0 && $i == 0)) {
        $keywordEnd        = $aReplace[$j][1];
        $keyword           = $aReplace[$j][2];
        $description       = $aReplace[$j][3];
        $id                = $aReplace[$j][4];
        $animation         = $aReplace[$j][5];

        $temp .= substr( $content, $i, $keywordStart - $i );

        $temp .= '<span class="keyword-to-tooltip-lite keyword-to-tooltip-lite-' . $id . '"';
        $temp .= ' data-animation="' . $animation . '"';
        $temp .= ' data-skin="keyword-to-tooltip-lite-tip-' . $id . ' ' . KeywordToTooltipLite::getInstance()->settings->panelSkin . '">' . $keyword . '<span class="tip"';
        $temp .= '>' . $description . '</span>';
        $temp .= '</span>';


        $i = $keywordEnd + 1;
      }
    }

    $temp .= substr( $content, $i );

    return ( $temp );
  }

  private function _getKeywordsList() {
    if($this->_keywordsList !== null)
      return $this->_keywordsList;

    $keywords_db = KeywordToTooltipLite::getInstance()->database->getKeywords();

    if(empty($keywords_db))
      return array();

    $aKeywords = array();

    foreach($keywords_db as $keyword)
      $aKeywords[] = array(
          $keyword->keyword,
          $keyword->description,
          $keyword->id,
          $keyword->panel_animation
      );

    $this->_keywordsList = $aKeywords;

    return $this->_keywordsList;
  }

}

function KeywordToTooltipLiteContentCompareOrder( $a, $b ) {
  $retval = $a[0] - $b[0];
  if( !$retval ) {
    return $b[1] - $a[1];
  }
  return $retval;
}

