<?php
// Getting the value of post parameters
$room  = $_POST['room'];


// Checking for string size
if (strlen($room) > 20 or strlen($room) < 2) {
    $message = "Please choose a name between 2 to 20 characters";
    echo '<script type=text/javascript>';
    echo 'alert("' . $message . '");';
    echo 'window.location="https://localhost/ChatRoom";';
    echo '</script>';
}
// Checking whether the room name is alphanumeric
else if (!ctype_alnum($room)) {
    $message = "Please choose an alphanumeric room name";
    echo '<script type=text/javascript>';
    echo 'alert("' . $message . '");';
    echo 'window.location="https://localhost/ChatRoom";';
    echo '</script>';
}

// Connect to the database
else {
    include 'db_connect.php';
}

// Check is room already exists
$sql = "SELECT * FROM `rooms` WHERE roomname = '$room'";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $message = "Please choose a different room name. This room is already claimed";
        echo '<script type=text/javascript>';
        echo 'alert("' . $message . '");';
        echo 'window.location="https://localhost/ChatRoom";';
        echo '</script>';
    } else {
        $sql = "INSERT INTO `rooms` (`roomname`, `stime`) VALUES ('$room', current_timestamp());";
        if (mysqli_query($conn, $sql)) {
            $message = "Your room is ready and you can chat now!";
            echo '<script type=text/javascript>';
            echo 'alert("' . $message . '");';
            echo 'window.location="https://localhost/ChatRoom/rooms.php?roomname=' . $room . '";';
            echo '</script>';
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
