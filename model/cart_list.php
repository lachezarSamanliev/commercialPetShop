
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
  <table class="table table-hover">
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
//this foreach is used to fetch data from each row of the database
//values are assigned to php variables and then called inside the table
//some values are used for the a href links

    	foreach($data as $i)
 		{	

 			$nameItem = $i['name_chosen_item'];
 			$priceItem = $i['price_chosen_item'];
 			$quantityItem = $i['quantity_chosen_item'];
 			$idItem = $i['id_chosen_item'];
 			$userEmail = $i['user_email'];
 	?>

	 		<tr>
			<td> <?php echo $nameItem; ?></td>
			<td> <span>&#163;</span> <?php echo $priceItem; ?> </td>
			<td> <?php echo $quantityItem; ?> </td>
     <td> <a href = 'deleting_item_from_cart.php?id_to_delete=<?php echo$idItem;?>'>Delete Item</a></td>
      </tr>


<?php

 		}

        $conn = null; 

 ?>

</tbody>
</table>
</div>
</body>
</html>


