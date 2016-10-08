<?php
require "config.php";
if(!isset($_GET["id"])) header("Location: /");
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);
$query = $db->prepare("SELECT * FROM exams WHERE _ID = ?");
$query->execute(array($_GET["id"]));
$exam = $query->fetchAll()[0];

$query = $db->prepare("SELECT * FROM exam_files WHERE exam_ID = ?");
$query->execute(array($_GET["id"]));
$files = $query->fetchAll();

echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"UTF-8\">";
echo "<link rel=\"shortcut icon\" href=\"img/ikona.ico\"/>";
echo "<link rel=\"apple-touch-icon\" href=\"img/zapisy-512px.png\"/>";
echo "<link rel=\"icon\" type=\"image/png\" href=\"img/zapisy-512px.png\"/>";
echo "<meta name=\"viewport\" content=\"width=device-width, user-scalable=no\"/>";
echo "<meta name=\"author\" content=\"github.com/jelinekp/zapisy\">";
echo "<link href=\"https://fonts.googleapis.com/icon?family=Roboto\" rel=\"stylesheet\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"common.css\"/>";
echo "<link rel=\"stylesheet\" media=\"(min-width: 731px)\" type=\"text/css\" href=\"style.css\"/>";
echo "<link rel=\"stylesheet\" media=\"(max-width: 730px)\" type=\"text/css\" href=\"mobile.css\"/>";
echo "<title>Zápisy</title></head>";
echo "<body>";
echo "<div id=\"container\">";
echo "<h1>" . $exam["subject"] . "</h1>";
echo "<b>" . $exam["range"] . "</b><br/>";
echo date("j.n.Y", strtotime($exam["exam_date"])) . "<br/>";
echo $exam["notes"];
echo "<br><span style=\"text-align: center; width: 100%; display: block;\">© 2016</span>";
echo "</div>";
?>
