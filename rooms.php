<?php
// Get Parameters:
$roomname = $_GET['roomname'];

// Connecting to the Database:
include 'db_connect.php';

// Execute sql to check whether room exists
$sql = "SELECT * FROM `rooms` WHERE roomname = '$roomname'";

$result = mysqli_query($conn, $sql);

if ($result) {
    // Check if room exists
    if (mysqli_num_rows($result) == 0) {
        $message = "This room does not exist. Try creating a new one";
        echo '<script type=text/javascript>';
        echo 'alert("' . $message . '");';
        echo 'window.location="https://localhost/ChatRoom/"';
        echo '</script>';
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- This thing is added by me: -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="css/product.css" rel="stylesheet">
    <style>
        body {
            margin: 0 auto;
            max-width: 800px;
            padding: 0 20px;
        }

        .container {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        .container img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .container img.right {
            float: right;
            margin-left: 20px;
            margin-right: 0;
        }

        .time-right {
            float: right;
            color: #aaa;
        }

        .time-left {
            float: left;
            color: #999;
        }

        #submitmsg:hover {
            color: white;
            background-color: black;
        }

        .anyClass {
            height: 350px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <header>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <span class="fs-4" style="font-weight: bold;">MyAnonymousChat.com</span>
            </a>

            <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                <a class="me-3 py-2 text-dark text-decoration-none" href="#">Home</a>
                <a class="me-3 py-2 text-dark text-decoration-none" href="#">About</a>
                <a class="me-3 py-2 text-dark text-decoration-none" href="#">Contact Us</a>
            </nav>
            <!-- <a class="btn btn-outline-primary" href="#">Sign Up</a> -->
        </div>
    </header>
    <h2>Chat Messages - <?php echo $roomname; ?></h2>

    <div class="container">
        <div class="anyClass">
        </div>
    </div>


    <!-- Input Field -->
    <input type="text" name="usermsg" id="usermsg" class="form-control" placeholder="Add message"> <br>

    <!-- Send Button -->
    <button class="btn btn-default" name="submitmsg" id="submitmsg">Send</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- JQuery CDN: -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // Check for new messages every 1 second:
        setInterval(runFunction, 1000);

        function runFunction() {
            $.post("htcont.php", {
                    room: '<?php echo $roomname ?>'
                },
                function(data, status) {
                    document.getElementsByClassName('anyClass')[0].innerHTML = data;
                }
            )
        }
        // Trigger Button Click on Enter:
        // Get the input field
        var input = document.getElementById("usermsg");

        // Execute a function when the user presses a key on the keyboard
        input.addEventListener("keypress", function(event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("submitmsg").click();
            }
        });
        // If user submits the form 
        $("#submitmsg").click(function() {
            var clientmsg = $("#usermsg").val();
            $.post("postmsg.php", {
                    text: clientmsg,
                    room: '<?php echo $roomname ?>',
                    ip: '<?php echo $_SERVER['REMOTE_ADDR'] ?>'
                },
                function(data, status) {
                    document.getElementsByClassName('anyClass')[0].innerHTML = data;
                });
            $("#usermsg").val("");
            return false;

        });
    </script>

</body>

</html>