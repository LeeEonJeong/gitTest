 
<!DOCTYPE html>
<html>
<body>
<?php
$xml=simplexml_load_file("my.xml") or die("Error: Cannot create object");
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title; 
?>
</body>
</html>

 