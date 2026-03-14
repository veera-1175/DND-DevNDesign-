<?php
session_start();
include('common.php');
$conn = mysqli_connect("localhost", "root", "", "dnd");

if (isset($_GET['id_cli'])) {
    $id_client = $_GET['id_cli'];
    $query = "SELECT * FROM client WHERE id_client = '$id_client'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }
}
    $client = mysqli_fetch_assoc($result);
if (isset($_POST['submit'])) {
    $id_client = $_GET['id_cli'];
    $id_freelancer = $_SESSION['freelancer_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rating = $_POST['rating'];
    $created_at = date("Y-m-d H:i:s");
    // Check if freelancer already reviewed the client
    $check_query = "SELECT * FROM reviews WHERE id_client = '$id_client' AND id_freelancer = '$id_freelancer'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('You have already reviewed this client.')</script>";
    } else {
        $query = "INSERT INTO reviews (id_client, id_freelancer, description, rating, created__at, review_type) VALUES ('$id_client', '$id_freelancer', '$description', '$rating', '$created_at', 'freelancer_to_client')";       if (!mysqli_query($conn, $query)) {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
$id_freelancer = $_SESSION['freelancer_id'];
$sql = "SELECT * FROM freelancer WHERE id_freelancer = '$id_freelancer'";
$req = mysqli_query($conn, $sql);
$num_ligne = mysqli_fetch_assoc($req);

// Delete review
if (isset($_GET['delete_review'])) {
    $review_id = $_GET['delete_review'];

    $select_query = "SELECT id_freelancer FROM reviews WHERE id_review = '$review_id'";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);
    $review_owner_id = $row['id_freelancer'];

    if ($review_owner_id == $id_freelancer) {
        $delete_query = "DELETE FROM reviews WHERE id_review = '$review_id'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<script>alert('Review deleted successfully.');</script>";
            echo "<script>window.location.href='client-profile.php?id_cli=$id_client';</script>";
        } else {
            echo "Error deleting review: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('You are not authorized to delete this review.');</script>";
    }
}

// Get completed jobs count
function get_jobs_count($client_id) {
    $conn = mysqli_connect('localhost', 'root', '', 'dnd');
    if (!$conn) die("Connection failed: " . mysqli_connect_error());

    $sql = "SELECT COUNT(*) AS count FROM jobs WHERE id_client = '$client_id'"; // Added condition for completed jobs
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['count'];
}
?>
<head>
    <link rel="stylesheet" href="../client/CSS/style.css">
</head>
<section>
    <div class="free-container">
        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <div class="sidebar-profile-box">
                <div class="sidebar-profile-info">
                    <center><?php
                        if ($client['statut'] == 0) {
                            echo '<img class="profile-pic-free" src="../client/photoclient/default.jpg">';
                        } else {
                            $id = $client['id_client'];
                            $ex = $client['exentation'];
                            $namf = $id . '.' . $ex;
                            echo '<img class="profile-pic-free" src="../client/photoclient/' . $namf . '">';
                        }
                    ?></center>
                    <h1><?php echo $client['first_name_cli'] . ' ' . $client['last_name_cli']; ?></h1>
                    <ul>
                        <li>Jobs Posted : <span><?php echo get_jobs_count($client['id_client']); ?></span></li>  <!-- Updated label to Jobs Completed -->
                        <?php
                            $client_id = $client['id_client'];
                            $avg_query = "SELECT AVG(rating) AS average_rating FROM reviews WHERE id_client = $client_id";
                            $avg_result = mysqli_query($conn, $avg_query);

                            if (!$avg_result) {
                                // Handle query error for average rating
                                $avg_rating = 'N/A'; // Or some default value
                                $num_reviews = 0;
                                echo "<li>Rating <span>Error fetching rating</span></li>";
                            } else {
                                $avg_rating_data = mysqli_fetch_assoc($avg_result);
                                $avg_rating = round($avg_rating_data['average_rating'], 1);

                                $num_reviews_query = "SELECT COUNT(*) AS num_reviews FROM reviews WHERE id_client = $client_id";
                                $num_reviews_result = mysqli_query($conn, $num_reviews_query);
                                $num_reviews = mysqli_fetch_assoc($num_reviews_result)['num_reviews'];
                                echo "<li>Rating <span>$avg_rating / 5 ($num_reviews reviews)</span></li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class="sidebar-profile-link">
                    <a href="messages.php?client_id=<?php echo $client['id_client']; ?>"><i class="fa-solid fa-message"></i> Message</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="headingg">
                <h1>Freelancer Reviews</h1>
                <a class="contact-form-bttn" id="add-review-btn">Add Review</a>
            </div>

            <?php
                    $reviews_query = "SELECT reviews.*, freelancer.first_name_free, freelancer.last_name_free, freelancer.statut, freelancer.exentation
                    FROM reviews
                    JOIN freelancer ON reviews.id_freelancer = freelancer.id_freelancer
                    WHERE reviews.id_client = '$id_client'
                    AND reviews.review_type = 'freelancer_to_client'  -- Added review_type filter
                    ORDER BY reviews.created__at DESC";
                $reviews_result = mysqli_query($conn, $reviews_query);
                while ($review = mysqli_fetch_assoc($reviews_result)) {
            ?>
            <div class="review-box">
                <div class="box-top">
                    <div class="profile-cont">
                        <div class="profile-img">
                            <?php
                                if ($review['statut'] == 0) {
                                    echo '<img class="image" src="photofreelancer/default.jpg">';
                                } else {
                                    $review_img = $review['id_freelancer'] . '.' . $review['exentation'];
                                    echo '<img class="image" src="photofreelancer/' . $review_img . '">';
                                }
                            ?>
                        </div>
                        <div class="name-user">
                            <strong><?php echo $review['first_name_free'] . ' ' . $review['last_name_free']; ?></strong>
                            <span>Posted on <?php echo date("d/m/Y", strtotime($review['created__at'])); ?></span>
                        </div>
                    </div>

                    <div class="reviews">
                        <?php
                            $rating = $review['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $rating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            }
                        ?>
                    </div>

                    <?php if ($review['id_freelancer'] == $id_freelancer) : ?>
                        <a href="?id_cli=<?php echo $id_client; ?>&delete_review=<?php echo $review['id_review']; ?>" style="position:absolute;top:10px;right:10px;">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="client-review">
                    <p><?php echo $review['description']; ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Add Review Popup -->
<div class="popup" id="add-review-popup">
    <section class="account-form">
        <form action="" method="post">
            <div class="location">
                <a href="client-profile.php?id_cli=<?php echo $id_client; ?>">
                    <button class="bbtt" type="button" style="background: transparent; cursor: pointer;">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </a>
            </div>
            <h3 class="heading">Post Your Review</h3>
            <p class="placeholder">Review Description</p>
            <textarea name="description" class="booxx" placeholder="Enter review description..." maxlength="1000" cols="30" rows="10" required></textarea>
            <p class="placeholder">Review Rating</p>
            <select name="rating" class="booxx" required>
                <option value="">Select rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <div class="submit-review">
                <input type="submit" value="Submit Review" name="submit" class="contact-form-btttn">
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