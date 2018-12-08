<?php

$srvRoot = "/";

require_once('util.php');
require_once "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);

$user = get_user();
if(isset($_POST["sent"]) && $user !== null) {
  $date = DateTime::createFromFormat('!d.m.Y', $_POST["date"])->getTimestamp();
  $db->exec("CREATE TABLE IF NOT EXISTS exams (_ID INT AUTO_INCREMENT PRIMARY KEY, `subject` VARCHAR(64), `range` VARCHAR(128), `exam_date` TIMESTAMP, `notes` VARCHAR(4096), `author` INT, `exam_date_uc` INT, `grp` VARCHAR(32), `class` VARCHAR(8))");
  $db->exec("CREATE TABLE IF NOT EXISTS authors (author_ID INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(64), `pass` VARCHAR(128), `subjects` VARCHAR(128), `class` VARCHAR(8))");
  $db->exec("CREATE TABLE IF NOT EXISTS exam_files (_ID INT AUTO_INCREMENT PRIMARY KEY, `exam_ID` INT, `name` VARCHAR(128), `type` VARCHAR(8), `data` VARCHAR(256), `author_ID` INT)");
  $query = $db->prepare("INSERT INTO exams (`subject`, `range`, `exam_date`, `notes`, `author`, `grp`, `class`) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $subname = strpos($_POST["subject"], '(') != 0 ? substr($_POST["subject"], 0, strpos($_POST["subject"], '(')) : substr($_POST["subject"], 0, strpos($_POST["subject"], ';'));
  $query->execute(array($subname, $_POST["range"], date("Y-m-d", $date), $_POST["notes"], $user['id'], substr($_POST["subject"], strpos($_POST["subject"], ';') + 1), $user['class']));
  header("Location: $srvRoot");
} else {
  header("Location: $srvRoot");
}

?>
