<?php
KeywordToTooltipLite::getInstance()->backendRequest->displayRequestNotifications();

$keywords_information = KeywordToTooltipLite::getInstance()->database->getKeywords();
?>

<a class="btn btn-success" href="?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>&sub-page=add-new">
  <?php echo __('Add New &raquo;')?>
</a>

<div class="clearfix"></div>

<br/>

<form method="POST" id="keyword_to_tooltip-container" onkeypress="return event.keyCode != 13;">
  <?php if(!empty($keywords_information)) : ?>

    <div class="row">
      <div class="col-md-10">
        <label for="filterEntries" class="col-sm-2 control-label">Filter Entries</label>
        <div class="col-sm-6">
          <input id="filterEntries" type="text" name="search" style="width:100%;"/>
        </div>
      </div>
      <div class="col-sm-6">
        <p class="text-center" id="filterEntriesInformation"></p>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <td><?php echo __('Keyword Name');?></td>
          <td><?php echo __('Description');?></td>
          <td><?php echo __('Highlight Color');?></td>
          <td><?php echo __('Panel Color');?></td>
          <td><?php echo __('Panel Animation');?></td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach($keywords_information as $keyword) : ?>
          <tr>
            <td>
              <?php echo $keyword->keyword;?>
            </td>
            <td><?php echo $keyword->description;?></td>
            <td style="background: <?php echo $keyword->highlight_color;?>">&nbsp;</td>
            <td style="background: <?php echo $keyword->panel_color;?>">&nbsp;</td>
            <td><?php echo $keyword->panel_animation?></td>
            <td>
              <input type="hidden" name="keyword_to_tooltip_tooltip[<?php echo $keyword->id;?>][keyword]" value="<?php echo $keyword->keyword;?>"/>
              <a class="btn btn-primary" href="?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>&sub-page=edit&keyword-id=<?php echo $keyword->id;?>">Edit &raquo;</a>
              <input type="submit" class="btn btn-danger btn-sm" name="keyword_to_tooltip-delete[<?php echo $keyword->id;?>]" value="Delete &raquo;">
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php else : ?>
      <div class="alert alert-info">
        <p><?php echo __('No Keywords available, start by adding a few');?></p>
      </div>
  <?php endif;?>
</form>
