<?php
session_start();

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
            if(isset($_GET['id_edit']))
            {
              $id_of_item = $_GET['id_edit'];
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
                            require_once('model/nav.php');
                            require_once ('data/shopDatabase.php');



                    try {

                         $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
                         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



                         $query = "SELECT id_product, name_product, price_product, quantity_product, product_description From products_db Where id_product=? LIMIT 1";

                         $stmt = $conn->prepare($query);
                         $stmt->bindParam(1, $id_of_item);

                         $stmt->execute();
                         if ($arr = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    $idItem = $arr['id_product'];
                                    $nameItem = $arr['name_product'];
                                    $priceItem = $arr['price_product'];
                                    $quantityItem = $arr['quantity_product'];
                                    $descriptionItem = $arr['product_description'];

                                    if(isset($_POST['new']) && $_POST['new'] == 1)
                                    {
                                       $new_name = test_input($_POST["name_item"]);
                                       $new_price = test_input($_POST["price_item"]);
                                       $new_quantity = test_input($_POST["quantity_item"]);
                                       $new_description = test_input($_POST["description_item"]);


//After the form is checked if it is submitted
//this long if statement makes sure that if one of the fields in the form are NULL
//it will keep the original value of the data, so when the update method is called
//only the new data will be changed. the rest will stay as it was.
                                       if($new_name == '')
                                       {
                                        $new_name = $nameItem;

                                          if($new_price == '' || (is_numeric($new_price)) == false)
                                         {
                                          $new_price = $priceItem;

                                                if($new_quantity == '' || (is_numeric($new_quantity)) == false)
                                             {
                                              $new_quantity = $quantityItem;

                                                      if($new_description == '')
                                               {
                                                $new_description = $descriptionItem;
                                               }
                                             }
                                         }
                                            if($new_quantity == '' || (is_numeric($new_quantity)) == false)
                                             {
                                              $new_quantity = $quantityItem;

                                                      if($new_description == '')
                                               {
                                                $new_description = $descriptionItem;
                                               }
                                             }
                                       }
                                       else{
                                        if($new_price == '' || (is_numeric($new_price)) == false)
                                         {
                                          $new_price = $priceItem;

                                                if($new_quantity == '' || (is_numeric($new_quantity)) == false)
                                             {
                                              $new_quantity = $quantityItem;

                                                      if($new_description == '')
                                               {
                                                $new_description = $descriptionItem;
                                               }
                                             }
                                         }
                                            if($new_quantity == '' || (is_numeric($new_quantity)) == false)
                                             {
                                              $new_quantity = $quantityItem;

                                                      if($new_description == '')
                                               {
                                                $new_description = $descriptionItem;
                                               }
                                             }
                                       }
                                       
                                       




                                       $update = "UPDATE products_db SET name_product=? , price_product=? , quantity_product=?, product_description=? WHERE id_product='" . $id_of_item . "'";

                                       $statement = $conn->prepare($update);
                                       $statement->bindValue(1, $new_name);
                                       $statement->bindValue(2, $new_price);
                                       $statement->bindValue(3, $new_quantity);
                                       $statement->bindValue(4, $new_description);
                                       $statement->execute();
                                       if($statement->execute())
                                       {
                                        $result = "Update succesful <a href='index.php'>Go Back to page</a>";
                                        echo $result;
                                       }
                                       else
                                       {
                                        echo "Something went bad with update";
                                       }




                                      
                                    }else{
                                      //  echo "here";
                                    }

                                    ?>

                                          <h2>Edit page</h2>

                                          <!-- Form to input new data for the specific item
                                          -->
                                          <h3>Leave empty field if no update to value</h3>
                                         <div class='row'>
                                           <div class='column' style='background-color:#aaa;'>
                                           
                                                <p><b>New Information</b></p>
                                               
                                             <form method = "POST" action = "">
                                              <input type = "hidden" name="new" value ="1"/>
                                             <table width = "250" border = "0" cellspacing = "1" cellpadding = "2">
                                                <tr>
                                                   <td width = "250">Name</td>
                                                   <td>
                                                      <input name = "name_item" type = "text" id = "name_item">
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Price</td>
                                                   <td>
                                                      <input name = "price_item" type = "text" id = "price_item">
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Quantity</td>
                                                   <td>
                                                      <input name = "quantity_item" type = "text" id = "quantity_item">
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td width = "250">Description</td>
                                                   <td>
                                                      <input style="height:40px;" name = "description_item" type = "text" id = "description_item">
                                                   </td>
                                                </tr>


                                                <tr>
                                                   <td width = "250"> </td>
                                                   <td> </td>
                                                </tr>
                                             
                                                <tr>
                                                   <td width = "250"> </td>
                                                   <td>
                                                      <input name = "add" type = "submit" id = "edit"  value = "Edit Item">
                                                   </td>
                                                </tr>
                                             </table>
                                          </form>


                                         </div>
                                    


                                    <!-- a simple div class that displays already existing data -->
                                              <div class='column' style='background-color:#bbb;'>
                                                <p><b>Existing Record information</b></p>
                                                <br>
                                                <p> Name is: <?php echo $nameItem; ?></p>
                                                <br>
                                                <p>Price is <?php echo $priceItem; ?></p>
                                                <br>
                                                <p>Quantity is <?php echo $quantityItem; ?></p>
                                                <br>
                                                <p>Description is <?php echo $descriptionItem; ?></p>


                                              </div>
                                            </div>
                                    
                                    <?php

                           }
                           else
                             {
                                echo "sth broke";
                             }
                        }       catch (PDOException $e) {
                                echo "Connection failed: ";
                                echo $e;
                                }
                       
                            $conn = null;



                }
                                else if ($role_check == 0 || $role_check == null)
                                {
                                    echo "You are not an admin, sorry.";
                                }
                                else
                                {

                                }

                ?>


</body>
</html> 




















<!--

 echo <<<_END

                 <div class="row">
                 <div class="column" style="background-color:#aaa;">
                 
                 <p>Some text..</p>
                 <p><input type="text" class="form-control" name="name" placeholder="Name" required value="" /></p>

                 </div>
            _END;


            echo <<<_END
                      <div class="column" style="background-color:#bbb;">
                      <h2>Column 2</h2>
                      <p>Some text..</p>


                      </div>
                    </div>
            _END;






    -->
