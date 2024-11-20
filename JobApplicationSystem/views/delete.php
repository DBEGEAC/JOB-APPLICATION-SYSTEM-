<?php
// Include the database connection
include('../config/db.php');

// Check if the 'id' parameter is passed in the URL (i.e., the applicant ID)
if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];  // Get the applicant ID from the URL

    // Prepare the SQL query to delete the applicant
    $sql = "DELETE FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicantId);  // Bind the parameter (id) to the query

    // Execute the query and check if the deletion was successful
    if ($stmt->execute()) {
        // Deletion was successful, redirect back to home.php
        header("Location: home.php");
        exit;
    } else {
        // If there was an error, display an error message
        $message = "Error: Unable to delete applicant.";
    }

    // Close the statement
    $stmt->close();
} else {
    // If the 'id' parameter is not passed, show an error message
    $message = "Error: Applicant ID is missing.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Applicant</title>
</head>
<body>
    <h1>Are you sure you want to delete this applicant?</h1>

    <!-- Display message if there was an error -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Confirmation buttons -->
    <form action="delete.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <button type="submit" name="confirmDelete">Yes, Delete</button>
    </form>

    <!-- Link to go back to the home page -->
    <a href="home.php">Back to Home</a>
</body>
</html>
