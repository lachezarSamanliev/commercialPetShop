
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


<?php

require_once ('data/shopDatabase.php');

 $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 $sql = $conn->prepare("SELECT * FROM products_db");
 $sql->execute();
 $sql->setFetchMode(PDO::FETCH_ASSOC);
 $data = $sql->fetchAll();


if(   (  ($_SESSION['admin_rights']) !=null) || ($_SESSION['logged_user']) != null)
{

$role_check = $_SESSION['admin_rights'];




switch ($role_check) {
  case 0:
                
echo <<<_END
<div class="container">
  <h2>Our Catalogue</h2>        
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Product name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Description</th>
        <th>Buy?</th>
      </tr>
    </thead>
    <tbody>

_END;
 foreach($data as $i)
 {

  echo <<<_END
<tr>
<td> $i[name_product]</td>
<td> <span>&#163;</span> $i[price_product]</td>
<td> $i[quantity_product]</td>
<td><a href = 'more_info.php?id=$i[id_product]'>More Info</a></td>
<td><a href = 'add_to_cart.php?id_sale=$i[id_product]&amp;name_sale=$i[name_product]&amp;price_sale=$i[price_product]'>Add to cart</a></td>
</tr>
_END;
 }
    break;
  case 1:
        echo <<<_END
<div class="container">
  <h2>Your Catalogue</h2>     

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Product ID</th>
        <th>Product name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>

_END;
 foreach($data as $i)
 {

  echo <<<_END
<tr>
<td> $i[id_product]</td>
<td> $i[name_product]</td>
<td> <span>&#163;</span> $i[price_product]</td>
<td> $i[quantity_product]</td>
<td><a href = 'edit_page.php?id_edit=$i[id_product]'>Edit Item</a></td>
<td><a href = 'deleting_item.php?id=$i[id_product]'>Delete Item</a></td>
</tr>
_END;
 }

    break;
  default:
    echo "sth wrong";
    break;
}
 
  

}
else
{
  echo "This catalogue / home page is for users only. Please click link above";
}



?>
    </tbody>
  </table>
</div>

</body>
</html>
