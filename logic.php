<?php
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
      echo "<div class=\"subject-icon\" style=\"background-image: url('" . $sub["icon"] . "')\">";
    }
    if(isset($sub["archive"])) {
      echo "<a href=\"" . $sub["archive"] . "\"><div class=\"link-archive\">";
      echo "<span class=\"link-archive-text\">Archiv</span></div></a>";
    }
    echo "</td></tr>\n";
  }
}

function make_exams() {

}
?>
