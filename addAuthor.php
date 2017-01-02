<?php
require "config.php";
if(!isset($_POST["sent"]) || $_POST["pass"] != $_POST["passc"]) {
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Vytvořit autora</title>
  </head>
  <body>
    <form method="POST" action="?">
      <input type="text" name="name" placeholder="Jméno"><br>
      <input type="password" name="pass" placeholder="Heslo"><br>
      <input type="password" name="passc" placeholder="Heslo podruhé"><br>
      <input type="text" name="subjects" placeholder="Předměty"><br>
      <input type="hidden" name="sent" value="true"><br>
      <input type="submit" value="Vytvořit"><br>
    </form>
  </body>
  <html>
  <?php
} else {
  $db = new PDO(
    "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
    Config::$db_user, Config::$db_pass
  );
  $db->exec("CREATE TABLE IF NOT EXISTS exams (_ID INT AUTO_INCREMENT PRIMARY KEY, `subject` VARCHAR(64), `range` VARCHAR(128), `exam_date` TIMESTAMP, `notes` VARCHAR(4096), `author` INT)");
  $db->exec("CREATE TABLE IF NOT EXISTS authors (author_ID INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(64), `pass` VARCHAR(128), `subjects` VARCHAR(128))");
  $db->exec("CREATE TABLE IF NOT EXISTS exam_files (_ID INT AUTO_INCREMENT PRIMARY KEY, `exam_ID` INT, `name` VARCHAR(128), `type` VARCHAR(8), `data` VARCHAR(256), `author_ID` INT)");
  $query = $db->prepare("INSERT INTO authors (`name`, `pass`, `subjects`) VALUES (?, ?, ?)");
  $query->execute(array($_POST["name"], sha1("AUTHOR" . $_POST["pass"]), $_POST["subjects"]));
}
?>