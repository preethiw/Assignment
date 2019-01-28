<?php

/**
 * @file
 **/

include 'controlElement.php';

$postData = array();
if (isset($_POST['jsondata'])) {
  $data = new controlElement();
  $postData = ($_POST['jsondata']);
  $data->element($postData);
}
