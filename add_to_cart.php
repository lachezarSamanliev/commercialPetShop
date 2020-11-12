<?php
session_start();


//retrieves values from the a href, that are used to 
if(isset($_GET['id_sale']))
            {
              $id_of_item = $_GET['id_sale'];
            }

            if(isset($_GET['name_sale']))
            {
              $name_of_item = $_GET['name_sale'];
            }

            if(isset($_GET['price_sale']))
            {
              $price_of_item = $_GET['price_sale'];
            }

//this function is used to test user input data and then returns it back to be stored in variables. 
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

<!--   This particular html code with its STYLE is used in a couple of palces.
      It basically creates a border box which can be used as a container and it has
      the option of putting a second box to it.
-->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        * {
          box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
          float: left;
          width: 65%;
          padding: 10px;

        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }

        .description_item{
          height: 200px;
          font-size:11pt;
        }


</style>
</head>
<body>

   <?php


      $status ="";


        $role_check = $_SESSION['admin_rights'];
        $user_email = $_SESSION['logged_user'];



        //0 means that the user is a customer
        if($role_check == 0)
        {
                require_once('model/nav.php');
                require_once ('data/shopDatabase.php');
                require_once('model/cart_list.php');

            
            if (isset($_GET['id_sale']))
            {

                //The next piece of code will be run only when the form is submitted.
                   if(isset($_POST['new']) && $_POST['new'] == 1)
                    {



                    	try{
                              		$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
                                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                      if(empty($_POST["quantity_item"]))
                    								{
                    									$quantity_sale = 1;
                    								}
                    								else
                    								{
                    									$quantity_sale = test_input($_POST["quantity_item"]);
                    								}

                    								$sql = "INSERT INTO shopping_cart (user_email, id_chosen_item, price_chosen_item, quantity_chosen_item, name_chosen_item) VALUES (?, ?, ?, ?, ?)";
          										
          										
          										$stmt = $conn->prepare($sql);
          										$stmt->bindValue(1, $user_email);
          										$stmt->bindValue(2, $id_of_item);
          										$stmt->bindValue(3, $price_of_item);
          										$stmt->bindValue(4, $quantity_sale);
          										$stmt->bindValue(5, $name_of_item);
          										
          										$stmt->execute();
          										header("Location: index.php");


						        	}catch (PDOException $e) {
                                echo "Connection failed: ";
                                echo $e;
                                }
                       
                            $conn = null;
                }else{

                    			}
   



     ?>
     		 
                  <!-- a form that is presented to the user
                    they can choose how much of the item they want to add to cart
                    by default, if left at 0, the quantity will be 1
                  -->
							                 <form method = "POST" action = "">
							                  <input type = "hidden" name="new" value ="1"/>
							                 <table width = "350" border = "0" cellspacing = "1" cellpadding = "2">
							                    <tr>
							                       <td width = "250">Name: <?php echo $name_of_item ?></td>

							                    </tr>

							                    <tr>
							                       <td width = "250">Price for 1: <?php echo $price_of_item ?></td>

							                    </tr>

							                    <tr>
							                       <td width = "250">Quantity</td>
							                       <td>
							                          <input name = "quantity_item" type = "text" id = "quantity_item">
							                       </td>
							                    </tr>


							                    <tr>
							                       <td width = "250"> </td>
							                       <td>
							                          <input name = "add" type = "submit" id = "edit"  value = "Add to List">
							                       </td>
							                    </tr>
							                 </table>
							                </form>


							               </div>



 <?php

			 	}else{


                     }

       	


     	//else for login rights check
       }else
       {
       	echo "Please log in";
       }

							               ?>

