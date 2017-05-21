<?php
require "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);

$version = 1;
if(isset($_GET['v'])) {
  switch($_GET['v']) {
    case 2: $version = 2; break;
    case 3: $version = 3; break;
    default: $version = 1;
  }
}

$query = $db->prepare("SELECT * FROM exams ORDER BY exam_date ASC;");
$query->execute();
$exams = $query->fetchAll();

$query = $db->prepare("SELECT * FROM exam_files WHERE exam_ID=?");

$first = true;
echo '{"version":' . $version . ',"exams":[';
foreach($exams as $exam) {
  $query->execute([$exam["_ID"]]);
  $files = $query->fetchAll();
  if(!$first) echo ",";
  echo "{";
    if($version >= 2) {
      $substr = strpos($exam["subject"], '(') > 0 ? substr($exam["subject"], 0, strpos($exam["subject"], '(') - 1) : $exam["subject"];
      echo '"subject":"' . $substr . '",';
    } else {
      echo '"subject":"' . $exam["subject"] . '",';
    }
    echo '"range":"' . $exam["range"] . '",';
    echo '"date":"' . date("j.n.Y", strtotime($exam["exam_date"])) . '",';
    if($version >= 2 && $exam["grp"] != "none") {
      echo '"group":"' . $exam["grp"] . '",';
    }
    if($version >= 3 && count($files) > 0) {
      echo '"link":{"type":"' . $files[0]["type"] . '","data":"' . $files[0]["data"] . '"},';
    }
    if($version == 1) {
      echo '"notes":"' . $exam["notes"] . '",';
      echo '"author":"' . $exam["author"] . '",';
    }
    echo '"id":' . $exam["_ID"];
  echo "}";
  $first = false;
}
echo "]}";
?>
