<div class="form-group">
  <label class="col-sm-2 control-label">Name</label>
  <div class="col-sm-10">
    <input type="text" style="width:100%" class="form-control" name="keyword_to_tooltip_tooltip[<?php echo $keyword->id?>][keyword]" value="<?php echo $keyword->keyword;?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Highlight Color</label>
  <div class="col-sm-10  colorpicker-container">
    <input type="text" class="colorpicker<?php echo isset($smartColorPicker) ? '-smart' : '';?>" style="width:100%" name="keyword_to_tooltip_tooltip[<?php echo $keyword->id?>][highlight_color]" value="<?php echo $keyword->highlight_color;?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Panel Color</label>
  <div class="col-sm-10 colorpicker-container">
    <input type="text" class="colorpicker<?php echo isset($smartColorPicker) ? '-smart' : '';?>" style="width:100%" name="keyword_to_tooltip_tooltip[<?php echo $keyword->id?>][panel_color]" value="<?php echo $keyword->panel_color;?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Panel Animation</label>
  <div class="col-sm-10 box-sizing-normal">
    <select name="keyword_to_tooltip_tooltip[<?php echo $keyword->id?>][panel_animation]">
      <?php foreach(KeywordToTooltipLite::getInstance()->cssAnimationList as $animation) : ?>
        <option value="<?php echo $animation?>" <?php echo ($animation == $keyword->panel_animation) ? 'selected="selected"' : '';?>><?php echo $animation;?></option>
      <?php endforeach;?>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Description</label>
  <div class="col-sm-10 box-sizing-normal">
    <?php wp_editor($keyword->description, 'keyword_to_tooltip_' . $keyword->id, array('textarea_name' => 'keyword_to_tooltip_tooltip[' . $keyword->id . '][description]', 'textarea_rows' => 10));?>
  </div>
</div>