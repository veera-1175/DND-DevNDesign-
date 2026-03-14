<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    if (isset($_GET['idfree'])) {
        $id_freelancer = $_GET['idfree'];
        $query = "SELECT * FROM freelancer WHERE id_freelancer = '$id_freelancer'";
        $result = mysqli_query($conn, $query);
        $freelancer = mysqli_fetch_assoc($result);
    }
    if (isset($_POST['submit'])) {
        $id_freelancer = $_GET['idfree'];
        $id_client = $_SESSION['client_id'];
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $rating = $_POST['rating'];
        $created_at = date("Y-m-d H:i:s");
        $check_query = "SELECT * FROM reviews WHERE id_freelancer = '$id_freelancer' AND id_client = '$id_client'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('You have already reviewed this freelancer.')</script>";
        } else {
            $query = "INSERT INTO reviews (id_freelancer, id_client, description, rating, created__at, review_type) VALUES ('$id_freelancer', '$id_client', '$description', '$rating', '$created_at', 'client_to_freelancer')";
            if (mysqli_query($conn, $query)) {
                echo "Review added successfully!";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
    $id_client = $_SESSION['client_id'];

    $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;

    if (isset($_GET['delete_review'])) {
        $review_id = $_GET['delete_review'];
        $select_query = "SELECT id_client FROM reviews WHERE id_review = '$review_id'";
        $result = mysqli_query($conn, $select_query);
        $row = mysqli_fetch_assoc($result);
        $review_owner_id = $row['id_client'];
        if ($review_owner_id == $id_client) {
            $delete_query = "DELETE FROM reviews WHERE id_review = '$review_id'";
            if (mysqli_query($conn, $delete_query)) {
                echo "<script>alert('Review deleted successfully.')</script>";
                header("Location: freelancer-profile.php?idfree=$id_freelancer");
            } else {
                echo "Error deleting review: " . mysqli_error($conn);
            }
        } else {
            echo "You are not authorized to delete this review.";
        }
    }
    $profile_views = $freelancer['profile_views'] + 1;
    $sql = "UPDATE freelancer SET profile_views = '$profile_views' WHERE id_freelancer = '$id_freelancer'";
    mysqli_query($conn, $sql);
    function get_completed_jobs_count($freelancer_id) {
        $conn = mysqli_connect('localhost', 'root', '', 'dnd');
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT COUNT(*) AS count FROM suivi_job WHERE id_freelancer = '$freelancer_id' AND status = 'completed'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        mysqli_close($conn);
        return $count;
    }
?>
<section>
        <div class="free-container">
            <div class="left-sidebar">
                <div class="sidebar-profile-box">
                    <div class="sidebar-profile-info">
                        <?php   
                            if($freelancer['statut']==0)  {
                            echo '<img class="profile-pic-free" src="../freelancer/photofreelancer/default.jpg">' ;
                            } 
                            else{
                                $id=$freelancer['id_freelancer'];
                                $ex=$freelancer['exentation'];
                                $namf=$id.'.'.$ex;
                                echo ' <img class="profile-pic-free" src="../freelancer/photofreelancer/'.$namf.'">';
                            }
                        ?>
                        <h1><?php echo $freelancer['first_name_free'] . ' ' . $freelancer['last_name_free']; ?></h1>
                        <h3><?php echo $freelancer['profession']; ?></h3>
                        <ul>
                            <li>Joined<span><?php echo date('F d, Y', strtotime($freelancer['joined'])); ?></span></li>
                            <li>Hourly Rate<span><?php echo '₹' . $freelancer['hourly_rate'] . ' RS / hour'; ?></span></li>
                            <li>Profile views<span><?php echo $freelancer['profile_views']; ?></span></li>
                            <li>Completed Jobs<span><?php echo get_completed_jobs_count($freelancer['id_freelancer']); ?></span></li>
                            <?php
                                $freelancer_id = $freelancer['id_freelancer'];
                                $avg_query = "SELECT AVG(rating) AS average_rating FROM reviews WHERE id_freelancer = $freelancer_id";
                                $avg_result = mysqli_query($conn, $avg_query);
                                $avg_rating = mysqli_fetch_assoc($avg_result)['average_rating'];
                                $num_reviews_query = "SELECT COUNT(*) AS num_reviews FROM reviews WHERE id_freelancer = $freelancer_id";
                                $num_reviews_result = mysqli_query($conn, $num_reviews_query);
                                $num_reviews = mysqli_fetch_assoc($num_reviews_result)['num_reviews'];
                            ?>
                            <li>Rating<span><?php echo round($avg_rating, 1) . ' / 5 (' . $num_reviews . ' reviews)'; ?></span></li>
                        </ul>
                    </div>
                    <div class="sidebar-profile-link">
                        <a href="messages.php?freelancer_id=<?php echo $_GET['idfree']; ?>"><i class="fa-solid fa-message"></i>Message</a>
                    </div>
                    <div class="sidebar-skills">
                        <h3>Skills</h3>
                        <?php 
                            $skills = explode(',', $freelancer['skills']); 
                            foreach ($skills as $skill) {
                                echo '<a href="#"><i class="fa-solid fa-arrow-right"></i>' . $skill . '</a>';
                            }
                        ?>
                    </div>
                    <div class="sidebar-languages">
                        <h3>Languages</h3>
                        <?php 
                            $languages = explode(',', $freelancer['languages']); 
                            foreach ($languages as $language) {
                                echo '<a href="#"><i class="fa-solid fa-arrow-right"></i>' . $language . '</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="headingg">
                    <h1>Client reviews</h1>
                    <a class="contact-form-bttn" id="add-review-btn">add review</a>
                </div>
                <?php
                    $reviews_query = "SELECT reviews.*, client.first_name_cli, client.last_name_cli, client.statut, client.exentation
                    FROM reviews
                    JOIN client ON reviews.id_client = client.id_client  -- Join with client table now
                    WHERE reviews.id_freelancer = '$id_freelancer'  -- Filter by freelancer ID
                    AND reviews.review_type = 'client_to_freelancer' -- Filter for client reviews
                    ORDER BY reviews.created__at DESC";                    $reviews_result = mysqli_query($conn, $reviews_query);
                    while ($review = mysqli_fetch_assoc($reviews_result)) {
                ?>
                <div class="review-box">
                    <div class="box-top">
                        <div class="profile-cont">
                            <div class="profile-img">
                                <?php   
                                    if($review['statut']==0)  {
                                        echo '<img class="image" src="photoclient/default.jpg">' ;
                                    } else{
                                        $ex = $review['exentation'];
                                        $namf = $review['id_client'] . '.' . $ex;
                                        echo ' <img class="image" src="photoclient/'.$namf.'">';
                                    }
                                ?>
                            </div>
                            <div class="name-user">
                                <strong><?php echo $review['first_name_cli'] . ' ' . $review['last_name_cli']; ?></strong>
                                <span>Posted on <?php echo date("d/m/Y", strtotime($review['created__at'])); ?></span>
                            </div>
                        </div>
                        <div class="reviews">
                            <?php
                                $rating = $review['rating'];
                                for($i = 1; $i <= 5; $i++) {
                                    if($i <= $rating) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                            ?>
                        </div>
                        <?php if ($review['id_freelancer'] == $id_freelancer && $review['id_client'] == $id_client): ?>
                            <a href="?idfree=<?php echo $id_freelancer; ?>&delete_review=<?php echo $review['id_review']; ?>" style="position: absolute; top: 10px; right: 10px;"><i class="fa-solid fa-trash"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="client-review">
                        <p><?php echo $review['description']; ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="right-sidebar">
                <div class="sidebar-description">
                    <h3>Description</h3>
                    <p><?php echo $freelancer['description_free']; ?></p>
                </div>
                <div class="sidebar-experience">
                    <h3>Experience</h3>
                    <p><?php echo $freelancer['experiences']; ?></p>
                </div>
            </div>
        </div>
    </section>
    <div class="popup" id="add-review-popup">
        <section class="account-form">
            <form action="" method="post">
                <div class="location">
                    <a href="freelancer-profile.php?idfree=<?php echo $id_freelancer; ?>">
                        <button class="bbtt" type="button" style="background: transparent; cursor: pointer;">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </a>
                </div>
                <h3 class="heading">post your review</h3>
                <p class="placeholder">Review description</p>
                <textarea name="description" class="booxx" placeholder="Enter review description..." maxlength="1000" cols="30" rows="10"></textarea>
                <p class="placeholder">Review rating</p>
                <select name="rating" class="booxx" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <div class="submit-review">
                    <input type="submit" value="submit review" name="submit" class="contact-form-btttn">
                </div>
            </form>
        </section>
    </div>
    <script>
        const addReviewBtn = document.getElementById("add-review-btn");
        const addReviewPopup = document.getElementById("add-review-popup");

        addReviewBtn.addEventListener("click", () => {
            addReviewPopup.classList.toggle("show");
        });
    </script>
<?php include('footer.php'); ?>