<?php
require "config.php";

function make_subjects() {
  $subs = json_decode(file_get_contents("workbooks.json"), true);
  foreach($subs as $sub) {
    echo "<tr><td>";
    echo "<a href=\"" . $sub["url"] . "\"><div class=\"link\"><span class=\"link-text\">";
    if(isset($sub["deprecated"]) && $sub["deprecated"] == true) {
      echo "<span class=\"smoother\">";
    }
    echo $sub["name"];
    if(isset($sub["deprecated"]) && $sub["deprecated"] == true) {
      echo "</span>";
    }
    echo "</span></div>";
    if(isset($sub["icon"])) {
      echo "<div class=\"subject-icon\" style=\"background-image: url('" . $sub["icon"] . "')\"></div>";
    }
    if(isset($sub["archive"])) {
      echo "<a href=\"" . $sub["archive"] . "\"><div class=\"link-archive\">";
      echo "<span class=\"link-archive-text\">Archiv</span></div></a>";
    }
    echo "</td></tr>\n";
  }
}

function make_exams() {
  $db = new PDO(
    "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
    Config::$db_user, Config::$db_pass
  );
  $query = $db->prepare("SELECT * FROM exams;");
  $query->execute();
  $exams = $query->fetchAll();

  foreach($exams as $exam) {
    echo "<tr><td>";
    echo "<a class=\"link-exam\" href=\"exam.php?id=" . $exam["_ID"] . "\"><div class=\"exam_item\">";
    echo "<span class=\"exam_subject\">" . $exam["subject"] . "</span>";
    echo "<span class=\"exam_range\">" . $exam["range"] . "</span>";
    echo "<span class=\"exam_date\">" . date("j.n.Y", strtotime($exam["exam_date"])) . "</span>";
    echo "</div></a>";
    echo "</td></tr>\n";
  }

  function getUser() {
    if(!isset($_SESSION["user"] || $_SESSION["user"] == "LOGOUT")) {
      // We are running with extremely low traffic - waiting a bit longer is OK here
      $db = new PDO(
        "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
        Config::$db_user, Config::$db_pass
      );
      $query = $db->prepare("SELECT user_ID FROM users WHERE name = ?;");
      $query->execute(array($_SESSION["user"]));
      $users = $query->fetchAll();
      if(count($users) == 1) return true;
    }
    return false;
  }

  function login() {
    $_SESSION["return"] = $_SERVER["REQUEST_URI"];
    @header("Location: login.php");
    echo "<script>window.location = \"login.php\";</script>";
  }
}
?>
