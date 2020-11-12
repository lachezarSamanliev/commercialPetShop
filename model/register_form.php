<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require_once ('data/shopDatabase.php');

try {
    // connect to db
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $emailErr = $passwordErr = $passwordRepeatErr = $streetErr = $cityErr = $zipErr = "";
    $email = $password = $passwordRepeat = $city = $street = $zipCode = $user_history ="";
    $user_bool = 0;

    // Check if fields are empty
    // If true display error
    // If false sanitize data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"])) {
            $emailErr = "Email is required.";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required.";
        } else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["password_repeat"])) {
            $passwordRepeatErr = "Password is required.";
        } else {
            $passwordRepeat = test_input($_POST["password_repeat"]);
        }

        if (empty($_POST["street"])) {
            $streetErr = "Street is required.";
        } else {
            $street = test_input($_POST["street"]);
        }

        if (empty($_POST["city"])) {
            $cityErr = "City is required.";
        } else {
            $city = test_input($_POST["city"]);
        }

        if (empty($_POST["zipCode"])) {
            $zipErr = "Postal Code is required.";
        } else {
            $zipCode = test_input($_POST["zipCode"]);
        }

    }

    // Check if passwords match
    if ((!empty($password) && !empty($passwordRepeat)) && ($password != $passwordRepeat)) {
        $passwordRepeatErr = "Passwords must match.";
    }

    // Check if email is already in use
    $sql = "SELECT * FROM user_db WHERE email_user = '$email'";
    $is_it_duplicateQuery = $conn->query($sql);

    if ($is_it_duplicateQuery->rowCount() != 0) {
        $emailErr = 'Email already in use';
    }

    // Register user
    if ($is_it_duplicateQuery->rowCount() == 0 && !empty($password) && !empty($passwordRepeat) && !empty($email) && !empty($street) && !empty($city) && !empty($zipCode) && ($password == $passwordRepeat)) {
        $sql = "INSERT INTO user_db (email_user, password_user, street_user, city_user, zipcode_user, admin_check, shopping_history) VALUES (?, ?, ?, ?, ?, ?, ?)";



        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $email);
        $statement->bindvalue(2, md5($password));
        $statement->bindValue(3, $street);
        $statement->bindValue(4, $city);
        $statement->bindValue(5, $zipCode);
        $statement->bindValue(6, $user_bool);
        $statement->bindValue(7, $user_history);

        $statement->execute();
        $conn = null;
    }

    $conn = null;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;

?>



<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table class="form-group" style="margin: 0 auto; min-width: 500px; margin-top: 50px;">
        <tr>
            <td>Email:</td>
        </tr>
        <tr>
            <td><input type="email" class="form-control" name="email" class="textInput"><span><?php echo $emailErr; ?></span></td>
        </tr>
        <tr>
            <td>Password:</td>
        </tr>
        <tr>
            <td><input type="password" class="form-control" name="password" class="textInput"><span><?php echo $passwordErr; ?></span></td>
        </tr>
        <tr>
            <td>Password again:</td>
        </tr>
        <tr>
            <td><input type="password" class="form-control" name="password_repeat" class="textInput"><span><?php echo $passwordRepeatErr; ?></span></td>
        </tr>

        <tr>
            <td>Street</td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" name="street" class="textInput"><span><?php echo $streetErr; ?></span></td>
        </tr>


        <tr>
            <td>City</td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" name="city" class="textInput"><span><?php echo $cityErr; ?></span></td>
        </tr>


        <tr>
            <td>Zip or Postal code</td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" name="zipCode" class="textInput"><span><?php echo $zipErr; ?></span></td>
        </tr>


            <td align="center"><input  style="margin-top: 15px" type="submit" name="register_btn" class="textInput btn btn-secondary"></td>
        </tr>
    </table>
</form>