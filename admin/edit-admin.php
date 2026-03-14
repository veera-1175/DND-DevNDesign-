<?php
    session_start();

    @include '../login/config.php';
include 'common.php';
    $id = $_GET['idad'];

    if(isset($_POST['submit'])) {
        $first_name_admin = $_POST['first_name_admin'];
        $last_name_admin = $_POST['last_name_admin'];
        $email_admin = $_POST['email_admin'];
        $password_admin = $_POST['password_admin'];

        $sql = "UPDATE admin SET first_name_admin='$first_name_admin', last_name_admin='$last_name_admin', email_admin='$email_admin', password_admin='$password_admin' WHERE id_admin = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: admins.php");
        }else{
            echo "Failed: " . mysqli_error($conn);
        }
    }
    
    $id_admin = $_SESSION['admin_id'];

    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?><div class="form-container">
<h1>Edit Admin Information</h1>

<?php
    $sql = "SELECT * FROM admin WHERE id_admin = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>

<form method="post">
    <div class="form-row">
        <div class="form-group">
            <label>First Name:</label>
            <input name="first_name_admin" type="text" value="<?php echo $row['first_name_admin']; ?>">
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <input name="last_name_admin" type="text" value="<?php echo $row['last_name_admin']; ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input name="email_admin" type="email" value="<?php echo $row['email_admin']; ?>">
    </div>

    <div class="form-group" style="margin-top:16px;">
        <label>Password:</label>
        <input name="password_admin" type="password" value="<?php echo $row['password_admin']; ?>">
    </div>

    <div class="form-actions">
        <button type="submit" name="submit"class="btn">Update</button>
        <button type="button" class = "btn"onclick="window.location.href='admins.php'" >Close</button>
    </div>
</form>
</div>
<?php include 'footer.php'; ?>