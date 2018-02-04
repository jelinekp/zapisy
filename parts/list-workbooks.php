<?php

function assemble_list_workbooks($markup, $vars) {
  $output = '';
  foreach(json_decode(file_get_contents('workbooks.json'), true) as $workbook) {
    $part = 'item-workbook';
    if(isset($sub["deprecated"]) && $sub["deprecated"] == true) {
      $part = 'item-workbook-deprecated';
    }

    $output .= Assembler::assemble($part, array(
      'name'        => $workbook['name'],
      'icon'        => $workbook['icon'],
      'url'         => $workbook['url'],
      'url-archive' => $workbook['archive']
    ));
  }
  return str_replace('$DYN_table$', $output, $markup);
}

?>