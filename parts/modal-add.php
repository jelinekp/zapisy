<?php
require_once('provider.php');

function assemble_modal_add($markup, $vars) {
  $subjects = Provider::getSubjects();
  $output = '';
  foreach($subjects as $subject) {
    $output .= '<option value="' . $subject['name'] . ';' . $subject['group'] .'">' . $subject['name'] . '</option>\n';
  }
  return str_replace('$DYN_subjects$', $output, $markup);
}
?>