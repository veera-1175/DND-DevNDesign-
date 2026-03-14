<?php
session_start();
include 'common.php';
$conn = mysqli_connect('localhost', 'root', '', 'dnd');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$freelancer_id = $_SESSION['freelancer_id'];
$query = "
    SELECT
        jobs.*,
        client.statut,
        client.first_name_cli,
        client.last_name_cli,
        client.exentation
    FROM jobs
    INNER JOIN client ON client.id_client = jobs.id_client
";
$result = mysqli_query($conn, $query);
$initial_jobs = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $initial_jobs[] = $row;
    }
} else {
    echo "Error fetching jobs: " . mysqli_error($conn);
    $initial_jobs = [];
}
@include '../login/config.php';
if (!isset($_SESSION['freelancer_name'])) {
    header('location:login_form.php');
    exit();
}
$sell = "SELECT * FROM freelancer";
$qyerry = mysqli_query($conn, $sell);
$resul = mysqli_fetch_assoc($qyerry);
$jobs_to_display = $initial_jobs;
if (isset($_GET['search_box'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
    $sql = "
        SELECT
            jobs.*,
            client.statut,
            client.first_name_cli,
            client.last_name_cli,
            client.exentation
        FROM jobs
        INNER JOIN client ON client.id_client = jobs.id_client
        WHERE jobs.title LIKE '%$search_query%'
        AND jobs.job_status = 'public'
    ";

    $result3 = mysqli_query($conn, $sql);

    if ($result3) {
        $searched_jobs_mysqli = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        $jobs_to_display = $searched_jobs_mysqli;
    } else {
        echo "Error in search query: " . mysqli_error($conn);
        $jobs_to_display = [];
    }
}
?>
<head>
   <link rel="stylesheet" href="../client/CSS/style.css">
</head>
<section class="home-grid">
    <div style="text-align:center;">
        <form action="" method="get" class="search-form">
            <input type="text" name="search_box" required placeholder="Search Jobs..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
        </form>
    </div>
    <div class="box-container">
        <div class="imagee">
            <img src="img/originals/Internet-60b6.png" alt="">
        </div>
    </div>
    <div class="box">
        <h2 class="title">JOBS</h2>
        <p class="tutor">Choose between the jobs, and find the one you like!</p>
        <hr>
    </div>
</section>
<section class="Requests">
    <?php
    if (empty($jobs_to_display)) {
        echo "<p class='empty'>No jobs found!</p>";
    } else {
        foreach ($jobs_to_display as $job) {
    ?>
    <div class="box-container">
        <div class="box">
            <div class="tutor">
                <?php
                    if ($job['statut'] == 0) {
                        echo '<img src="../client/photoclient/default.jpg">';
                    } else {
                        $id = $job['id_client'];
                        $ex = $job['exentation'];
                        $namf = $id . '.' . $ex;
                        echo '<img src="../client/photoclient/' . $namf . '">';
                    }
                ?>
                <div class="info">
                    <h3><?php echo $job['first_name_cli'] . ' ' . $job['last_name_cli']; ?></h3>
                    <button> Job type: <?php echo $job['type']; ?> </button>
                </div>
            </div>
            <h3 class="title" style="margin-left: 20px;"><?php echo $job['title']; ?></h3>
            <button style="background-color: red;margin-left: 20px; font-size: 15px;">Category: <?php echo $job['category']; ?></button><br>
            <span style="color: red; margin-left: 20px; font-size: 15px;">Delivery time: <?php echo $job['time']; ?> days</span>
            <br><br>
            <div class="card" style="background-color: #f0f0f0; transition: all .3s ease; box-shadow: 0px 3px 15px 3px rgba(0,0,0,0.15);">
                <p class="descriptionn"><?php echo $job['description']; ?></p>
            </div>
            <br>
            <a href="messages.php?client_id=<?php echo $job['id_client']; ?>" class="inline-btn">Send a message</a>
            <a href="request.php?client_id=<?php echo $job['id_client']; ?>&job_id=<?php echo $job['id_job']; ?>" class="inline-btn">Send a request</a>
        </div>
    </div>
    <br>
    <?php
        }
    }
    ?>
</section>
<?php include('footer.php'); ?>
