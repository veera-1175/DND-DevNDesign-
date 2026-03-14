<?php
    session_start();
    include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    $sql_fetch = "SELECT * FROM freelancer WHERE id_freelancer = '$id'";
    $result_fetch = mysqli_query($conn, $sql_fetch);
    $row = mysqli_fetch_assoc($result_fetch);
    if(isset($_POST['submit'])) {
        $first_name_free = $_POST['first_name_free'];
        $last_name_free = $_POST['last_name_free'];
        $email_freelancer = $_POST['email_freelancer'];
        $password_freelancer = $_POST['password_freelancer'];
        $profession = $_POST['profession'];
        $hourly_rate = $_POST['hourly_rate'];
        $skills = $_POST['skills'];
        $languages = $_POST['languages'];
        $description_free = $_POST['description_free'];
        $experiences = $_POST['experiences'];
        $joined = $_POST['joined'];
        $sql = "UPDATE freelancer SET first_name_free='$first_name_free', last_name_free='$last_name_free', email_freelancer='$email_freelancer', password_freelancer='$password_freelancer',
                profession='$profession', hourly_rate='$hourly_rate', skills='$skills',
                languages='$languages', description_free='$description_free', experiences='$experiences', joined='$joined'
                WHERE id_freelancer = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: freelancers.php");
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
<h1>Edit Freelancer Information</h1>
<form method="post">

    <div class="form-row">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name_free" value="<?php echo $row['first_name_free']; ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name_free" value="<?php echo $row['last_name_free']; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email_freelancer" value="<?php echo $row['email_freelancer']; ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password_freelancer" value="<?php echo $row['password_freelancer']; ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Profession</label>
        <select name="profession">
            <option value="">Choose profession...</option>
            <?php
            $options = array("Developer", "Designer", "Programmer", "UI/UX Designer", "Game Developer","Other");
            foreach ($options as $option) {
                $selected = ($option == $row['profession']) ? 'selected' : '';
                echo "<option value='$option' $selected>$option</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Hourly Rate</label>
        <input type="number" name="hourly_rate" min="1" value="<?php echo floor($row['hourly_rate']); ?>">
    </div>

    <div class="form-group">
        <label>Skills</label>
        <input type="text" name="skills" value="<?php echo $row['skills']; ?>">
    </div>

    <div class="form-group">
        <label>Languages</label>
        <input type="text" name="languages" value="<?php echo $row['languages']; ?>">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description_free" rows="3"><?php echo $row['description_free']; ?></textarea>
    </div>

    <div class="form-group">
        <label>Experiences</label>
        <textarea name="experiences" rows="3"><?php echo $row['experiences']; ?></textarea>
    </div>

    <div class="form-group">
        <label>Joined Date</label>
        <input type="datetime-local" name="joined" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['joined'])) ?>">
    </div>

    <div class="form-actions">
        <button class="btn" type="submit" name="submit">Update</button>
        <button class="btn" type="button" onclick="window.location.href='freelancers.php'">Close</button>
    </div>

</form>
</div>
    <?php include 'footer.php'; ?>  