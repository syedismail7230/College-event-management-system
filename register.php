<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>cems</title>
    <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class ="content"><!--body content holder-->
        <div class = "container">
            <div class ="col-md-6 col-md-offset-3">
                <form method="POST">
                    <label>Student USN:</label><br>
                    <input type="text" name="usn" class="form-control" required><br><br>

                    <label>Student Name:</label><br>
                    <input type="text" name="name" class="form-control" required><br><br>

                    <label>Branch:</label><br>
                    <input type="text" name="branch" class="form-control" required><br><br>

                    <label>Semester:</label><br>
                    <input type="text" name="sem" class="form-control" required><br><br>

                    <label>Email:</label><br>
                    <input type="text" name="email"  class="form-control" required ><br><br>

                    <label>Phone:</label><br>
                    <input type="text" name="phone"  class="form-control" required><br><br>

                    <label>College:</label><br>
                    <input type="text" name="college"  class="form-control" required><br><br>

                    <button type="submit" name="update" required>Submit</button><br><br>
                    <a href="usn.php" ><u>Already registered ?</u></a>
                </form>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>
</html>

<?php
if (isset($_POST["update"]))
{
    $usn=$_POST["usn"];
    $name=$_POST["name"];
    $branch=$_POST["branch"];
    $sem=$_POST["sem"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $college=$_POST["college"];

    if( !empty($usn) || !empty($name) || !empty($branch) || !empty($sem) || !empty($email) || !empty($phone) || !empty($college) )
    {
        include 'classes/db1.php';     

        // Assuming you have an event_id associated with the event the student is registering for
        $event_id = $_POST["event_id"];

        // Check if the student is already registered for the event
        $check_query = "SELECT * FROM registered WHERE usn = '$usn' AND event_id = '$event_id'";
        $check_result = $conn->query($check_query);
        if ($check_result->num_rows > 0) {
            echo "<script>
            alert('You are already registered for this event!');
            window.location.href='usn.php';
            </script>";
        } else {
            // Insert data into the registered table
            $INSERT = "INSERT INTO registered (usn, event_id) VALUES ('$usn', '$event_id')";
            if ($conn->query($INSERT) === TRUE) {
                echo "<script>
                alert('Registered Successfully!');
                window.location.href='usn.php';
                </script>";
            } else {
                echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href='usn.php';
                </script>";
            }
        }

        $conn->close();
    }
    else
    {
        echo"<script>
        alert('All fields are required');
        window.location.href='register.php';
        </script>";
    }
}
?>
