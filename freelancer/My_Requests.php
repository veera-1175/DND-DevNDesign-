<?php
session_start();
include 'config.php';
include 'common.php';
$conn = mysqli_connect('localhost', 'root', '', 'dnd');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$freelancer_id = $_SESSION['freelancer_id'];
$query = "SELECT * FROM suivi_job 
          INNER JOIN jobs ON suivi_job.id_job = jobs.id_job 
          INNER JOIN freelancer ON suivi_job.id_freelancer = freelancer.id_freelancer 
          WHERE freelancer.id_freelancer = '$freelancer_id'";
$result = mysqli_query($conn, $query);
$jobs = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }
}
if (!isset($_SESSION['freelancer_name'])) {
    header('location:login_form.php');
    exit();
}
$sell = "SELECT * FROM freelancer";
$qyerry = mysqli_query($conn, $sell);
$resul = mysqli_fetch_assoc($qyerry);
?>
<section class="home-grid">
    <div class="box-container">
        <div class="imagee">
            <img src="img/originals/Lightbulb-60b6.png" alt="">
        </div>
    </div>
    <div class="box">
        <h2 class="title">My requests</h2>
        <p class="tutor">Here you can see the requests you sent, and if they got accepted or not. </p>
        <hr>
    </div>
</section>
<section class="review-list">
    <?php foreach ($jobs as $job): ?>
        <div class="review">
            <div class="reviewer-info">
                <div class="reviewer-name">
                    <h3> The job: <?php echo $job['title']; ?></h3>
                    <p>You sent a request: <h3><?php echo ucfirst($job['message_job']); ?></h3> <br> 
                        <h3><?php echo ucfirst($job['status']); ?></h3> 
                        <hr>
                    </p>
                </div>
            </div>
            <div class="review-content">
                <h3> You sent the request at: <?php echo $job['time_sent']; ?></h3>
                <p> Your request was accepted at: <?php echo $job['time_accepted']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<?php include 'footer.php'; ?>
