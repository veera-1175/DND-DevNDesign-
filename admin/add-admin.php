<?php
    session_start();
include 'common.php';
@include '../login/config.php';

if(isset($_POST['submit'])) {
    $first_name_admin = $_POST['first_name_admin'];
    $last_name_admin = $_POST['last_name_admin'];
    $email_admin = $_POST['email_admin'];
    $password_admin = $_POST['password_admin'];

    $sql = "INSERT INTO admin (`first_name_admin`, `last_name_admin`, `email_admin`, `password_admin`)
    VALUES ('$first_name_admin','$last_name_admin','$email_admin','$password_admin')";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: admins.php");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>
<div class="form-container">
    <h1>Add New Admin</h1>
    <form action="" method="post">
    <div class="form-row">
    <div class="form-group">
    <label>First Name</label>
        <input type="text" name="first_name_admin" required placeholder="Enter first name">
</div>
<div class="form-group">
  <label>Last Name</label>
        <input type="text" name="last_name_admin" required placeholder="Enter last name">
</div>
</div>
<div class="form-group">
        <label>Email</label>
        <input type="email" name="email_admin" required placeholder="Enter email">
</div>
<div class="form-group">
        <label>Password</label>
        <input type="password" name="password_admin" required placeholder="Enter password">
</div>
        <div class="form-actions">
            <button type="submit" name="submit" class="btn">Add Admin</button>
            <button type="button" class="btn"onclick="window.location.href='admins.php'" >← Back to Admin List</button>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>