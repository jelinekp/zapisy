<?php

function assemble_item_group($markup, $vars) {
  $markup = str_replace('$VAR_name$', $vars['group']['name'], $markup);
  $output = '';
  foreach($vars['group']['workbooks'] as $workbook) {
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
  return str_replace('$DYN_workbooks$', $output, $markup);
}

?>