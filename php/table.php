<!DOCTYPE html>
<html>
    <head>
       <style>
       table{
        width:50%;
        border-collapse:collapse; /*ensures the borders of the table and its cells collpse into a single line instead of double*/
        margin-left:130px;
        margin-top:180px;
        background-color:yellow;
        
       }
       th,td{  /*th for headers and td for data cells*/
        padding:8px;  /*space within the cells*/
        text-align:left;
        border:2px solid red;   /*adds a sloid red border around each table cell*/

       } 
       body{
       
        height: 750px;
     background-image:url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRmfgklWvxiQ6DLovEA-JN5sD5r37uHDoVFg&s);
       background-size:cover;  /*ensures covers the entire page*/
      background-position:center; /*centers the image*/
      background-repeat: no-repeat; /*prevents from repeating*/
      
     
       }
       </style>
    </head>
<!---php part--->
<?php
// Step 1: database connection setup
$servername = "localhost"; //  define Database host where the mysql server is located
$username = "root";        // MySQL username,root by default
$password = "";            // MySQL password (leave empty if no password is set)
$dbname = "my_database";          // Name of your database

// Step 2: Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// checks if there was an error during the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  //if the connection failed script stops,an error msg is displayed
}

// Step 3: Write a SQL query to retrieve data from the players table
$sql = "SELECT id, name, age, role FROM players";
$result = $conn->query($sql); //executes the sql query and stores the result in the $result variable

// Step 4: Check if there are any records and display them
if ($result->num_rows > 0) {
    // Step 5: if there are records table tag create an html table with 
   // headers for each column id ,age,name,role
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Role</th></tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";                       //inside the loop the data from each row is inserted into a new row(<tr>) in the table
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";//each column's data is inserted into a table cell(<td>)
        echo "<td>" . $row["age"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {               //if no records are returned it prints 0 results
    echo "0 results";
}

// Step 6: Close the database connection
$conn->close(); //closes the connection to the mysql database after the query has been executed and the data  has been displayed
?>
</html>