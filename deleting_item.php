<?php
session_start();

            if(isset($_GET['id']))
            {
              global $idItem;
              $idItem = $_GET['id'];
            }
            else
            {
            	echo "not";
            }

			 require_once ('data/shopDatabase.php');

			 $role_check = $_SESSION['admin_rights'];

			 if($role_check == 1)
			 {



			  $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
			  	$sql=$conn->prepare("DELETE FROM products_db WHERE id_product = ?");
			  	$sql->bindValue(1, $idItem);
			 	 	$sql->execute();

//after deleting ir redirects back to the index page, where the catalogue tables are updated. 
			 	 	header("Location: index.php");



			 }
			 else{
			 	echo "not admin, thank you";
			 }




?>
