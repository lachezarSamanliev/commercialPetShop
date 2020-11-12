
<?php




require_once ('data/shopDatabase.php');


    $role_check = $_SESSION['admin_rights'];
    $user_email = $_SESSION['logged_user'];


 $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 $sql = $conn->prepare("SELECT * FROM shopping_cart WHERE user_email=?");
 $sql->bindValue(1, $user_email);
 $sql->execute();
 $sql->setFetchMode(PDO::FETCH_ASSOC);
 $data = $sql->fetchAll();

 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
  <h2>Your Cart</h2>        
  <table class="table table-borderless">
    <thead>
      <tr>
        <th>Product name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Delete</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

<?php
$totalAmount = 0;

    	foreach($data as $i)
 		{	

 			$nameItem = $i['name_chosen_item'];
 			$priceItem = $i['price_chosen_item'];
 			$quantityItem = $i['quantity_chosen_item'];
 			$idItem = $i['id_chosen_item'];
       $userEmail = $i['user_email'];
       
       //the value of total amount is updated with each new row.
       //
      $totalAmount += $priceItem *  $quantityItem;



 	?>

	 		<tr>
			<td> <?php echo $nameItem; ?></td>
			<td> <span>&#163;</span> <?php echo $priceItem; ?> </td>
			<td> <?php echo $quantityItem; ?> </td>
     <td> <a href = 'deleting_item_from_checkout.php?id_to_delete_checkout=<?php echo$idItem;?>'>Delete Item</a></td>
			</tr>

<?php

 		}


        $conn = null; 

         $num_err = $expire_err = $cvv_err = "";
        $cardNum = $cardExpire = $cardCvv = "";



//checks if form is submitted
         if(isset($_POST['new']) && $_POST['new'] == 1)
         {
          //checks for empty values and creates error strings
          //if not empty it takes the value from the form.
          if(empty($_POST["card_num"]))
                {
                  $num_err = "Please provide Card number";
                }
                else{
                  $cardNum = $_POST["card_num"];
                }

          if(empty($_POST["card_expire"]))
          {
            $expire_err = "Please provide Expiration Date";
          }
          else
          {
            $cardExpire = $_POST["card_expire"];
          }
          if(empty($_POST["card_cvv"]))
          {
            $cvv_err = "Please provide CVV";
          }
          else
          {
            $cardCvv = $_POST["card_cvv"];
          }

//if statement that will only work and all three fields are filled in. 
        if(!(empty($cardNum)) && !(empty($cardExpire)) && !(empty($cardCvv)))
        {
          $_SESSION['totalPrice'] =$totalAmount;
          $full_card = $cardNum . '' . $cardExpire . '' . $cardCvv;
          $_SESSION['card_info'] = $full_card;

          header("location: confirm_page.php");
        }
        else{
          echo "sth wrong";
        }

                
      }else{

      }


    
?>


</tbody>
</table>
</div>




<h2>Total Amount of purchase is: &pound;<?php echo $totalAmount ?></h2>
<form method = "POST" action = "">
      <input type = "hidden" name="new" value ="1"/>
      
     <table width = "250" border = "0" cellspacing = "1" cellpadding = "2">
        <tr>
           <td width = "250">Credit Card Number</td>
           <td>
              <input name = "card_num" type = "text" id = "card_num"><span><?php echo $num_err; ?></span></sp>
           </td>
        </tr>

        <tr>
           <td width = "250">Expire Date</td>
           <td>
              <input name = "card_expire" type = "text" id = "card_expire"><span><?php echo $expire_err; ?></span></sp>
           </td>
        </tr>

        <tr>
           <td width = "250">Card CVV</td>
           <td>
              <input name = "card_cvv" type = "text" id = "card_cvv"><span><?php echo $cvv_err; ?></span></sp>
           </td>
        </tr>

    
        <tr>
           <td width = "250"> </td>
           <td> </td>
        </tr>
     
        <tr>
           <td width = "550"> </td>
           <td>
              <input name = "purchase" type = "submit" id = "purchase"  value = "Purchase Item">
           </td>
        </tr>
     </table>
  </form>





</body>
</html>


