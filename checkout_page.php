<?php
session_start();


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





        $role_check = $_SESSION['admin_rights'];
        $user_email = $_SESSION['logged_user'];




        if($role_check == 0)
        {
                require_once('model/nav.php');
                require_once ('data/shopDatabase.php');
                require_once('model/checkout_list.php');


                  



     ?>
     		 

 <?php

			 	}else{


                     }

  
							               ?>

