<div class="form-group">
  <label class="col-sm-2 control-label">Name</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" style="width:100%" name="keyword_to_tooltip_tooltip_new[keyword]">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Highlight Color</label>
  <div class="col-sm-10  colorpicker-container">
    <input type="text" class="colorpicker" style="width:100%" name="keyword_to_tooltip_tooltip_new[highlight_color]" value="<?php echo KeywordToTooltipLite::getInstance()->settings->highlightDefaultColor?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Panel Color</label>
  <div class="col-sm-10 colorpicker-container">
    <input type="text" class="colorpicker" style="width:100%" name="keyword_to_tooltip_tooltip_new[panel_color]" value="<?php echo KeywordToTooltipLite::getInstance()->settings->panelDefaultColor?>">
  </div>
</div>
<div class="form-group">
  <label for="keyword_to_tooltip_tooltip_new-panel-animation" class="col-sm-2 control-label">Panel Animation</label>
  <div class="col-sm-10 box-sizing-normal">
    <select id="keyword_to_tooltip_tooltip_new-panel-animation" name="keyword_to_tooltip_tooltip_new[panel_animation]">
      <?php foreach(KeywordToTooltipLite::getInstance()->cssAnimationList as $animation) : ?>
        <option value="<?php echo $animation?>" <?php echo ($animation == KeywordToTooltipLite::getInstance()->settings->panelDefaultEffect) ? 'selected="selected"' : '';?>><?php echo $animation;?></option>
      <?php endforeach;?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Description</label>
  <div class="col-sm-10 box-sizing-normal">
    <?php wp_editor('', 'keyword_to_tooltip_new', array('textarea_name' => 'keyword_to_tooltip_tooltip_new[description]', 'textarea_rows' => 10));?>
  </div>
</div>