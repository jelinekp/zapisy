<?php
$srvRoot = "/zapisy";

require "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);

if(isset($_POST["id"])) {
  $query = $db->prepare("DELETE FROM exams WHERE _ID = ?");
  $query->execute(array($_POST["id"]));
}

header("Location: $srvRoot");
?>