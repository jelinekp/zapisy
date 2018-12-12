<?php
$srvRoot = "/";

require_once('util.php');
require_once('config.php');

$user = get_user();

$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);

if(isset($_POST["id"]) && $user !== null) {
  $query = $db->prepare("DELETE FROM exams WHERE _ID = ?");
  $query->execute(array($_POST["id"]));
  header("Location: $srvRoot/?class=" . $user['class']);
}

header("Location: $srvRoot");
?>
