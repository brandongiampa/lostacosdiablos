<?php

  $document_root_path = "http://192.168.1.232:8080/lostacosamigos/";
  //check constant
  if (!defined('CAN_OPEN')){
    header('location: ' . $document_root_path);
  }
?>
