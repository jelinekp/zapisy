<?php
require_once "assembler.php";

if(isset($_GET['class'])) {
  Assembler::set_prefix($_GET['class'] . '/');
}

echo Assembler::assemble("frontpage");

?>
