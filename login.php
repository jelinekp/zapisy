<?php
require_once('util.php');
if(isset($_POST['code'])) {
  setcookie('code', $_POST['code'], time() + 60*60*24*365*20);
  $_COOKIE['code'] = $_POST['code'];
  $user = get_user();
  header('Location: /?class=' . $user['class']);
} else {
  header('Location: /');
}
?>
