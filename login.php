<?php
require_once('util.php');
if(isset($_POST['code'])) {
  setcookie('code', $_POST['code'], time() + 60*60*24*365*20);
}
header('Location: /');
?>