<?php
// Include the database connection
include('../config/db.php');

// Check if the ID is provided in the URL (edit request)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the applicant data from the database
    $sql = "SELECT * FROM applicants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);  // Bind the ID parameter
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the applicant data
    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();
    } else {
        die("Applicant not found!");
    }

    // Check if the form has been submitted to update the applicant
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the updated form data
        $name = $_POST['name'];
        $position = $_POST['position'];
        $status = $_POST['status'];

        // Update the applicant in the database
        $updateSql = "UPDATE applicants SET name = ?, position = ?, status = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $name, $position, $status, $id);

        if ($updateStmt->execute()) {
            $message = "Applicant updated successfully!";
            header("Location: home.php");  // Redirect back to the home page after update
            exit;
        } else {
            $message = "Error updating applicant: " . $updateStmt->error;
        }

        // Close the update statement
        $updateStmt->close();
    }
} else {
    die("No applicant ID provided.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant</title>
</head>
<body>
    <h1>Edit Applicant</h1>

    <!-- Display message if available -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Form to update applicant -->
    <form action="edit.php?id=<?php echo $applicant['id']; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $applicant['name']; ?>" required><br><br>

        <label for="position">Position:</label>
        <input type="text" name="position" value="<?php echo $applicant['position']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Pending" <?php echo $applicant['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Interviewed" <?php echo $applicant['status'] == 'Interviewed' ? 'selected' : ''; ?>>Interviewed</option>
            <option value="Hired" <?php echo $applicant['status'] == 'Hired' ? 'selected' : ''; ?>>Hired</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="home.php">Back to Home</a>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
