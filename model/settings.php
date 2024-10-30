<?php

class KeywordToTooltipLiteSettings {

  public $settingPrefix = 'keyword_to_tooltip_lite_';

  public $settingHighlightDefaultColor         = 'default_highlight_color';
  public $settingPanelDefaultColor             = 'default_panel_color';
  public $settingPanelDefaultEffect            = 'default_panel_effect';
  public $settingPanelSkin                     = 'panel_skin';

  public $highlightDefaultColor        = '';
  public $panelDefaultColor            = '';
  public $panelDefaultEffect           = '';
  public $panelSkin                    = '';

  public function __construct() {
    $this->_prefixSettings();
    $this->_setSettings();
  }

  private function _prefixSettings() {
    $this->settingHighlightDefaultColor        = $this->settingPrefix . $this->settingHighlightDefaultColor;
    $this->settingPanelDefaultColor            = $this->settingPrefix . $this->settingPanelDefaultColor;
    $this->settingPanelDefaultEffect           = $this->settingPrefix . $this->settingPanelDefaultEffect;
    $this->settingPanelSkin                    = $this->settingPrefix . $this->settingPanelSkin;
  }

  private function _setSettings() {
    $this->highlightDefaultColor        = get_option($this->settingHighlightDefaultColor, $this->highlightDefaultColor);
    $this->panelDefaultColor            = get_option($this->settingPanelDefaultColor, $this->panelDefaultColor);
    $this->panelDefaultEffect           = get_option($this->settingPanelDefaultEffect, $this->panelDefaultEffect);
    $this->panelSkin                    = get_option($this->settingPanelSkin, $this->panelSkin);
  }

  public function setHighlightDefaultColor($highlightDefaultColor) {
    $this->highlightDefaultColor = $highlightDefaultColor;
    update_option($this->settingHighlightDefaultColor, $highlightDefaultColor);
  }

  public function setPanelDefaultColor($panelDefaultColor) {
    $this->panelDefaultColor = $panelDefaultColor;
    update_option($this->settingPanelDefaultColor, $panelDefaultColor);
  }

  public function setPanelDefaultEffect($panelDefaultEffect) {
    $this->panelDefaultEffect = $panelDefaultEffect;
    update_option($this->settingPanelDefaultEffect, $panelDefaultEffect);
  }

  public function setPanelSkin($panelSkin) {
    $this->panelSkin = $panelSkin;
    update_option($this->settingPanelSkin, $panelSkin);
  }

}