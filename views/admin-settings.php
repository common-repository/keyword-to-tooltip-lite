<form id="keyword_to_tooltip-container" method="POST" class="form-horizontal" method="POST" style="width:98%;">

  <?php KeywordToTooltipLite::getInstance()->backendRequest->displayRequestNotifications();?>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane active" id="default-keyword-settings">
      <div class="form-group">
        <label class="col-sm-3 control-label">Default Highlight Color</label>
        <div class="col-sm-9  colorpicker-container">
          <input type="text" class="colorpicker" style="width:100%" name="default_hightlight_color" value="<?php echo KeywordToTooltipLite::getInstance()->settings->highlightDefaultColor;?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Default Panel Color</label>
        <div class="col-sm-9  colorpicker-container">
          <input type="text" class="colorpicker" style="width:100%" name="default_panel_color" value="<?php echo KeywordToTooltipLite::getInstance()->settings->panelDefaultColor;?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Default Panel Animation</label>
        <div class="col-sm-9 box-sizing-normal">
          <select name="default_panel_effect">
            <?php foreach(KeywordToTooltipLite::getInstance()->cssAnimationList as $animation) : ?>
              <option value="<?php echo $animation?>" <?php echo ($animation == KeywordToTooltipLite::getInstance()->settings->panelDefaultEffect) ? 'selected="selected"' : '';?>><?php echo $animation;?></option>
            <?php endforeach;?>
          </select>
        </div>
      </div>
    </div>
    <div class="tab-pane active" id="panel-skin">
      <div class="col-sm-12">
        <hr/>
        <div class="row">
          <?php foreach(KeywordToTooltipLite::getInstance()->tooltipAvailableSkins as $alias => $name) : ?>
            <div class="col-3 col-md-3">
              <p class="text-center"><?php echo $name;?></p>
              <div id="tooltip" class="<?php echo $alias;?>" style="display: block;position:static;margin:0 auto;left:0;width: 100px;">
                Demo
              </div>
              <br/>
              <p><input type="radio"
                        name="panel_skin"
                        value="<?php echo $alias;?>"
                    <?php echo $alias == KeywordToTooltipLite::getInstance()->settings->panelSkin ? 'checked="checked"' : '';?>
                        style="display: block;margin:0 auto;width:20px;"/></p>
            </div>
          <?php endforeach;?>
        </div>
        <div class="clearfix"></div>

        <p class="alert alert-info">These <strong>DEMO</strong> Only tooltips don't have the "small arrow" down.</p>
      </div>
    </div>
  </div>

  <div class="clear"></div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <input type="submit" class="btn btn-success btn-lg" name="keyword_to_tooltip-saveSettings" value="Save All &raquo;">
    </div>
  </div>

</form>


<style>
  .box-sizing-normal *,
  .colorpicker-container *,
  .colorpicker-container *:after,
  .colorpicker-container *:before {
    -webkit-box-sizing: content-box !important;
    -moz-box-sizing: content-box !important;
    box-sizing: content-box !important;
  }

  #tooltip {
    background: #1e73be;
  }
</style>