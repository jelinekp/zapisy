<?php
require "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);

if(isset($_GET["aid"])) {
  $query = $db->prepare("DELETE FROM authors WHERE author_ID = ?");
  $query->execute(array($_GET["aid"]));
  $query = $db->prepare("DELETE FROM exam_files WHERE exam_ID IN (SELECT _ID FROM exams WHERE author = ?)");
  $query->execute(array($_GET["aid"]));
  $query = $db->prepare("DELETE FROM exams WHERE author = ?");
  $query->execute(array($_GET["aid"]));
  $query = $db->prepare("DELETE FROM exam_files WHERE author_ID = ?");
  $query->execute(array($_GET["aid"]));
}

if(isset($_GET["eid"])) {
  $query = $db->prepare("DELETE FROM exam_files WHERE exam_ID IN (SELECT _ID FROM exams WHERE author = ?)");
  $query->execute(array($_GET["aid"]));
  $query = $db->prepare("DELETE FROM exams WHERE _ID = ?");
  $query->execute(array($_GET["eid"]));
}

if(isset($_GET["fid"])) {
  $query = $db->prepare("DELETE FROM exam_files WHERE _ID = ?");
  $query->execute(array($_GET["fid"]));
}

$query = $db->prepare("SELECT author_ID, name, subjects FROM authors");
$query->execute();
$authors = $query->fetchAll();

$query = $db->prepare("SELECT _ID, subject, exam_date FROM exams");
$query->execute();
$exams = $query->fetchAll();

$query = $db->prepare("SELECT exam_files._ID, name, exams.subject AS subject FROM exam_files LEFT JOIN exams ON exams._ID = exam_files.exam_ID");
$query->execute();
$files = $query->fetchAll();

echo "<h1>Autoři</h1>";
foreach($authors as $author) {
  echo "<div>" . $author["name"] . " (správce " . $author["subjects"] .
    ") <a href=\"?aid=" . $author["author_ID"] . "\">smazat</a></div>";
}

echo "<h1>Písemky</h1>";
foreach($exams as $exam) {
  echo "<div>" . $exam["subject"] . " - " . date("j.n.Y", strtotime($exam["exam_date"])) .
    " <a href=\"?eid=" . $exam["_ID"] . "\">smazat</a></div>";
}

echo "<h1>Soubory</h1>";
foreach($files as $file) {
  echo "<div>" . $file["subject"] . " - " . $file["name"] .
    " <a href=\"?fid=" . $file["_ID"] . "\">smazat</a></div>";
}
?>
