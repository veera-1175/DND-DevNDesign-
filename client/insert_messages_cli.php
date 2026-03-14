<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "dnd");

    if (isset($_POST['send_message'])) {
        $message_fc = mysqli_real_escape_string($conn, $_POST['message_fc']);
        $time_sent_message = date('Y-m-d H:i:s');
        $client_id = $_SESSION['client_id']; // Get client ID from session
        $freelancer_id = isset($_GET['freelancer_id']) ? $_GET['freelancer_id'] : null;

        $sql = "INSERT INTO messages (id_sender, id_client, id_freelancer, message_fc, time_sent_message)
                VALUES ('$client_id', '$client_id', '$freelancer_id', '$message_fc', '$time_sent_message')";
        $result = mysqli_query($conn, $sql);
        header("Location: messages.php?freelancer_id=$freelancer_id");
    }
?>