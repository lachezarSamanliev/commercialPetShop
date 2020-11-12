<?php
//session_start();

//For now I will not be checking incoming ID if it is real in the database
//it would be better to have a message displayed and to have the navigation bar
//to go back or for the error to directly send you to the catalogue with an error message.

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>


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
          width: 50%;
          padding: 10px;
          height: 420px; /* Should be removed. Only for demonstration */
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
							
			if($role_check == 1)
			{
				
							require_once ('data/shopDatabase.php');
					try
					{
						$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
                         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						 
						 $add_id = $add_name = $add_price = $add_quantity = $add_description = "";
						 $id_err = $name_err = $price_err = $quantity_err = $description_err = "";
							
							if(isset($_POST['new']) && $_POST['new'] == 1)
							{

								
								//check for null values
								if(empty($_POST["id_item"]))
								{
									$id_err = "Please provide ID";
								}
								else
								{
									$add_id = test_input($_POST["id_item"]);
								}
								
								if(empty($_POST["name_item"]))
								{
									$name_err = "Please provide Name";
								}
								else
								{
									$add_name = test_input($_POST["name_item"]);
								}
								
								if(empty($_POST["price_item"]))
								{
									$price_err = "Please provide Price";
								}
								else
								{
									$add_price = test_input($_POST["price_item"]);
								}
								
								if(empty($_POST["quantity_item"]))
								{
									$quantity_err = "Please provide quantity";
								}
								else
								{
									$add_quantity = test_input($_POST["quantity_item"]);
								}
								
								if(empty($_POST["description_item"]))
								{
									$description_err = "Please provide Description";
								}
								else
								{
									$add_description = test_input($_POST["description_item"]);
								}
								

								
									if(!empty($add_id) && !empty($add_name) && !empty($add_price) && !empty($add_quantity) && !empty($add_description) )
									{
										$sql = "INSERT INTO products_db (id_product, name_product, price_product, quantity_product, product_description) VALUES (?, ?, ?, ?, ?)";
										
										
										$stmt = $conn->prepare($sql);
										$stmt->bindValue(1, $add_id);
										$stmt->bindValue(2, $add_name);
										$stmt->bindValue(3, $add_price);
										$stmt->bindValue(4, $add_quantity);
										$stmt->bindValue(5, $add_description);
										
										$stmt->execute();
										
										$result = "Add was succesful <a href='index.php'>Go to Index</a>";
                                        echo $result;
										
										
										
										
										$conn= null;
									}
									else{
										echo "fields not okay";
									}
								
							}
				
			//give add form
								
			
				
				        ?>


											<h3>This page is used to add products. No empty values please</h3>
											<h3>If ID number is taken, sth will happen</h3>
                                          
                                         <div class='row'>
                                           <div class='column' style='background-color:#aaa;'>
                                           
                                                <p><b>New Information</b></p>
                                               
                                             <form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                              <input type = "hidden" name="new" value ="1"/>
                                             <table width = "250" border = "0" cellspacing = "1" cellpadding = "2">
												
												<tr>
                                                   <td width = "250">ID</td>
                                                   <td>
                                                      <input name = "id_item" type = "text" id = "id_item"><span><?php echo $id_err; ?></span></sp>
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Name</td>
                                                   <td>
                                                      <input name = "name_item" type = "text" id = "name_item"> <span><?php echo $name_err; ?></span>
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Price</td>
                                                   <td>
                                                      <input name = "price_item" type = "text" id = "price_item"> <span><?php echo $price_err; ?></span>
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Quantity</td>
                                                   <td>
                                                      <input name = "quantity_item" type = "text" id = "quantity_item"><span> <?php echo $quantity_err; ?></span>
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Description</td>
                                                   <td>
                                                      <input style="height:40px;" name = "description_item" type = "text" id = "description_item"><span> <?php echo $description_err; ?></span>
                                                   </td>
                                                </tr>


                                                <tr>
                                                   <td width = "250"> </td>
                                                   <td> </td>
                                                </tr>
                                             
                                                <tr>
                                                   <td width = "250"> </td>
                                                   <td>
                                                      <input name = "add" type = "submit" id = "addItem"  value = "Add Item">
                                                   </td>
                                                </tr>
                                              </table>
                                            </form>
										  </div>





		<?php
				$conn=null;
					}  catch (PDOException $e) {
                            echo "Connection failed: ";
                              echo $e;
                        }

		//closing if for checking if admin
			}else
			{
				echo "You are not admin, you can't add";
			}
		
		
		
		?>

</body>
</html>