<?php
require "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);
if(!isset($_POST["sent"])) {
  $query = $db->prepare("SELECT name, author_ID AS id FROM authors");
  $query->execute();
  $authors = $query->fetchAll();
  $query = $db->prepare("SELECT subject, exam_date AS `date`, _ID AS id FROM exams");
  $query->execute();
  $exams = $query->fetchAll();
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Přidat soubor</title>
  </head>
  <body>
    <form method="POST" action="?">
      <select name="exam" placeholder="Písemka">
        <?php
          foreach($exams as $exam) {
            echo "<option value=\"" . $exam["id"] . "\">" . $exam["subject"] .
             " - " . date("j.n.Y", strtotime($exam["date"])) . "</option>\n";
          }
        ?>
      </select><br>
      <input type="text" name="name" placeholder="Jméno souboru"><br>
      <input type="text" name="type" placeholder="Typ"><br>
      <input type="text" name="data" placeholder="Obsah"><br>
      <select name="author" placeholder="Autor">
        <?php
          foreach($authors as $author) {
            echo "<option value=\"" . $author["id"] . "\">" . $author["name"] . "</option>\n";
          }
        ?>
      </select><br>
      <input type="hidden" name="sent" value="true"><br>
      <input type="submit" value="Vytvořit"><br>
    </form>
  </body>
  <html>
  <?php
} else {
  $db->exec("CREATE TABLE IF NOT EXISTS exams (_ID INT AUTO_INCREMENT PRIMARY KEY, `subject` VARCHAR(64), `range` VARCHAR(128), `exam_date` TIMESTAMP, `notes` VARCHAR(4096), `author` INT)");
  $db->exec("CREATE TABLE IF NOT EXISTS authors (author_ID INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(64), `pass` VARCHAR(128), `subjects` VARCHAR(128))");
  $db->exec("CREATE TABLE IF NOT EXISTS exam_files (_ID INT AUTO_INCREMENT PRIMARY KEY, `exam_ID` INT, `name` VARCHAR(128), `type` VARCHAR(8), `data` VARCHAR(256), `author_ID` INT)");
  $query = $db->prepare("INSERT INTO exam_files (`exam_ID`, `name`, `type`, `data`, `author_ID`) VALUES (?, ?, ?, ?, ?)");
  $query->execute(array($_POST["exam"], $_POST["name"], $_POST["type"], $_POST["data"], $_POST["author"]));
  echo $query->errorInfo()[2];
}
?>