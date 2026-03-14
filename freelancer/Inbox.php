<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'dnd');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT * FROM client 
          INNER JOIN messages ON client.id_client = messages.id_client 
          WHERE client.id_client = messages.id_client";
$result = mysqli_query($conn, $query);
$cli_data = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cli_data[] = $row;
    }
}
@include '../login/config.php';
$displayed_clients = array();
include 'common.php';
if (!isset($_SESSION['freelancer_name'])) {
    header('Location: login_form.php');
    exit();
}
?>
<section class="home-grid">
   <div class="box-container">
         <div class="imagee">
            <img src="img/originals/Group chat-60b6.png" alt="">
         </div>
   </div>
   <div class="box">
         <h2 class="title">Messages</h2>
         <p class="tutor">Here are all the clients you've contacted. </p>
         <hr>
   </div>
</section>
<section class="Requests">
<?php 
foreach ($cli_data as $cli) {
    if (!in_array($cli['id_client'], $displayed_clients)) {
?>
    <div class="box-container">
        <div class="box">
            <div class="tutor">
                <?php
                if ($cli['statut'] == 0) {
                    echo '<img src="../client/photoclient/default.jpg">';
                } else {
                    $ex = $cli['exentation'];
                    $namf = $cli['id_client'] . '.' . $ex;
                    echo '<img src="../client/photoclient/' . $namf . '">';
                }
                ?>
                <div class="info">
                    <h3><?php echo $cli['first_name_cli'] . ' ' . $cli['last_name_cli']; ?></h3>
                    <button> Client Email : <?php echo $cli['email_client'] ?> </button>
                </div>
            </div>
            <button style="margin-left: 200px; font-size: 15px;"> DATE : <?php echo $cli['time_sent_message'] ?></button><br>
            <a href="messages.php?client_id=<?php echo $cli['id_client']; ?>" class="inline-btn" style="display: flex;">Messages</a>
        </div>
    </div>
    <br>
<?php
        $displayed_clients[] = $cli['id_client'];
    }
}
?>
</section>
<?php include 'footer.php'; ?>
