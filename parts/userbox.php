<?php
require_once('util.php');

function assemble_userbox($markup, $vars) {
  $user = get_user();
  $markup = preg_replace_callback('%\$COND-FALSE\$((.|\n)*?)\$COND-END\$%', function($matches) use($user) {
    if($user === null) {
      return $matches[1];
    } else {
      return '';
    }
  }, $markup);

  $markup = preg_replace_callback('%\$COND-TRUE\$((.|\n)*?)\$COND-END\$%', function($matches) use($user) {
    if($user === null) {
      return '';
    } else {
      return str_replace('$DYN_name$', $user['name'], $matches[1]);
    }
  }, $markup);

  return $markup;
}

?>