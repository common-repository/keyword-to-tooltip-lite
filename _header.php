<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>"><?php echo KeywordToTooltipLite::getInstance()->scriptName;?></a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li style="margin-bottom: 0" class="<?php echo !(isset($_GET['sub-page'])) ? 'active' : ''?>">
          <a href="?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>">
            <?php echo __('Administration')?>
          </a>
        </li>
        <li style="margin-bottom: 0" class="<?php echo (isset($_GET['sub-page']) && $_GET['sub-page'] == 'settings') ? 'active' : ''?>">
          <a href="?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>&sub-page=settings">
            <?php echo __('Settings')?>
          </a>
        </li>
        <li style="margin-bottom: 0">
          <a href="http://demonstration.easy-development.com/keyword-to-tooltip/" target="_blank">
            <?php echo __('Pro Version')?>
          </a>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
</div>

<?php if(!file_exists(KeywordToTooltipLite::getInstance()->frontGeneratedStyleFilePath)) : ?>
  <div class="alert alert-info">
    <p><?php echo __('No keyword generated stylesheet was found. Try Adding a keyword or editing, this will fix the problem.');?></p>
  </div>
  <br/>
<?php endif;?>
