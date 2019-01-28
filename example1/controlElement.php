<?php

/**
 *
 */
class controlElement {

  /**
   *
   */
  public function element($data) {
    if (isset($data)) {
      $stringDic = $this->extractData($data[0], 'dic');
      $find = $this->extractData($data[1], 'query');
      $var = array();
      foreach ($find as $char) {
        $count = array();
        if (preg_match('/[?]/', $char)) {
          $keyword = str_replace('?', '', $char);
          foreach ($stringDic as $index => $string) {
            if (!empty($keyword) && strpos($string, $keyword) !== FALSE) {
              $var[$keyword][] = $string;
            }
          }
          foreach ($var as $type) {
            $count[] = count($type);
          }
        }
      }
      echo json_encode($count);
    }
  }

  /**
   *
   */
  public function extractData($data, $needle) {
    foreach ($data as $data_dic) {
      return $data_dic[$needle];
    }
  }

}
