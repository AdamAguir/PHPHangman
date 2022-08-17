<?php
session_start();
?>
<!DOCTYPE html>
<html>
<title>Hangman</title>
<form action="Game.php" method="post">

    <body>

        <?php

        if (array_key_exists('logout', $_POST)) {
            session_unset();
            session_destroy();
            header('Location: SignIn.php');
        }

        if (array_key_exists('guess', $_POST)) {
            $guess = $_POST["txtBGuess"];
            if (strlen($guess) == 1) {
                $_SESSION["letters"] .= $guess;
            } else {
                echo "Cannot guess more than one letter at a time";
            }
        }

        echo "<h3> Welcome " . $_SESSION["username"] . " to my Hangman game</h3>";
        echo "<br>Word ID: " . $_SESSION["wordIndex"] . "<br>";
        include("DbConnection.php");
        $index = $_SESSION["wordIndex"];
        $sql = "SELECT WORD_VALUE FROM Word WHERE ID = '$index'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $word = $row["WORD_VALUE"];
            }
        }

        $length = strlen($word);
        $displayWord = "";
        echo $displayWord;
        for ($index = 0; $index < $length; $index++) {
            $displayWord .= "-";
        }

        $guessArray = str_split($displayWord);
        $lettersGuessed = str_split($_SESSION["letters"]);
        $wordArray = str_split($word);

        echo $word;


        echo "<br>" . $_SESSION["letters"];

        $wrongGuesses = "";
        

        for ($index = 0; $index < $length; $index++) {
            if(strlen($_SESSION["letters"]) > 0){
                foreach ($lettersGuessed as $char) {
                    if (strpos($wordArray, $char, $offset = 0)) {
                        if ($word[$index] == $char) {
                            $displayWord[$index] = $char;
                        }
                    } else if(!strpos($wrongGuesses, $char, $offset = 0)){
                          $wrongGuesses .= $char;
                    }
                }
            }
        }
        $_SESSION["wrongguess"] = $wrongGuesses;
        echo "<br>" . $displayWord;
        echo "<br>" . $wrongGuesses;
        ?>
        <div>
            <input name="txtBGuess" hint="Guess a Letter" type="text">
            <button name="guess" value="submit" formmethod="post">Guess!</button><br>
        </div>

        <button name="logout" value="submit" formmethod="post">Logout</button><br>
    </body>
</form>

</html>