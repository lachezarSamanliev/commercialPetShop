<?php
session_start();

            if(isset($_GET['id_to_delete_checkout']))
            {
            	global $delete_checkout_id;
              $delete_checkout_id = $_GET['id_to_delete_checkout'];
            }
            else
            {
            	echo "not";
            }

			 require_once ('data/shopDatabase.php');

                  
                   $delete = "DELETE FROM shopping_cart WHERE id_chosen_item = ?";
			       $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
			 	 	$stmt=$conn->prepare($delete);
			 		$stmt->bindValue(1, $delete_checkout_id);
			 	 	$stmt->execute();



                                      if($stmt->execute())
                                       {
                                       
                                        header("Location: checkout_page.php");
                                       }
                                      else
                                       {
                                       echo "Something went bad with deletion";
                                       }


?>
