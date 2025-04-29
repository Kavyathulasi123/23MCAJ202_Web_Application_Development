<?php
// Start the session to store player names that the user adds
session_start();

// Initialize the players array as empty if not already set in the session
if (!isset($_SESSION['players'])) {
    $_SESSION['players'] = [];  //array
}

//  condition Checks if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['playerName'])) {  //HTTP post method is to submit data to the server
    // Add the new player to the session array                               //!empty ensures that the player name entered by the user is not empty
    $_SESSION['players'][] = $_POST['playerName'];
}
?>
<!---html structure for form and table--->
<!DOCTYPE html>
<html >
<head>
    
    
    <title>Indian Cricket Players</title>
    <style>
       body{ font-size:25px;
        background-color:black;
        color:white;
        padding:20px;
       }
       h1{
        text-align:center;
        color:pink;
        margin-bottom:20px;
        text-decoration:underline;
       }
       form{
        
        color:green;
       }
       table th,table td{
        
        text-align:center;
       }
    </style>
</head>
<body>

    <h1>Indian Cricket Players</h1>

    <!-- Form to take user input -->
    <form method="POST">  <!---the form should send data to the server using post method--->
        <label for="playerName">Enter Player Name:</label>
        <input type="text" id="playerName" name="playerName" required>
        <input type="submit" value="Add Player">
    </form>

    <br>

    <?php
    // Display players in an HTML table
    if (count($_SESSION['players']) > 0) {  //this checks if the array contains any names.if there are players outputs an html table.
        echo "<table border='1' cellpadding='10'>
                <tr>
                    <th>Player Name</th>
                </tr>";

        // Loop through the players and display them
        foreach ($_SESSION['players'] as $player) { //this loops through each player in the array and displays them in individual rows of table.
            echo "<tr><td>$player</td></tr>";
        }

        echo "</table>";
    } else {
        // Display a message when there are no players yet
        echo "No players added yet.";
    }
    ?>

</body>
</html>