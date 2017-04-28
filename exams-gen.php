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
    default: $version = 1;
  }
}

$query = $db->prepare("SELECT * FROM exams ORDER BY exam_date ASC;");
$query->execute();
$exams = $query->fetchAll();

$first = true;
echo '{"version":' . $version . ',"exams":[';
foreach($exams as $exam) {
  if(!$first) echo ",";
  echo "{";
    if($version >= 2) {
      echo '"subject":"' . substr($exam["subject"], 0, strpos($exam["subject"], '(') - 1) . '",';
    } else {
      echo '"subject":"' . $exam["subject"] . '",';
    }
    echo '"range":"' . $exam["range"] . '",';
    echo '"date":"' . date("j.n.Y", strtotime($exam["exam_date"])) . '",';
    echo '"id":' . $exam["_ID"] . ',';
    if($version >= 2 && strpos($exam["subject"], '(') > 0) {
      $str = $exam["subject"];
      echo '"group":"' . substr($str, strpos($str, '(') + 1, strpos($str, ')') - strpos($str, '(') - 1) . '",';
    }
  echo "}";
  $first = false;
}
echo "]}";
?>
