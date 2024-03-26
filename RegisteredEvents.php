<?php
require_once 'utils/header.php';
require_once 'utils/styles.php';

$usn = $_POST['usn'];

include_once 'classes/db1.php';

// Query for registered events with date, time, and location
$result_registered = mysqli_query($conn, "SELECT e.event_title, st.st_name AS student_coordinator, s.name AS staff_coordinator, ef.date, ef.time, ef.location
                                           FROM registered r
                                           INNER JOIN events e ON r.event_id = e.event_id
                                           INNER JOIN staff_coordinator s ON e.event_id = s.event_id
                                           INNER JOIN student_coordinator st ON e.event_id = st.event_id
                                           INNER JOIN event_info ef ON e.event_id = ef.event_id
                                           WHERE r.usn = '$usn'");

// Query for unregistered events with date, time, and location
$result_unregistered = mysqli_query($conn, "SELECT e.event_title, st.st_name AS student_coordinator, s.name AS staff_coordinator, ef.date, ef.time, ef.location
                                             FROM events e
                                             LEFT JOIN staff_coordinator s ON e.event_id = s.event_id
                                             LEFT JOIN student_coordinator st ON e.event_id = st.event_id
                                             LEFT JOIN event_info ef ON e.event_id = ef.event_id
                                             WHERE e.event_id NOT IN (SELECT event_id FROM registered WHERE usn = '$usn')");

?>

<div class="content">
    <div class="container">
        <h1>Registered Events</h1>
        <?php if (mysqli_num_rows($result_registered) > 0) { ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Coordinator</th>
                        <th>Staff Coordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_registered)) { ?>
                        <tr>
                            <td><?= $row['event_title'] ?></td>
                            <td><?= $row['student_coordinator'] ?></td>
                            <td><?= $row['staff_coordinator'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['time'] ?></td>
                            <td><?= $row['location'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo 'No registered events found';
        } ?>
    </div>
</div>

<div class="content">
    <div class="container">
        <h1>Unregistered Events</h1>
        <?php if (mysqli_num_rows($result_unregistered) > 0) { ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Student Coordinator</th>
                        <th>Staff Coordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_unregistered)) { ?>
                        <tr>
                            <td><?= $row['event_title'] ?></td>
                            <td><?= $row['student_coordinator'] ?></td>
                            <td><?= $row['staff_coordinator'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['time'] ?></td>
                            <td><?= $row['location'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo 'No unregistered events found';
        } ?>
    </div>
</div>

<?php include 'utils/footer.php'; ?>
