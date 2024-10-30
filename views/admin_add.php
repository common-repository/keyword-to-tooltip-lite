<?php

KeywordToTooltipLite::getInstance()->backendRequest->displayRequestNotifications();

$keywords_information = KeywordToTooltipLite::getInstance()->database->getKeywords();

// Do more rendering to avoid the wordpress annoying ajax sistem while making the script be more fun
?>

<?php if(!in_array('new_keyword', KeywordToTooltipLite::getInstance()->backendRequest->actions)) : ?>

<form id="keyword_to_tooltip-container" class="form-horizontal" method="POST" style="width:98%;">

  <?php require(KeywordToTooltipLite::getInstance()->scriptBasePath . 'views/_admin_keyword_add.php');?>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success btn-sm" name="keyword_to_tooltip-new" value="Add New &raquo;">
    </div>
  </div>
</form>

<?php else: ?>

  <script type="text/javascript">
    window.location = '?page=<?php echo KeywordToTooltipLite::getInstance()->scriptAlias;?>';
  </script>

<?php endif;?>

<style>
  .box-sizing-normal *,
  .colorpicker-container *,
  .colorpicker-container *:after,
  .colorpicker-container *:before {
    -webkit-box-sizing: content-box !important;
    -moz-box-sizing: content-box !important;
    box-sizing: content-box !important;
  }
</style>