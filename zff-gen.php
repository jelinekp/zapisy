<?php
echo json_encode(json_decode(file_get_contents("https://markaos.cz/zff")), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
