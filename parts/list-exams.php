<?php
require_once('config.php');

function assemble_list_exams($markup, $vars) {
  $output = '';

  $db = new PDO(
    'mysql:host=' . Config::$db_host . ';dbname=' . Config::$db_name,
    Config::$db_user, Config::$db_pass
  );
  $query = $db->prepare('SELECT * FROM exams ORDER BY exam_date ASC;');
  $query->execute();
  $exams = $query->fetchAll();
  $query = $db->prepare('SELECT * FROM exam_files WHERE exam_ID=?');
  foreach($exams as $exam) {
    $part = 'item-exam';

    $eTime = strtotime($exam['exam_date']);
    $dateStr = date('j.n.Y', $eTime) . ' ('
      . get_diff($exam['exam_date']) . ')';
    if(isset($exam['exam_date_uc']) && $exam['exam_date_uc'] == 1) {
      switch(mt_rand(0, 2)) {
        case 0: $dateStr = 'Asi ' . $dateStr; break;
        case 1: $dateStr = 'Možná ' . $dateStr; break;
        case 2: $dateStr = 'Zřejmě ' . $dateStr; break;
      }
    }

    $vars = array(
      'id'          => $exam['_ID'],
      'subject'     => $exam['subject'],
      'range'       => $exam['range'],
      'date-string' => $dateStr
    );

    if($exam['grp'] != 'none') {
      $part .= '-group';
      $vars['group'] = $exam['grp'];
    }

    $query->execute([$exam['_ID']]);
    $files = $query->fetchAll();
    if(count($files) > 0) {
      $part .= '-attachment';
      $vars['attachment'] = $files[0]['data'];
    }

    $output .= Assembler::assemble($part, $vars);
  }
  return str_replace('$DYN_table$', $output, $markup);
}
?>