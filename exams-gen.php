<?php
require "config.php";
$db = new PDO(
  "mysql:host=" . Config::$db_host . ";dbname=" . Config::$db_name,
  Config::$db_user, Config::$db_pass
);
$query = $db->prepare("SELECT * FROM exams ORDER BY exam_date ASC;");
$query->execute();
$exams = $query->fetchAll();

$first = true;
echo '{"version":2,"exams":[';
foreach($exams as $exam) {
  if(!$first) echo ",";
  echo "{";
    echo '"subject":"' . $exam["subject"] . '",';
    echo '"range":"' . $exam["range"] . '",';
    echo '"date":"' . date("j.n.Y", strtotime($exam["exam_date"])) . '",';
    echo '"id":' . $exam["_ID"] . ',';
    if(strpos($exam["subject"], '(') > 0) {
      $str = $exam["subject"];
      echo '"group":"' . substr($str, strpos($str, '(') + 1, strpos($str, ')') - strpos($str, '(') - 1) . '",';
    }
  echo "}";
  $first = false;
}
echo "]}";
?>
