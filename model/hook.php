<?php

class KeywordToTooltipLiteHook {

  public function __construct() {

  }

  public function insertKeyword($information) {
    $response = KeywordToTooltipLite::getInstance()->database->insertKeyword($information);
    KeywordToTooltipLite::getInstance()->generateFrontCSS();

    return $response;
  }

  public function updateKeyword($information, $id) {
    $response = KeywordToTooltipLite::getInstance()->database->updateKeyword($information, $id);
    KeywordToTooltipLite::getInstance()->generateFrontCSS();

    return $response;
  }

  public function deleteKeyword($id) {
    KeywordToTooltipLite::getInstance()->database->deleteKeyword($id);
    KeywordToTooltipLite::getInstance()->generateFrontCSS();
  }
}