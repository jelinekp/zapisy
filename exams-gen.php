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
echo '{"version":1,"exams":[';
foreach($exams as $exam) {
  if(!$first) echo ",";
  echo "{";
    echo '"subject":"' . $exam["subject"] . '",';
    echo '"range":"' . $exam["range"] . '",';
    echo '"date":"' . date("j.n.Y", strtotime($exam["exam_date"])) . '",';
    echo '"notes":"' . $exam["notes"] . '",';
    echo '"author":"' . $exam["author"] . '"';
  echo "}";
  $first = false;
}
echo "]}";
?>
