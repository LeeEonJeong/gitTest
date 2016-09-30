<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
 
</head>

<body>
<?php
include ('listAvailableProductTypes.php');
 
 
$listProductTypes = sortProductTypes('templateid');

// myPrint($listProductTypes);
// echo '<br>------<br>';

$index=0;

foreach($listProductTypes as $templateid => $productTypes){
		echo "<a href='cloudSpec.php?templateid=".$templateid."'>".$productTypes[0]['templatedesc']."</a><br>";
}
?> 

</body>
</html>
