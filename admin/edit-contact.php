<?php
    session_start();
    include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    if(isset($_POST['submit'])) {
        $first_name_contact = $_POST['first_name_contact'];
        $last_name_contact = $_POST['last_name_contact'];
        $email_contact = $_POST['email_contact'];
        $subject_contact = $_POST['subject_contact'];
        $message_contact = $_POST['message_contact'];

        $sql = "UPDATE contact_us SET first_name_contact='$first_name_contact', last_name_contact='$last_name_contact', email_contact='$email_contact', subject_contact='$subject_contact', message_contact='$message_contact' WHERE id_contact = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: contact-us.php");
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
    <h1>Edit Contact Information</h1>
    <?php
        $sql = "SELECT * FROM contact_us WHERE id_contact = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group">
                <label>First Name:</label>
                <input name="first_name_contact" type="text" value="<?php echo $row['first_name_contact']; ?>">
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input name="last_name_contact" type="text" value="<?php echo $row['last_name_contact']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input name="email_contact" type="email" value="<?php echo $row['email_contact']; ?>">
        </div>

        <div class="form-group">
            <label>Subject:</label>
            <input name="subject_contact" type="text" value="<?php echo $row['subject_contact']; ?>">
        </div>

        <div class="form-group">
            <label>Contact Message:</label>
            <textarea name="message_contact" rows="3"><?php echo $row['message_contact']; ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='contact-us.php'">Close</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>