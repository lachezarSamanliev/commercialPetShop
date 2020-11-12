<?php
if (session_status() != PHP_SESSION_NONE) {
   session_destroy();
}

require_once ('data/shopDatabase.php');


session_start();

$error = '';

//checks if form os submitted and if the fields are not empty
if (isset($_POST['submit'])) {
   if (empty($_POST['email']) || empty($_POST['password'])) {
      $error = "Invalid entry. Try again";
   } else {

      try {

      	
//connection to database is made
         $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$email and $password get assigned the values from the form. 
         $email = $_POST['email'];
         $password = md5($_POST['password']);

         $query = "SELECT email_user, password_user, admin_check from user_db where email_user=? AND password_user=? LIMIT 1";

         $stmt = $conn->prepare($query);
         $stmt->bindParam(1, $email);
         $stmt->bindParam(2, $password);
         $stmt->execute();
         //if the fetch is sucessful
         //two sessions are created
         //one for the adming rights, and one for the email of the user.
         //user is then redirected to the home page. 
         if ($arr = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['admin_rights'] = $arr['admin_check'];
            $_SESSION['logged_user'] = $arr['email_user'];
            header("location: index.php");
         } else {
            $error = "Wrong credentials! If you don't have an account, please register.";
         }
      } catch (PDOException $e) {
         echo "Connection failed: " . $e->getMessage();
      }
   }
   $conn = null;
}
?>
<form action="" method="post">
   <div style="margin: 0 auto; max-width: 500px; margin-top: 50px;">
      <table class="form-group">
         <label>Email :</label>
         <input required id="name" class="form-control" name="email" placeholder="you@gmail.com" type="text">
         <label style="margin-top: 1rem;">Password :</label>
         <input required id="password" style="margin-bottom: 1rem;" class="form-control" name="password" placeholder="abc123" type="password">

         <div align="center"><input name="submit" class="btn btn-secondary" type="submit" value="Login"></div>
         <span><?php
               echo $error;
               ?></span>
      </table>
   </div>
</form>