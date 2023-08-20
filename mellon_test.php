<?php
header('Content-Type: text/plain');

foreach($_SERVER as $key=>$value) {
  if(substr($key, 0, 7) == 'MELLON_') {
    echo($key . '=' . $value . "\r\n");
  }
}

echo "\n\nIf logged in you should see your session information above this.";
?>

