<?php
    session_start();
    include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    if(isset($_POST['submit'])) {
        $first_name_cli = $_POST['first_name_cli'];
        $last_name_cli = $_POST['last_name_cli'];
        $email_client = $_POST['email_client'];
        $password_client = $_POST['password_client'];

        $sql = "UPDATE client SET first_name_cli='$first_name_cli', last_name_cli='$last_name_cli', email_client='$email_client', password_client='$password_client' WHERE id_client = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: clients.php");
        }else{
            echo "Failed: " . mysqli_error($conn);
        }
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>
        <div class="form-container">
    <h1>Edit Client Information</h1>
    <?php
        $sql = "SELECT * from client where id_client = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group">
                <label>First name:</label>
                <input name="first_name_cli" type="text" value="<?php echo $row['first_name_cli']; ?>">
            </div>
            <div class="form-group">
                <label>Last name:</label>
                <input name="last_name_cli" type="text" value="<?php echo $row['last_name_cli']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input name="email_client" type="email" value="<?php echo $row['email_client']; ?>">
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input name="password_client" type="password" value="<?php echo $row['password_client']; ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='clients.php'">Close</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
