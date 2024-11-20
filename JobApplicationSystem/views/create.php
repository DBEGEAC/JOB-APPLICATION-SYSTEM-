<?php
// Include the database connection
include('../config/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    // Prepare the SQL query to insert the new applicant
    $sql = "INSERT INTO applicants (name, position, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $position, $status);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $message = "Applicant created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Redirect to home.php after submission
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Applicant</title>
</head>
<body>
    <h1>Create New Applicant</h1>

    <!-- Display success or error message -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Form to create a new applicant -->
    <form action="create.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="position">Position:</label>
        <input type="text" name="position" required><br><br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Pending">Pending</option>
            <option value="Interviewed">Interviewed</option>
            <option value="Hired">Hired</option>
        </select><br><br>

        <button type="submit">Create Applicant</button>
    </form>

    <a href="home.php">Back to Home</a>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
