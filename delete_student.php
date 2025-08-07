<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Validate that id is an integer
    if (filter_var($id, FILTER_VALIDATE_INT)) {
        // Prepare the statement
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Success
        } else {
            // Handle failure (optional)
            error_log("Delete query failed: " . $stmt->error);
        }

        $stmt->close();
    } else {
        // Invalid id - optionally handle this
        error_log("Invalid ID for deletion: " . htmlspecialchars($id));
    }
}

// Redirect back to index
header("Location: index.php");
exit;
?>