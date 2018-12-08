<?php
require_once "assembler.php";

$classes = [
  '16e',
  '14b',
  '14a'
];

if(isset($_GET['class']) && in_array($_GET['class'], $classes)) {
  Assembler::set_prefix($_GET['class']);
} else {
  Assembler::set_prefix('16e');
}

echo Assembler::assemble("frontpage");

?>
