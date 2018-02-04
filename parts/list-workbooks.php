<?php

function assemble_list_workbooks($markup, $vars) {
  $output = '';
  if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'classic') {
    foreach(json_decode(file_get_contents('workbooks.json'), true) as $workbook) {
      $part = 'item-workbook';
      if(isset($workbook["deprecated"]) && $workbook["deprecated"] == true) {
        $part = 'item-workbook-deprecated';
      }

      $output .= Assembler::assemble($part, array(
        'name'        => $workbook['name'],
        'icon'        => $workbook['icon'],
        'url'         => $workbook['url'],
        'url-archive' => $workbook['archive']
      ));
    }
  } else {
    foreach(json_decode(file_get_contents('workbooks-grouped.json'), true) as $group) {
      $output .= Assembler::assemble('item-group', array(
        'group'       => $group
      ));
    }
  }
  return str_replace('$DYN_table$', $output, $markup);
}

?>