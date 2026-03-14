<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id_client = $_SESSION['client_id'];
    $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
    // Check if search query parameter is set
    if(isset($_GET['search_box'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
        $sql = "SELECT * FROM freelancer WHERE CONCAT(first_name_free, ' ', last_name_free) LIKE '%$search_query%'";
    } else {
        $sql = "SELECT * FROM freelancer";
    }
    $result3 = mysqli_query($conn, $sql);
    function get_completed_jobs_count($freelancer_id) {
        $conn = mysqli_connect('localhost', 'root', '', 'dnd');
    
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        // Count the number of completed jobs for the freelancer
        $sql = "SELECT COUNT(*) AS count FROM suivi_job WHERE id_freelancer = '$freelancer_id' AND status = 'completed'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
    
        mysqli_close($conn);
    
        return $count;
    }
?>
    <section>
        <div style="text-align:center;">
            <form action="" method="get" class="search-form">
                <input type="text" name="search_box" required placeholder="search freelancers..." maxlength="100">
                <button type="submit" class="fas fa-search"></button>
            </form>
        </div>

        <div class="main-free" style="margin-top: 20px;">
            <?php while ($row = mysqli_fetch_assoc($result3)) { ?>
            <div class="profile-card-free">
                <div class="image-free">
                    <?php   
                        if($row['statut']==0)  {
                        echo '<img class="profile-pic-free" src="../freelancer/photofreelancer/default.jpg">' ;
                        } 
                        else{
                            $id=$row['id_freelancer'];

                            $ex=$row['exentation'];
                            $namf=$id.'.'.$ex;
                            echo ' <img class="profile-pic-free" src="../freelancer/photofreelancer/'.$namf.'">';
                        }
                    ?>
                </div>

                <div class="data-free">
                    <h2><?php echo $row['first_name_free'] . ' ' . $row['last_name_free']; ?></h2>
                    <span><?php echo $row['profession']; ?></span>
                </div>

                <div class="row-free">
                    <div class="info-free">
                        <h3>Hourly Rate</h3>
                        <span>₹<?php echo $row['hourly_rate']; ?>/hour</span>
                    </div>

                    <div class="info-free">
                        <h3>Job Success</h3>
                        <span><?php echo get_completed_jobs_count($row['id_freelancer']); ?></span>
                    </div>
                </div>

                <div class="rating">
                    <?php
                        $freelancer_id = $row['id_freelancer'];
                        $avg_query = "SELECT AVG(rating) AS average_rating, COUNT(*) AS review_count FROM reviews WHERE id_freelancer = $freelancer_id";
                        $avg_result = mysqli_query($conn, $avg_query);
                        $avg_row = mysqli_fetch_assoc($avg_result);
                        $avg_rating = $avg_row['average_rating'];
                        $review_count = $avg_row['review_count'];
                        $stars = round($avg_rating * 2) / 2;
                        $full_stars = floor($stars);
                        $half_star = ceil($stars - $full_stars);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $full_stars) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($half_star == 1 && $i == $full_stars + 1) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                    ?>
                </div>

                <h3>(<?php echo $review_count; ?> Reviews)</h3>

                <div class="buttons-free">
                    <a href="messages.php?freelancer_id=<?php echo $row['id_freelancer']; ?>" class="btttn">Message</a>
                    <a href="freelancer-profile.php?idfree=<?php echo $row['id_freelancer']; ?>" class="btttn">View Profile</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
<?php include('footer.php');?>
