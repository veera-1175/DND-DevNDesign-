<?php
    session_start();

    @include '../login/config.php';
    include 'common.php';
    $id_admin = $_SESSION['admin_id'];

    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);

    // The number of freelancers who create an account
    $sql_freelancers = "SELECT count(*) from freelancer";
    $result_freelancers = mysqli_query($conn, $sql_freelancers);
    if (!$result_freelancers) {
        die("Error: " . mysqli_error($conn));
    }
    $row_freelancers = mysqli_fetch_array($result_freelancers);
    $freelancers_count = implode(',', $row_freelancers);

    // The number of clients who create an account
    $sql_clients = "SELECT count(*) from client";
    $result_clients = mysqli_query($conn, $sql_clients);
    if (!$result_clients) {
        die("Error: " . mysqli_error($conn));
    }
    $row_clients = mysqli_fetch_array($result_clients);
    $clients_count = implode(',', $row_clients);

    // The number of jobs available
    $sql_jobs = "SELECT count(*) from jobs";
    $result_jobs = mysqli_query($conn, $sql_jobs);
    if (!$result_jobs) {
        die("Error: " . mysqli_error($conn));
    }
    $row_jobs = mysqli_fetch_array($result_jobs);
    $jobs_count = implode(',', $row_jobs);
?>
      <section class="center-box-info">
            <ul class="box-info">
				<li>
                    <a href="freelancers.php"><i class="bx fa-sharp fa-solid fa-user-tie"></i></a>
					<span class="text">
						<h3><?php echo intval($freelancers_count); ?></h3>
						<p>Freelancers</p>
					</span>
				</li>
				<li>
                <a href="clients.php"><i class="bx fa-sharp fa-solid fa-user"></i></a>
					<span class="text">
						<h3><?php echo intval($clients_count); ?></h3>
						<p>Clients</p>
					</span>
				</li>
				<li>
                <a href="jobs.php"><i class='bx fa-solid fa-list' ></i></a>
					<span class="text">
						<h3><?php echo intval($jobs_count); ?></h3>
						<p>Jobs posted</p>
					</span>
				</li>
			</ul>
        </section>
<?php include 'footer.php';?>