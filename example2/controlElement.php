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
      $result = array();
      foreach ($data as $key => $array) {
        $string = $array['i'][0];
        $needle = $array['i'][1];
        $act = $array['i'][2];
        $pos = $array['i'][3];
        $results = $this->checkPosition($string, $needle, $pos);
        if ($act == 'Y') {
          $pattern = '/\b(' . $needle . ')\b/';
          $offset = preg_match($pattern, $string, $matches, PREG_OFFSET_CAPTURE, $pos);
          $result[$key] = ($offset == 1) ? $results : "No worries";
        }
        elseif ($act == 'N') {
          $result[$key] = isset($results) ? $results : "No worries";
        }
      }
      echo json_encode($result);
    }
  }

  /**
   *
   */
  public function checkPosition($string, $needle, $pos) {
    $position = strpos($string, $needle, $pos);
    if ($position == TRUE) {
      return $position;
    }
  }

}
