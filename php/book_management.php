<?php
// Database connection setup
//defines the database connection parameters
$servername = "localhost"; 
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "library";  //name of database

// Create connection to database using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  //if the connection fails the script stops and shows error msg
}

// Initialize variables
//these are initial empty variables to hold form data or search results
$title = $authors = $edition = $publisher = "";
$search_title = "";
$insert_success = false;
$search_results = [];

// Handle form submission for adding a book or searching

if ($_SERVER["REQUEST_METHOD"] == "POST") {   //this checks if the form has been submitted via the post method
    if (isset($_POST['add_book'])) {
        // Collect form data for adding a book
        $title = $_POST['title'];
        $authors = $_POST['authors'];
        $edition = $_POST['edition'];
        $publisher = $_POST['publisher'];

        // Insert the book into the database using prepared statement//this prepares a sql query to insert the book's information into the books table
        $stmt = $conn->prepare("INSERT INTO books (title, authors, edition, publisher) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $authors, $edition, $publisher);

        // Execute the query
        if ($stmt->execute()) { // if the  query is successful it sets insert_success to true. 
            $insert_success = true;
        } else {           //if not it shows an error msg
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
        //searching for a book
        //this checks if the search book form was submitted
    } elseif (isset($_POST['search_book'])) {
        // Collect the search query
        $search_title = $_POST['search_title'];

        // Prepare the search query
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
        $search_term = "%" . $search_title . "%"; // Ensure proper pattern for LIKE
        $stmt->bind_param("s", $search_term);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
</head>
<body>
    <h1>Book Management</h1>

    <!-- Form to add a new book -->
    <h2>Add a New Book</h2>
    <form method="POST" action="book_management.php">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="authors">Authors:</label><br>
        <input type="text" id="authors" name="authors" required><br><br>

        <label for="edition">Edition:</label><br>
        <input type="text" id="edition" name="edition"><br><br>

        <label for="publisher">Publisher:</label><br>
        <input type="text" id="publisher" name="publisher"><br><br>

        <input type="submit" name="add_book" value="Add Book">
    </form>

    <?php
    if ($insert_success) {
        echo "<p>New book added successfully. <a href='book_management.php'>Add another book</a> or search for a book below.</p>";
    }
    ?>

    <!-- Form to search for a book by title -->
    <h2>Search for a Book by Title</h2>
    <form method="POST" action="book_management.php">
        <label for="search_title">Title:</label><br>
        <input type="text" id="search_title" name="search_title" value="<?php echo htmlspecialchars($search_title); ?>" required><br><br>
        <input type="submit" name="search_book" value="Search">
    </form>

    <?php
    if (!empty($search_results)) {
        echo "<h2>Search Results:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Accession Number</th>
                    <th>Title</th>
                    <th>Authors</th>
                    <th>Edition</th>
                    <th>Publisher</th>
                </tr>";

        foreach ($search_results as $book) {
            echo "<tr>
                    <td>" . $book['accession_number'] . "</td>
                    <td>" . $book['title'] . "</td>
                    <td>" . $book['authors'] . "</td>
                    <td>" . $book['edition'] . "</td>
                    <td>" . $book['publisher'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($search_title) && empty($search_results)) {
        echo "<p>No results found for the title: <strong>$search_title</strong></p>";
    }
    ?>
</body>
</html>