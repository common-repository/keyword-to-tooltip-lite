<?php

class KeywordToTooltipLiteDatabase {

  public $wp_db;
  public $_table_prefix       = 'keyword_to_tooltip_lite_';
  public $_keyword_table         = 'keyword';

  public function __construct() {
    global $wpdb;

    $this->wp_db = $wpdb;

    $this->_keyword_table  = $this->wp_db->base_prefix . $this->_table_prefix . $this->_keyword_table;
  }

  public function getKeywords() {
    $sql = 'SELECT keyword.*
                   FROM `' . $this->_keyword_table . '` keyword';

    $information = $this->wp_db->get_results($sql);

    return $this->_beforeKeywordGet($information);
  }

  public function getKeywordById($id) {
    $sql = 'SELECT keyword.*
                   FROM `' . $this->_keyword_table . '` keyword
                   WHERE `keyword`.`id` = "' . intval($id) . '"';

    $information = $this->wp_db->get_row($sql);

    return $this->_beforeKeywordGet($information);
  }

  public function getKeywordInformationByKeyword($keyword) {
    $sql = 'SELECT keyword.*
                   FROM `' . $this->_keyword_table . '` keyword
                   WHERE `keyword`.`keyword` = "' . $keyword . '"';

    $information = $this->wp_db->get_row($sql);

    return $this->_beforeKeywordGet($information);
  }

  public function _beforeKeywordGet($information) {
    if(empty($information))
      return array();

    return $information;
  }

  public function _beforeKeywordSave(&$information) {
    return $this;
  }

  public function insertKeyword($information) {
    return $this->_beforeKeywordSave($information)->insert($this->_keyword_table, $information);
  }

  public function updateKeyword($information, $id) {
    return $this->_beforeKeywordSave($information)->update($this->_keyword_table, $information, array('id' =>  $id));
  }

  public function deleteKeyword($id) {
    $this->delete($this->_keyword_table, array('id' =>  $id));
  }

  public function deleteKeywords() {
    $this->delete($this->_keyword_table);
  }

  /**
   *  Wrap my array
   *  @param array the array you want to wrap
   *  @param string wrapper , default double-quotes(")
   *  @return an array with wrapped strings
   */
  private function _wrapMyArray($array , $wrapper = '"') {
    $new_array = array();
    foreach($array as $k=>$element){
      if(!is_array($element)){
        $new_array[$k] = $wrapper . $element . $wrapper;
      }
    }
    return $new_array;

  }
  /**
   * Implode an array with the key and value pair giving
   * a glue, a separator between pairs and the array
   * to implode.
   * @param string $glue The glue between key and value
   * @param string $separator Separator between pairs
   * @param array $array The array to implode
   * @return string The imploded array
   */
  private function _arrayImplode( $glue, $separator, $array ) {
    if ( ! is_array( $array ) ) return $array;
    $string = array();
    foreach ( $array as $key => $val ) {
      if ( is_array( $val ) )
        $val = implode( ',', $val );
      $string[] = "{$key}{$glue}{$val}";

    }
    return implode( $separator, $string );
  }

  /**
   *  @param string db_name
   *  @param array data
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function insert($db_name , $data){
    if(is_array($data) && !empty($data)){

      $keys = array_keys($data);

      $sql = 'INSERT INTO '.$db_name.' ('
          .implode("," , $this->_wrapMyArray($keys , '`'))
          .') VALUES ('
          .implode("," , $this->_wrapMyArray($data))
          .')';
      $this->wp_db->query($sql);
      return true;
    }
    return false;
  }

  /**
   *  @param string db_name
   *  @param array data
   *  @param array/string where
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function update($db_name , $data = array() , $where = array()) {
    if(is_array($data) && !empty($data)){
      $data = $this->_wrapMyArray($data);

      $sql = 'UPDATE '.$db_name.' SET ';
      $sql .= $this->_arrayImplode("=" , "," , $data);

      if(!empty($where)){
        $sql .= ' WHERE ';
        if(is_array($where)){
          $where = $this->_wrapMyArray($where);
          $sql  .= $this->_arrayImplode("=" , "AND" , $where);
        }else{
          $sql  .= $where;
        }
      }

      $this->wp_db->query($sql);
      return true;
    }
    return false;
  }

  /**
   *  @param string db_name
   *  @param array/string where
   *  @uses wrap_my_array
   *  @uses array_implode
   */
  public function delete($db_name , $where = array()){
    $sql = 'DELETE FROM '.$db_name.' ';

    if(!empty($where)){
      $sql .= ' WHERE ';
      if(is_array($where)){
        $where = $this->_wrapMyArray($where);
        $sql  .= $this->_arrayImplode("=" , "AND" , $where);
      }else{
        $sql  .= $where;
      }
    }

    $this->wp_db->query($sql);
  }

}