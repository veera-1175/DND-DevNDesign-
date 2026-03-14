<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id_client = $_SESSION['client_id'];

    $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;

    if (isset($_POST['completed'])) {
        $request_id = $_POST['id_request'];
        $completed_time = date("Y-m-d H:i:s");
        $sql = "UPDATE suivi_job SET status = 'completed', time_completed='$completed_time' WHERE id_request = $request_id";
        mysqli_query($conn, $sql);

        header("Location: completed-jobs.php");
        exit();
    }

    $sql = "SELECT j.title, f.id_freelancer, f.first_name_free, f.last_name_free, f.profession, f.statut, f.exentation, s.message_job, s.status, s.time_accepted, s.id_request
            FROM suivi_job s
            JOIN jobs j ON s.id_job = j.id_job
            JOIN freelancer f ON s.id_freelancer = f.id_freelancer
            WHERE j.id_client = $id_client AND s.status = 'accepted'";

    $result = mysqli_query($conn, $sql);
?>
    <div class="navbar-request">
        <div class="nav-center">
            <ul>
                <li><a href="all-requests.php" <?php if (basename($_SERVER['PHP_SELF']) == 'all-requests.php') { echo 'class="active"'; } ?>><i class="fas fa-list"></i><span>All Requests</span></a></li>
                <li><a href="requests-accepted.php" <?php if (basename($_SERVER['PHP_SELF']) == 'requests-accepted.php') { echo 'class="active"'; } ?>><i class="fa-solid fa-check"></i><span>Requests Accepted</span></a></li>
                <li><a href="completed-jobs.php" <?php if (basename($_SERVER['PHP_SELF']) == 'completed-jobs.php') { echo 'class="active"'; } ?>><i class="fas fa-check-square"></i><span>Completed Jobs</span></a></li>
            </ul>
        </div>
    </div>
    <section>
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="request">
            <div class="log">
                <?php   
                    if($row['statut']==0)  {
                        echo '<img class="image" src="../freelancer/photofreelancer/default.jpg">' ;
                    } else{
                        $ex = $row['exentation'];
                        $namf = $row['id_freelancer'] . '.' . $ex;
                        echo ' <img class="image" src="../freelancer/photofreelancer/'.$namf.'">';
                    }
                ?>
            </div>

            <div class="request_details">
                <div class="top_detail">
                    <div class="user_detail">
                        <h3><?php echo $row['first_name_free'] . ' ' . $row['last_name_free']; ?></h3>
                        <span>(<?php echo $row['profession']; ?>)</span>
                    </div>

                    <div class="more_detail">
                        <span>Accepted on <?php echo date('d/m/Y \a\\t H:i:s', strtotime($row['time_accepted'])); ?></span>
                    </div>
                </div>

                <span class="jobtitle">Job Title : <?php echo $row['title']; ?></span>
                
                <div class="request_para">
                    <p><?php echo $row['message_job']; ?></p>
                </div>

                <div class="request_action">
                    <a href="freelancer-profile.php?idfree=<?php echo $row['id_freelancer']; ?>"><button class="btt"><i class="fa-solid fa-user"></i></button></a>
                    <form method="POST">
                    <input type="hidden" name="id_request" value="<?php echo $row['id_request']; ?>">
                        <button class="btt" type="submit" name="completed"><i class="fa-solid fa-circle-check"></i></button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    </section>
<?php include('footer.php');?>
