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
  $subjects = json_decode(file_get_contents("subjects.json"), true);
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Nahlásit písemku</title>
  </head>
  <body>
    <form method="POST" action="?">
      <select name="subject" placeholder="Předmět">
        <?php
          foreach($subjects as $subject) {
            echo "<option value=\"" . $subject["name"] . "\">" . $subject["name"] . "</option>\n";
          }
        ?>
      </select><br>
      <input type="text" name="range" placeholder="Rozsah"><br>
      <textarea name="notes" placeholder="Poznámky"></textarea><br>
      <input type="date" name="date" placeholder="Datum"><br>
      <select name="author" placeholder="Autor">
        <?php
          foreach($authors as $author) {
            echo "<option value=\"" . $author["id"] . "\">" . $author["name"] . "</option>\n";
          }
        ?>
      </select><br>
      <input type="hidden" name="sent" value="true"><br>
      <input type="submit" value="Nahlásit"><br>
    </form>
  </body>
  <html>
  <?php
} else {
  $db->exec("CREATE TABLE IF NOT EXISTS exams (_ID INT AUTO_INCREMENT PRIMARY KEY, `subject` VARCHAR(64), `range` VARCHAR(128), `exam_date` TIMESTAMP, `notes` VARCHAR(4096), `author` INT)");
  $db->exec("CREATE TABLE IF NOT EXISTS authors (author_ID INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(64), `pass` VARCHAR(128), `subjects` VARCHAR(128))");
  $db->exec("CREATE TABLE IF NOT EXISTS exam_files (_ID INT AUTO_INCREMENT PRIMARY KEY, `exam_ID` INT, `name` VARCHAR(128), `type` VARCHAR(8), `data` VARCHAR(256), `author_ID` INT)");
  $query = $db->prepare("INSERT INTO exams (`subject`, `range`, `exam_date`, `notes`, `author`) VALUES (?, ?, ?)");
  $query->execute(array($_POST["subject"], $_POST["range"], $_POST["date"], $_POST["notes"], $_POST["author"]));
}
?>
