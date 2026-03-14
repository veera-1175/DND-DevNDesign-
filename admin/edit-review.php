<?php
    session_start();
    @include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    if(isset($_POST['submit'])) {
        $description = $_POST['description'];
        $rating = $_POST['rating'];
        $created__at = $_POST['created__at'];
        $sql = "UPDATE reviews SET description='$description', rating='$rating', created__at='$created__at' WHERE id_review = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: reviews.php");
        }else{
            echo "Failed: " . mysqli_error($conn);
        }
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>
<?php
        $sql = "SELECT * FROM reviews WHERE id_review = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <div class="form-container">
        <h1>Edit Review</h1>
        <form method="post">
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" rows="3"><?php echo $row['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Rating:</label>
                <select name="rating">
                    <option selected>Choose...</option>
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<option value="' . $i . '"';
                            if ($i == $row['rating']) {
                                echo ' selected';
                            }
                            echo '>' . $i . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Created At:</label>
                <input type="datetime-local" name="created__at" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['created__at'])) ?>">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn"name="submit" >Update</button>
                <button type="button" class="btn" onclick="window.location.href='reviews.php'" >Close</button>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>