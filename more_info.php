<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Pet Shop</title>

  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
</head>

<body>
	
<?php

	require_once('model/nav.php');
	require_once ('data/shopDatabase.php');



  try {

         $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//uses this method to get the id of the item that was passed using the href link
    $id_item = $_GET['id'];

	  $query = "SELECT id_product, name_product, price_product, quantity_product, product_description From products_db Where id_product=? LIMIT 1";

         $stmt = $conn->prepare($query);
         $stmt->bindParam(1, $id_item);

         $stmt->execute();
         if ($arr = $stmt->fetch(PDO::FETCH_ASSOC)) {

         	echo  " Name :{$arr['name_product']} <br> ".
         " Price: {$arr['price_product']} <br> ".
         " Quantity: {$arr['quantity_product']} <br> ".
         "Description: {$arr['product_description']} <br> ";


         }
         else
         {
         	echo "sth broke";
         }
         } catch (PDOException $e) {
         echo "Connection failed: ";
     }
   
   		$conn = null;


?>


	
</body>

</html>