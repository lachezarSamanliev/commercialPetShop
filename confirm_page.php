<?php
session_start();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


require_once ('data/shopDatabase.php');

 $role_check = $_SESSION['admin_rights'];

  $total_amount = $_SESSION['totalPrice'];
  $card_information = $_SESSION['card_info'];
  $email_of_client = $_SESSION['logged_user'];



  //string to keep track of item ID and qunatities purchased
  $id_and_quantity_and_all = "";

  //some bools for database checks
  $checker_one = 0;
  $checker_two = 0;
  $checker_three = 0;
  $checker_four = 0;

//here it gets a little bit webby
//when the confirm button is clicked
//all the data is fetched from the shopping_cart database
//next the original qunatity is pulled from the products_db
  //the new quantity is calculated and updated into products_db
  //the user histroy is updated with the appropriate string
  //record from shopping cart DB are deleted. 

 $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 $sql = $conn->prepare("SELECT * FROM shopping_cart WHERE user_email=?");
 $sql->bindValue(1, $email_of_client);
 $sql->execute();
 $sql->setFetchMode(PDO::FETCH_ASSOC);
 $data = $sql->fetchAll();


   if(isset($_POST['new']) && $_POST['new'] == 1)
   {

				 foreach($data as $i)
				 {
					 	$nameItem = $i['name_chosen_item'];
					 	$priceItem = $i['price_chosen_item'];
					 	$quantityItem = $i['quantity_chosen_item'];
					 	$idItem = $i['id_chosen_item'];
					    $userEmail = $i['user_email'];

					    //now get total quantity.
					     $conn_two = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
					    $sql_two = $conn_two->prepare("SELECT quantity_product FROM products_db WHERE id_product=? LIMIT 1");

					    $sql_two->bindParam(1, $idItem);

					     $sql_two->execute();

					     if($sql_two->execute())
					     {

					     }
					     else
					     {

					     }

					     if ($arr = $sql_two->fetch(PDO::FETCH_ASSOC)) {

						    $quantity_original = $arr['quantity_product'];



						    $quantity_new = $quantity_original - $quantityItem;


						    	 $conn_three = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

						     $update = "UPDATE products_db SET quantity_product=? WHERE id_product=?";
						     $sql_three = $conn_three->prepare($update);
						     $sql_three->bindValue(1, $quantity_new);
						     $sql_three->bindValue(2, $idItem);
						     $sql_three->execute();
						      if($sql_three->execute())
					           {
					            $checker_one = 1;
					           }
					           else
					           {
					            echo "Something went bad with quantity update";
					           }


					//have string that is updated with new quantity and new item ID
					//after for each card info + total is added to history of user. 



						 }else{

						 }


						$items = $idItem . '+' . $quantityItem;
						//foreach end
				 }

				 	//update user database
				 	$id_and_quantity_and_all = $items . '+' . $card_information . '+' . $total_amount;

				 	//first select string of history
				 	 $conn_four = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
				 	 $sql_four = $conn_four->prepare("SELECT shopping_history FROM user_db WHERE email_user =? LIMIT 1");

				    $sql_four->bindParam(1, $email_of_client);

				     $sql_four->execute();

				     if ($arr_two = $sql_four->fetch(PDO::FETCH_ASSOC)) {

					    $shopping_history_original = $arr_two['shopping_history'];

					    $new_history= $shopping_history_original . 'and' . $id_and_quantity_and_all;




					     $conn_five = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
					     $update_two = "UPDATE user_db SET shopping_history=? WHERE email_user=?";
					     $sql_five = $conn_five->prepare($update_two);
					     $sql_five->bindValue(1, $new_history);
					     $sql_five->bindValue(2, $email_of_client);
					     $sql_five->execute();
					      if($sql_five->execute())
				           {
				            $checker_two = 1;
				           }
				           else
				           {
				            echo "Something went bad with user history update";
				           }
				       }


				       	        $conn_six = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
						 	  	$sql_six=$conn_six->prepare("DELETE FROM shopping_cart WHERE user_email = ?");
							  	$sql_six->bindValue(1, $email_of_client);
							 	 $sql_six->execute();

							 	 if($sql_six->execute())
							 	 {
							 	 	$checker_three = 1;
							 	 }
							 	 else
							 	 {
							 	 	echo "error with deleting cart";
							 	 }



					//if all checkers are one that means databases manipulation was done okay
							 	 if($checker_one == 1 && $checker_two == 1 && $checker_three = 1)
							 	 {
							 	 	header("location: index.php");
							 	 }
							 	 else{
							 	 	echo "well try again";
							 	 }

    }
    else{

    }





?>




 







<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
        

</style>
</head>
<body>




<!-- simple html form wiht one button that
	when form us submitted, the changes to the database occur
-->
				<div class='column' style='background-color:#aaa;'>
                   
                        <p><b>Confirm Purchase please</b></p>
                       
                     <form method = "POST" action = "">
                      <input type = "hidden" name="new" value ="1"/>
                     <table width = "150" border = "0" cellspacing = "1" cellpadding = "2">
                       
                     
                        <tr>
                           <td width = "450"> </td>
                           <td>
                              <input name = "add" type = "submit" id = "edit"  value = "Confirm Purchase">
                           </td>
                        </tr>
                     </table>
                  </form>


                 </div>







</body>
</html>