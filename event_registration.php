<?php
require_once 'classes/db1.php';

// Check if the event ID is provided in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Check if the event ID exists in the database
    $query = "SELECT * FROM events WHERE event_id = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "i", $event_id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) > 0) {
        // Event ID exists, proceed with registration
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize input data
            $usn = $_POST["usn"];
            // Insert the registration data into the database
            $sql = "INSERT INTO registered (usn, event_id) VALUES (?, ?)";
            $statement = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($statement, "si", $usn, $event_id);
            if (mysqli_stmt_execute($statement)) {
                echo '<script>alert("Registration successful!");</script>';
            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
            }
        }
    } else {
        // Event ID not found, handle the error
        echo "Event not found.";
    }
} else {
    // Event ID not provided in the URL, redirect or handle the error
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Event Registration</title>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/header.php'; ?>

    <div class="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <h2>Event Registration</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $event_id); ?>" method="POST">
                    <div class="form-group">
                        <label for="usn">Student USN:</label>
                        <input type="text" id="usn" name="usn" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>
