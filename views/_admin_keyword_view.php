<div class="form-group">
  <label class="col-sm-2 control-label">Name</label>
  <div class="col-sm-10">
    <?php echo $keyword->keyword;?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Consider "Plural" Ending</label>
  <div class="col-sm-10">
    <?php echo $keyword->consider_plural == 1 ? 'Yes' : 'No';?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Consider "Ing" Ending</label>
  <div class="col-sm-10">
    <?php echo $keyword->consider_ing == 1 ? 'Yes' : 'No';?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Consider "Ed" Ending</label>
  <div class="col-sm-10">
    <?php echo $keyword->consider_ed == 1 ? 'Yes' : 'No';?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Highlight Color</label>
  <div class="col-sm-10">
    <span style="background: <?php echo $keyword->highlight_color;?>;width: 50%;height:20px;display: block;"></span>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Panel Color</label>
  <div class="col-sm-10">
    <span style="background: <?php echo $keyword->panel_color;?>;width: 50%;height:20px;display: block;"></span>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Panel Animation</label>
  <div class="col-sm-10">
    <?php echo $keyword->panel_animation;?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Style Method</label>
  <div class="col-sm-10">
    <?php foreach(KeywordToTooltipLite::getInstance()->styleMethod->availableFields as $availableFieldId => $availableField) : ?>
      <?php echo in_array($availableFieldId, $keyword->style_method) ? $availableField['name'] . '<br/>' : '';?>
    <?php endforeach;?>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Description</label>
  <div class="col-sm-10">
    <?php echo str_replace("\n", "<br/>", $keyword->description);?>
  </div>
</div>