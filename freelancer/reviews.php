<?php
session_start();
include 'config.php';
include 'common.php';
$conn = mysqli_connect('localhost', 'root', '', 'dnd');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$freelancer_id = $_SESSION['freelancer_id'];
$query = "SELECT * FROM reviews
          INNER JOIN client ON reviews.id_client = client.id_client
          INNER JOIN freelancer ON reviews.id_freelancer = freelancer.id_freelancer
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
?>
<section class="home-grid">
    <div class="box-container">
        <div class="imagee">
            <img src="img/originals/First place medal-60b6.png" alt="">
        </div>
    </div>
    <div class="box">
        <h2 class="title">REVIEWS</h2>
        <p class="tutor">All clients reviews that you have worked with </p>
        <hr>
    </div>
</section>
<section class="review-list">
    <?php foreach ($jobs as $job): ?>
        <div class="review">
            <div class="reviewer-info">
                <?php
                if ($job['statut'] == 0) {
                    echo '<img src="../client/photoclient/default.jpg">';
                } else {
                    $id = $job['id_client'];
                    $ex = $job['exentation'];
                    $namf = $id . '.jpg';
                    echo '<img src="../client/photoclient/' . $namf . '">';
                }
                ?>
                <div class="reviewer-name">
                    <h3><?php echo $job['first_name_cli'] . ' ' . $job['last_name_cli']; ?></h3>
                    <p>Customer</p>
                </div>
            </div>
            <div class="review-content">
                <div class="stars">
                    <h3> <?php echo $job['rating']; ?> <i class="fa fa-star"></i> </h3>
                </div>
                <p><?php echo $job['description']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<?php include 'footer.php'; ?>
