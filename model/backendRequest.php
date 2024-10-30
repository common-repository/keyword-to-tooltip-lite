<?php

class KeywordsToTooltipLiteBackendRequest {

  public $notifications = array();
  public $actions       = array();

  public function __construct() {

  }

  public function process() {
    if(!is_admin())
      return;

    $this->_processRequest();
  }

  private function _processRequest() {
    if(isset($_POST['keyword_to_tooltip-new']))
      $this->_addKeywordAction();
    elseif(isset($_POST['keyword_to_tooltip-update']))
      $this->_editKeywordAction();
    else if(isset($_POST['keyword_to_tooltip-delete']))
      $this->_deleteKeywordAction();
    else if(isset($_POST['keyword_to_tooltip-saveSettings']))
      $this->_saveSettingsAction();
  }

  public function displayRequestNotifications() {
    if(isset($this->notifications['errors']))
      foreach($this->notifications['errors'] as $error)
        echo '<div class="alert alert-danger">' . $error . '</div>';

    if(isset($this->notifications['notifications']))
      foreach($this->notifications['notifications'] as $notification)
        echo '<div class="alert alert-info">' . $notification . '</div>';

    if(isset($this->notifications['success']))
      foreach($this->notifications['success'] as $success)
        echo '<div class="alert alert-success">' . $success . '</div>';

    if(isset($this->notifications['warnings']))
      foreach($this->notifications['warnings'] as $warning)
        echo '<div class="alert alert-warning">' . $warning . '</div>';
  }

  private function _addKeywordAction() {
    $insert_information = $_POST['keyword_to_tooltip_tooltip_new'];
    $insert_information['keyword'] = trim($insert_information['keyword']);

    $existing_information = KeywordToTooltipLite::getInstance()->database->getKeywordInformationByKeyword($insert_information['keyword']);

    if($insert_information['keyword'] == '')
      $this->notifications['errors'][] = 'Your keyword cannot be empty';
    elseif(empty($existing_information)) {
      KeywordToTooltipLite::getInstance()->hook->insertKeyword($insert_information);
      $this->actions[] = 'new_keyword';
      $this->notifications['success'][] = 'Added Keyword "' . $insert_information['keyword']. '"';
    } else {
      $this->notifications['errors'][] = 'Keyword "' . $insert_information['keyword']. '" already exists - Not Added';
    }
  }

  private function _editKeywordAction() {
    $to_update = array_keys($_POST['keyword_to_tooltip-update']);
    $to_update = array_shift($to_update);
    $update_information = $_POST['keyword_to_tooltip_tooltip'][$to_update];
    $update_information['keyword'] = trim($update_information['keyword']);

    $existing_information  = KeywordToTooltipLite::getInstance()->database->getKeywordInformationByKeyword($update_information['keyword']);
    $to_update_information = KeywordToTooltipLite::getInstance()->database->getKeywordById($to_update);


    if($update_information['keyword'] == '')
      $this->notifications['errors'][] = 'Keyword "' . $update_information['keyword']. '" cannot be empty';
    elseif(empty($existing_information) || $existing_information->id == $to_update) {
      KeywordToTooltipLite::getInstance()->hook->updateKeyword($update_information, $to_update);
      $this->actions[] = 'edit_keyword';
      $this->notifications['success'][] = 'Updated Keyword "' . $update_information['keyword']. '"';
    } else {
      $this->notifications['errors'][] = 'Keyword "' . $update_information['keyword']. '" already exists - "' . $to_update_information->keyword .'" was not updated';
    }
  }

  private function _deleteKeywordAction() {
    $arrayKeysToUpdate = array_keys($_POST['keyword_to_tooltip-delete']);

    $to_update = array_shift($arrayKeysToUpdate);
    $update_information = $_POST['keyword_to_tooltip_tooltip'][$to_update];

    KeywordToTooltipLite::getInstance()->hook->deleteKeyword($to_update);

    $this->actions[] = 'delete_keyword';

    $this->notifications['warnings'][] = __('Deleted Keyword "') . $update_information['keyword']. '"';
  }

  private function _saveSettingsAction() {
    KeywordToTooltipLite::getInstance()->settings->setHighlightDefaultColor($_POST['default_hightlight_color']);
    KeywordToTooltipLite::getInstance()->settings->setPanelDefaultColor($_POST['default_panel_color']);
    KeywordToTooltipLite::getInstance()->settings->setPanelDefaultEffect($_POST['default_panel_effect']);

    if(isset($_POST['panel_skin']))
      KeywordToTooltipLite::getInstance()->settings->setPanelSkin($_POST['panel_skin']);

    $this->notifications['success'][] = __('Settings have been successfully updated');
  }


}