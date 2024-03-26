<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the student's USN from the form submission
    $usn = $_POST["usn"];

    // Now, you can use the $usn variable to query the database for registered events associated with this student
    // Here you would typically include database connection and query logic
    // For demonstration purposes, let's assume you have the database logic here

    // Example database query (replace this with your actual query logic)
    // $result = mysqli_query($conn, "SELECT * FROM registered_events WHERE usn = '$usn'");

    // Assuming you have fetched the registered events data into $result

    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Registered Events</title>
        <?php require 'utils/styles.php'; ?>css links. file found in utils folder
    </head>
    <body>
    <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->

    <div class="content"><!--body content holder-->
        <div class="container">
            <!-- <h1>Registered Events for <?php echo $usn; ?></h1> -->
            <?php
require_once 'classes/db1.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the student's USN from the form submission
    $usn = $_POST["usn"];

    // Query the database to fetch registered events for the student
    $query = "SELECT r.rid, e.event_id, e.event_title, ei.Date, ei.time, ei.location, sc.st_name AS student_coordinator, st.name AS staff_coordinator
              FROM registered r
              JOIN events e ON r.event_id = e.event_id
              JOIN event_info ei ON e.event_id = ei.event_id
              LEFT JOIN student_coordinator sc ON e.event_id = sc.event_id
              LEFT JOIN staff_coordinator st ON e.event_id = st.event_id
              WHERE r.usn = '$usn'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Display the registered events
            echo "<h1>Registered Events for $usn</h1>";
            echo "<table border='1'>
                  <tr>
                  <th>Event ID</th>
                  <th>Event Name</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Location</th>
                  <th>Student Coordinator</th>
                  <th>Staff Coordinator</th>
                  </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['event_id'] . "</td>";
                echo "<td>" . $row['event_title'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['location'] . "</td>";
                echo "<td>" . $row['student_coordinator'] . "</td>";
                echo "<td>" . $row['staff_coordinator'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No registered events found for $usn.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the form has not been submitted, display the form
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
                <h2>Registered Events</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="usn">Enter Student USN:</label>
                        <input type="text" id="usn" name="usn" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Show Registered Events</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>
<?php } ?>

        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
    </body>
    </html>
    <?php
    // End of example display code
} else {
    // If the form has not been submitted, display the form
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
            <div class="col-md-6 col-md-offset-3">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group" method="POST">

                    <div class="form-group">
                        <label for="usn"> Student USN: </label>
                        <input type="text"
                               id="usn"
                               name="usn"
                               class="form-control">
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
    </body>
    </html>
    <?php
    // End of form display code
}
?>
