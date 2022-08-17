<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
    <title>Sign In</title>
    <form action="SignIn.php" method="post">
        <body>
            <label>User name&nbsp;</label><input name="username" type="text"><br>
            <label>Password&nbsp;</label><input name="password" type="password"><br>
            <button name="submit" value="submit" formmethod="post">Submit</button><br>
            <label>Need an account?</label><a href="SignUp.php">Sign up!</a>
        </body>

        <?php
            if (array_key_exists('submit', $_POST)) {
                LoginUser();
            }

            function LoginUser(){
                include("DbConnection.php");

                $username = $_POST["username"];
                $password = $_POST["password"];

                $sql = "SELECT * FROM User WHERE USERNAME = '$username'";
                $result = $conn->query($sql);
                $row = mysqli_num_rows($result);
                mysqli_close($conn);
                if ($row > 0) {
                    while($row = $result->fetch_assoc()) {
                        $username = $row["USERNAME"];
                        $salt = $row["SALT"];
                        $dbPass = $row["PASSWORD"];

                    }
                   
                    //echo "<br>" . $salt;
                    //cho  "<br>" . $dbPass;

                    $hashedPassword = hash("sha256", $password . $salt);

                    //echo "<br>" . $hashedPassword;

                    if ($dbPass == $hashedPassword){
                        $_SESSION["username"] =  $username;
                        $_SESSION["wordIndex"] = "" . rand(0,19);
                        $_SESSION["guesses"] = 0;
                        $_SESSION["letters"] = "";
                        $_SESSION["wrongguess"] = "";
                        header('Location: Game.php');
                        exit();
                        //echo "logged in user";
                    }
                    else {
                        echo "wrong password";
                    }
                }
                else {
                    echo "that user does not exist";
                }
            }
        ?>
    </form>
</html>

