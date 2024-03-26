<?php
require 'classes/db1.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query using a prepared statement to avoid SQL injection
    $query = "SELECT * FROM events
              INNER JOIN event_info ON events.event_id = event_info.event_id
              INNER JOIN student_coordinator ON events.event_id = student_coordinator.event_id
              INNER JOIN staff_coordinator ON events.event_id = staff_coordinator.event_id
              WHERE type_id = ?";
    
    // Prepare the statement
    $statement = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($statement, "i", $id);

    // Execute the statement
    mysqli_stmt_execute($statement);

    // Get the result
    $result = mysqli_stmt_get_result($statement);

    // Check if there are events of the specified type
    if ($result && mysqli_num_rows($result) > 0) {
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>cems</title>
    <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
</head>
<body>
    <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->
   
    <div class="content"><!--body content holder-->
        <div class="container">
            <div class="col-md-12"><!--body content title holder with 12 grid columns-->
                 <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        include 'events.php';
                        // Create a button to redirect to the registration page for the specific event
                        
                        echo '<a class="btn btn-default" href="event_registration.php?id=' . $row['event_id'] . '"><span class="glyphicon glyphicon-circle-arrow-right"></span>Register for Event</a>';
                    }
                ?>
            </div>
            <div class="container">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div><!--body content div-->
    </div>
    <div class="container"><!-- Container for back button -->
        <div class="col-md-12"><!-- 12 grid columns -->
            <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a><!-- Back button -->
        </div>
    </div>
    <?php require 'utils/footer.php'; ?><!--footer content. file found in utils folder-->
</body>
</html>

<?php
    } else {
        echo "No events found for the specified type.";
    }
} else {
    // Redirect to another page or handle the case when 'id' parameter is not provided
    header("Location: index.php");
    exit;
}
?>
