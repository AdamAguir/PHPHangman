<?php
session_start();
?>
<!DOCTYPE html>
<html>
<title>Sign In</title>
<form action="SignUp.php" method="post">

    <body>
        <label>User name&nbsp;</label><input name="username" type="text"><br>
        <label>Password&nbsp;</label><input name="password" type="password"><br>
        <button name="submit" value="submit" formmethod="post">Submit</button><br>
    </body>

    <?php


    if (array_key_exists('submit', $_POST)) {
        CreateUser();
    }

    function CreateUser()
    {
        include("DbConnection.php");

        // generate salt, add it to the password and then hash using sha256
        $salt = random_bytes(4);
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $hashedPassword = hash("sha256", $pass . $salt);


        //check for if unique username
        $sqlCheck = "SELECT * FROM User WHERE USERNAME = '$username'";
        $result = $conn->query($sqlCheck);
        $row = mysqli_num_rows($result);
        if ($row == 0) {

            //generate sql insert statement
            $sql = "INSERT INTO User (USERNAME, SALT, PASSWORD) VALUES('$username', '$salt', '$hashedPassword')";

            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                $_SESSION["username"] = $username;
                $_SESSION["wordIndex"] = "" . rand(0, 19);
                $_SESSION["guesses"] = 0;
                $_SESSION["letters"] = "";
                $_SESSION["wrongguess"] = "";
                //echo "created User successfully";
                mysqli_close($conn);
                header('Location: Game.php');
            } else {
                mysqli_close($conn);
                echo "New record was not created";
            }
        } else {
            mysqli_close($conn);
            echo "user already exists";
        }
    }

    ?>
</form>

</html>