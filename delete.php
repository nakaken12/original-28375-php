<?php 
require('dbconnect.php');

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
  $statement = $db->prepare('DELETE FROM posts WHERE id=?');
  $statement->execute(array($_REQUEST['id']));

  header("Location: index.php");
  exit();
}