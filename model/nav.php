<div class="head info">
  <div class="container">
    <p class="lead">Your pet's online shop</p>
    <hr class="my-4" style="background-color: white">
  </div>
</div>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #808080;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>
</body>
</html>


<?php


if(!isset($_SESSION['logged_user']))
{

echo "<div class='topnav'>";
echo " <a class='active' href='index.php'>Home</a>";
 echo " <a href='login.php'>Login</a>";
 echo " <a href='register.php'>Register</a>";
echo "</div>";

}

else if(($_SESSION['admin_rights']) == 0)
{

echo "<div class='topnav'>";
echo " <a class='active' href='index.php'>Home</a>";
echo " <a class='active' href='add_to_cart.php'>Your Cart</a>";
echo " <a class='active' href='checkout_page.php'>Checkout</a>";


echo "<li class='nav-item active'><a class='nav-link'>Welcome there, " . $_SESSION['logged_user'] . "</a></li>";
echo "<li style='float: right' class='nav-item'><a class='nav-link' href='logout.php'>Log out</a></li>";

echo "</div>";

}


else if(($_SESSION['admin_rights']) == 1)
{

	echo "<div class='topnav'>";
echo " <a class='active' href='index.php'>Catalogue</a>";
echo " <a class='active' href = 'add_product.php'>Add Item</a>";




echo "<li class='nav-item active'><a class='nav-link'>Hello, admin</a></li>";
echo "<li style='float: right' class='nav-item'><a class='nav-link' href='logout.php'>Log out</a></li>";

echo "</div>";

}


?>
