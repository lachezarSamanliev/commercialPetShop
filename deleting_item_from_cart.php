<?php
session_start();

            if(isset($_GET['id_to_delete']))
            {
            	global $delete_cart_id;
              $delete_card_id = $_GET['id_to_delete'];
            }
            else
            {
            	echo "not";
            }

			 require_once ('data/shopDatabase.php');

                  
                   $delete = "DELETE FROM shopping_cart WHERE id_chosen_item = ?";
			       $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
			 	 	$stmt=$conn->prepare($delete);
			 		$stmt->bindValue(1, $delete_card_id);
			 	 	$stmt->execute();



                                      if($stmt->execute())
                                       {
                                        
                                        header("Location: add_to_cart.php");
                                       }
                                      else
                                       {
                                       echo "Something went bad with deletion";
                                       }


?>
