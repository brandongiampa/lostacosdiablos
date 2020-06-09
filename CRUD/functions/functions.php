<?php
include_once '../../database/db.php';

function updateDatabase($newsBlog){

}
function sendAlertSuccess($message){
  echo '<div class="container"><div class="alert alert-success">';
    echo $message;
  echo '</div></div>';
}
function sendAlertDanger($message){
  echo '<div class="container"><div class="alert alert-danger">';
    echo $message;
  echo '</div></div>';
}
function sendAlertWarning($message){
  echo '<div class="container"><div class="alert alert-warning">';
    echo $message;
  echo '</div></div>';
}
