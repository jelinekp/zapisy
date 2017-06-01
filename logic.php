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
  $query = $db->prepare("SELECT * FROM exams ORDER BY exam_date ASC;");
  $query->execute();
  $exams = $query->fetchAll();

  $query = $db->prepare("SELECT * FROM exam_files WHERE exam_ID=?");
  foreach($exams as $exam) {
    $eTime = strtotime($exam["exam_date"]);
    $dateStr = date("j.n.Y", $eTime) . " ("
      . get_diff($exam["exam_date"]) . ")";
    if(isset($exam["exam_date_uc"]) && $exam["exam_date_uc"] == 1) {
      switch(mt_rand(0, 2)) {
        case 0: $dateStr = "Asi " . $dateStr; break;
        case 1: $dateStr = "Možná " . $dateStr; break;
        case 2: $dateStr = "Zřejmě " . $dateStr; break;
      }
    }
    $fileStr = "";
    $fileLink = "";
    $fileEnd = "";
    $query->execute([$exam["_ID"]]);
    $files = $query->fetchAll();
    if(count($files) > 0) {
      $fileStr = "<span class=\"attachment\"></span>";
      $fileLink = "<a href=\"" . $files[0]['data'] . "\" class=\"attachment-link\">";
      $fileEnd = "</a>";
    }
    echo "<tr><td class=\"exam-cell\">";
    echo "<a href=\"#delete-exam\" class=\"link-delete trigger\" data-id=\"" . $exam["_ID"] . "\"></a>";
    echo $fileLink;
    echo "<span class=\"link-exam\"><div class=\"exam_item\">";
    echo "<span class=\"exam_subject\">" . $exam["subject"] . ($exam["grp"] == "none" ? "" : " <span class=\"exam_group\">" . $exam["grp"] . "</span> ") . $fileStr . "</span>";
    echo "<span class=\"exam_range\">" . $exam["range"] . "</span>";
    echo "<span class=\"exam_date\">" . $dateStr . "</span>";
    echo "</div></span>";
    echo $fileEnd . "</td></tr>\n";
  }
}

function get_diff($time) {
  $date = new DateTime($time);
  if($date->format("j.n.Y") == date("j.n.Y")) return "dneska";
  $days = ($date->diff(new DateTime())->format("%r%a") * (-1));
  if($days >= 0) $days++;
  if($days == 1) {
    return "zítra";
  } else if ($days == 2) {
    return "pozítří";
  } else if ($days > 4) {
    return "za $days dnů";
  } else if ($days > 2) {
    return "za $days dny";
  } else if ($days == 0) {
    return "dneska";
  } else if ($days == -1) {
    return "včera";
  } else if ($days == -2) {
    return "předevčírem";
  } else if ($days < -4) {
    return abs($days) . " dnů zpátky";
  } else {
    return abs($days) . " dny zpátky";
  }
}

function getUser() {
  if(isset($_SESSION["user"]) && $_SESSION["user"] != "LOGOUT") {
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
  // Maybe headers were already sent
  @header("Location: login.php");
  echo "<script>window.location = \"login.php\";</script>";
}

function make_form(string $name) : boolean {
  if(!file_exists("forms/$name.json")) {
    return false;
  }

  $form = json_decode(file_get_contents("forms/$name.json"), true);
  $str = "<form class=\"form\" action=\"" . $form["action"]["link"]
    . "\" method=\"" . $form["action"]["method"] . "\">";
  if(isset($form["name"])) $str .= "<span class=\"form-name\">"
    . $form["name"] . "</span>";
  foreach($form["components"] as $com) {
    $arr = explode("/", $com["type"]);
    $str .= "<" . $arr[0] . " type=\"" . $arr[1] . "\" ";
    $str .= "name=\"" . $com["name"] . "\" ";
    $str .= "placeholder=\"" . $com["placeholder"] . "\" ";
    if($com["width"] == 0) $str .= "style=\"display: block; width: 100%\"";
    $str .= "/>";
  }

  $str .= "<span class=\"form-submit-note\">"
    . $form["action"]["note"] . "</span>";
  $str .= "<input type=\"submit\" name=\"" . $form["action"]["human"] . "\">";
  $str .= "</form>";
  echo $str;
  
  return true;
}

class V {
  private static $vfile_cache = null;

  static function file(string $name) {
    if(static::$vfile_cache == null) {
      static::$vfile_cache = array();
      $json = json_decode(file_get_contents("version.json"), true);
      foreach($json as $file) {
        static::$vfile_cache[$file["file"]] = $file["version"];
      }
    }

    return "$name?v=" . static::$vfile_cache[$name];
  }
}
?>
