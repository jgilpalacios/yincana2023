<?php
$host= $_SERVER["HTTP_HOST"];
$CARPETA= $_SERVER["REQUEST_URI"];
echo "http://" . $host . $CARPETA."<br>";
echo "http://" . $host ."<br>";
echo "http://" . $CARPETA."<br>";
echo strrpos ( "http://" . $host . $CARPETA ,  "/" )."<br>";
echo "http://" . substr($host . $CARPETA, 0, strrpos ( $host . $CARPETA ,  "/" ));
?>
