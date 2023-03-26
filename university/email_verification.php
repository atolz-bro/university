<?php 
//database parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the email value from the form
$email = $_POST['email'];

// SQL query to search the database
$sql = "SELECT email FROM form_data WHERE email = '$email'";

// Execute the query
$result = mysqli_query($conn, $sql);

// If email exists in the database
if (mysqli_num_rows($result) > 0) {
    echo "exist";
} else {
    // Email is available
    echo "available";
}

// Close the database connection
mysqli_close($conn);
?>
