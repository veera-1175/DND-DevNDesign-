<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'dnd');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT * FROM freelancer 
          INNER JOIN messages ON freelancer.id_freelancer = messages.id_freelancer 
          WHERE freelancer.id_freelancer = messages.id_freelancer";
$result = mysqli_query($conn, $query);
$cli = array();
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cli[] = $row;
    }
}
@include '../login/config.php';
$displayed_freelancers = array();
include 'common.php';
if (!isset($_SESSION['client_name'])) {
    header('location:login_form.php');
    exit();
}
?>
<head>
   <link rel="stylesheet" href="../freelancer/CSS/style.css">
</head>
<section class="home-grid">
   <div class="headline">
      <h3><i class="fas fa-regular fas fa-comments"></i> Messages</h3>
   </div>
</section>
<section class="Requests">
<?php
foreach ($cli as $row) {
    if (!in_array($row['id_freelancer'], $displayed_freelancers)) {
?>
    <div class="box-container">
        <div class="box">
            <div class="tutor">
                <?php
                if ($row['statut'] == 0) {
                    echo '<img src="../freelancer/photofreelancer/default.jpg">';
                } else {
                    $id = $row['id_freelancer'];
                    $ex = $row['exentation'];
                    $namf = $id . '.' . $ex;
                    echo '<img src="../freelancer/photofreelancer/' . $namf . '">';
                }
                ?>
                <div class="info">
                    <h3><?php echo $row['first_name_free'] . ' ' . $row['last_name_free']; ?></h3>
                    <button> Freelancer Email : <?php echo $row['email_freelancer']; ?> </button>
                </div>
            </div>
            <button style="background-color: red; margin-left: 200px; font-size: 15px;">
                DATE : <?php echo $row['time_sent_message']; ?>
            </button><br>
            <center>
                <a href="messages.php?freelancer_id=<?php echo $row['id_freelancer']; ?>" 
                   class="inline-btn1" 
                   style="display: flex;">
                   Messages........<i class="fas fa-regular fas fa-comments"></i>
                </a>
            </center>
        </div>
    </div>
    <br>
<?php
        $displayed_freelancers[] = $row['id_freelancer'];
    }
}
?>
</section>
<?php include 'footer.php'; ?>
