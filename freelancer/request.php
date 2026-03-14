<?php
    include 'config.php';
    session_start();
    include 'common.php';
    if(!isset($_SESSION['freelancer_id'])){
    header('location:login_form.php');
        }
        $sell = "SELECT * FROM freelancer ";
        $qyerry= mysqli_query($conn, $sell);
        $resul = mysqli_fetch_assoc($qyerry);
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $message_job = mysqli_real_escape_string($conn, $_POST['message_job']);
            $id_client =  $_GET['client_id'];
            $id_job =  $_GET['job_id'];
            $id_freelancer =  $_SESSION['freelancer_id'];
            $status = 'pending';
            $time_sent = date('Y-m-d H:i:s');
            $id_freelancer = $_SESSION['freelancer_id'];

$checkFreelancer = mysqli_query($conn, "SELECT * FROM freelancer WHERE id_freelancer = '$id_freelancer'");
if (mysqli_num_rows($checkFreelancer) == 0) {
    die("Error: Freelancer with ID $id_freelancer does not exist in the database.");
}
        
            $insert = "INSERT INTO suivi_job (id_job, id_client, id_freelancer, message_job, status, time_sent)
                       VALUES ('$id_job', '$id_client', '$id_freelancer', '$message_job', '$status', '$time_sent')";
        
            if (mysqli_query($conn, $insert)) {
                echo "<script>alert('Request sent successfully!');</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }        
?>
        <section class="home-grid">
            <div class="box-container">
                    <div class="imagee">
                        <img src="img/originals/Lightbulb-60b6.png" alt="">
                    </div>
            </div>
            <div class="box">
                        <h2 class="title">Request</h2>
                        <p class="tutor">Here you can send a request to work with this client </p>
                        <hr>
            </div>
        </section>
        <section class="contact">
            <div class="row">
                <form class="contact__form" method="POST" action="">
                    <center>
                    <h3>Request to the client</h3>
                    <textarea name="message_job" class="contact-form-text" placeholder="Enter your message" required maxlength="1000" cols="25" rows="10" id="message_job"></textarea>
                    <input type="submit" value="Send" class="inline-btn" name="submit">
                </form>
            </div>
        </section>
<?php include 'footer.php'; ?>
