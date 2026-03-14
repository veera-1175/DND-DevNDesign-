<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id_freelancer = $_SESSION['freelancer_id'];
    $sql="SELECT * FROM freelancer WHERE id_freelancer = '$id_freelancer'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
    if(isset($_GET['search_box'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
        $sql = "SELECT * FROM client WHERE CONCAT(first_name_cli, ' ', last_name_cli) LIKE '%$search_query%'";
    } else {
        $sql = "SELECT * FROM client";
    }
    $result3 = mysqli_query($conn, $sql);
?>
<head>
    <link rel="stylesheet" href="../client/CSS/style.css">
</head>
    <section>
        <div style="text-align:center;">
            <form action="" method="get" class="search-form">
                <input type="text" name="search_box" required placeholder="Search Clients..." maxlength="100">
                <button type="submit" class="fas fa-search"></button>
            </form>
        </div>

        <div class="main-free" style="margin-top: 20px;">
            <?php while ($row = mysqli_fetch_assoc($result3)) { ?>
            <div class="profile-card-free">
                <div class="image-free">
                    <?php   
                        if($row['statut']==0)  {
                        echo '<img class="profile-pic-free" src="../client/photoclient/default.jpg">' ;
                        } 
                        else{
                            $id=$row['id_client'];
                            $ex=$row['exentation'];
                            $namf=$id.'.'.$ex;
                            echo ' <img class="profile-pic-free" src="../client/photoclient/'.$namf.'">';
                        }
                    ?>
                </div>
                <div class="data-free">
                    <h2><?php echo $row['first_name_cli'] . ' ' . $row['last_name_cli']; ?></h2>
                </div>
                <div class="rating">
                    <?php
                        $client_id = $row['id_client'];
                        $avg_query = "SELECT AVG(rating) AS average_rating, COUNT(*) AS review_count FROM reviews WHERE id_client = $client_id AND review_type = 'freelancer_to_client'";
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
                    <a href="messages.php?client_id=<?php echo $row['id_client']; ?>" class="btttn">Message</a>
                    <a href="client-profile.php?id_cli=<?php echo $row['id_client']; ?>" class="btttn">View Profile</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
<?php include('footer.php');?>
