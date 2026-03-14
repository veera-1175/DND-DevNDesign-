<?php
    session_start();
    include'config.php';
    if (isset($_POST['send_message'])) {
        $message_fc = mysqli_real_escape_string($conn, $_POST['message_fc']);
        $time_sent_message = date('Y-m-d H:i:s');
        $freelancer_id = $_SESSION['freelancer_id']; 
        $client_id = isset($_GET['client_id']) ? $_GET['client_id'] : null;
        $sql = "INSERT INTO messages (id_sender, id_client, id_freelancer, message_fc, time_sent_message)
                VALUES ('$freelancer_id', '$client_id', '$freelancer_id', '$message_fc', '$time_sent_message')";
        $result = mysqli_query($conn, $sql);
        header("Location: messages.php?client_id=$client_id");
    }
?>