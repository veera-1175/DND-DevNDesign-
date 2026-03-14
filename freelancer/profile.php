<?php
    session_start();
    include '../login/config.php';
    include 'common.php';
    if (isset($_POST['submit'])) {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $profession = mysqli_real_escape_string($conn, $_POST['profession']);
        $hourly_rate = mysqli_real_escape_string($conn, $_POST['hourly_rate']);
        $skills = mysqli_real_escape_string($conn, $_POST['skills']);
        $languages = mysqli_real_escape_string($conn, $_POST['languages']);
        $description_free = mysqli_real_escape_string($conn, $_POST['description_free']);
        $experiences = mysqli_real_escape_string($conn, $_POST['experiences']);  
        $freelancer_id = $_SESSION['freelancer_id'];

        $query = "UPDATE freelancer SET first_name_free = '$first_name', last_name_free = '$last_name', email_freelancer = '$email', profession = '$profession', hourly_rate = '$hourly_rate', skills = '$skills' , languages = '$languages' , experiences = '$experiences' WHERE id_freelancer = '$freelancer_id'";
        mysqli_query($conn, $query);

        $current_password = mysqli_real_escape_string($conn, md5($_POST['current_password']));
        $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
        $repeat_new_password = mysqli_real_escape_string($conn, md5($_POST['repeat_new_password']));

        if(!empty($current_password) || !empty($new_password) || !empty($repeat_new_password)){
            $old_pass = $_POST['old_pass'];
            if($current_password != $old_pass){
                $message[] = 'old password not matched!';
            }elseif($new_password != $repeat_new_password){
                $message[] = 'confirm password not matched!';
            }else{
                mysqli_query($conn, "UPDATE freelancer SET password_freelancer = '$repeat_new_password' WHERE id_freelancer = '$freelancer_id'") or die('query failed');
                $message[] = 'password updated successfully!';
            }
        }
        header("Location: profile.php");
        exit();
    }
    $freelancer_id = $_SESSION['freelancer_id'];
    $select = mysqli_query($conn, "SELECT * FROM freelancer WHERE id_freelancer = '$freelancer_id'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
    $query = "SELECT first_name_free, last_name_free, email_freelancer, profession, hourly_rate, skills, languages, description_free, experiences FROM freelancer WHERE id_freelancer = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $freelancer_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $email, $profession, $hourly_rate, $skills, $languages, $description_free, $experiences);
    $stmt->fetch();
    $stmt->close();
?>
<?php
    $ex=$fetch['exentation'];
    if(isset( $_FILES['cr']["name"])){
        $fileType = $_FILES['cr']["type"];
        $fileData =  $_FILES['cr']["tmp_name"];
        $sizeData =  $_FILES['cr']["size"];
        $fileName= $_FILES['cr']["name"];
        $fileNameParts = explode('.', $fileName);
        $ext = end($fileNameParts);
        $nemnew=$freelancer_id.'.'.$ext;
        $n=1;

        if($ext=='jpg' || $ext=='jpge'  || $ext=='png'  ){
            $sql9= "UPDATE freelancer set statut='$n', exentation='$ext' where id_freelancer='$freelancer_id'";
            $result4 = mysqli_query($conn, $sql9 );
            move_uploaded_file($fileData,'C:\xampp\htdocs\DND\freelancer\photofreelancer\\'.$nemnew);
        }else{
            echo "error upload photo";
        }
    }
?>
<form action="" method="POST" enctype="multipart/form-data">
        <section>
            <div class="headline">
                <h3><i class="fa-regular fa-circle-user"></i> My Account</h3>
            </div>
            <div class="section-wrapper">
                <div class="avatar-wrapper" style="margin-left: 18px;">
                    <?php   
                        if($fetch['statut']==0)  {
                            echo '<img class="profile-pic" src="photofreelancer/default.jpg">' ;
                        } 
                        else{
                            $ex=$fetch['exentation'];
                            $namf=$freelancer_id.'.'.$ex;
                            echo ' <img class="profile-pic" src="photofreelancer/'.$namf.'">';
                        }
                    ?>
                </div>
                <div class="fields" style="margin-top: -18px;">
                    <div class="infos">
                        <h5>Upload new profile picture</h5>
                        <input type="file" name="cr">
                        <button class="inline-btn" type="submit" name="sub" value="send" style="font-size: 1rem; padding: .95rem 1.2rem; font-weight: 900;">Update</button>
                    </div>
                </div>
            </div>  
            <div class="section-wrapper" style="margin-bottom: 50px;">
                <div class="infos">
                    <div class="fields">
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                                <h5>First Name</h5>
                                <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                            </div>
                        </div>  
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                            <h5>Last Name</h5>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                            </div>
                        </div>
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                                <h5>Email</h5>
                                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" style="width: 350px;">
                            </div>
                        </div>
                    </div>
                    <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                                <select class="form-control" name="profession">
                                    <option value="" selected>Choose profession...</option>
                                    <?php
                                    $options = array(
                                        "Developer",
                                        "Designer",
                                        "Other"
                                    );
                                foreach ($options as $option) {
                                    $selected = ($option == $row['profession']) ? 'selected' : '';
                                    echo "<option value='$option' $selected>$option</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
        </section>
        <section>
            <div class="headline">
                <h3><i class="fa-regular fa-circle-user"></i> Other infos</h3>
            </div>

            <div class="section-wrapper" style="margin-bottom: 50px;">
            <center><div class="fields" style="grid-template-columns: repeat(2, 1fr); display: grid;width: 110%;margin-right: -30px;">
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                                <h5>Skills</h5>
                                <input type="text" name="skills" value="<?php echo htmlspecialchars($skills); ?>">
                            </div>
                        </div>
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                                <h5>languages</h5>
                                <input type="text" name="languages" value="<?php echo htmlspecialchars($languages); ?>">
                            </div>
                        </div>
                        <div class="field-submit" style="margin-right: 15px;">
                            <div class="card">
                            <h5>experiences</h5>
                            <textarea name="experiences" cols="70" rows="5" id="experiences" ><?php echo htmlspecialchars($experiences); ?></textarea>
                            </div>
                        </div>
                        <div class="field-submit" style="margin-right: 15px;">
                        <div class="card">
                        <h5 for="description_free">Description</h5>
                            <textarea name="description_free" cols="70" rows="5" id="description_free" ><?php echo htmlspecialchars($description_free); ?></textarea>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section style="padding-top: 0;">
            <div class="headline" style="margin-bottom: -30px;">
                <h3><i class="fa-solid fa-lock"></i> Password & Security</h3>
            </div>
            <div class="section-wrapper" >
                <div class="infos">
                    <div class="fields">
                        <input type="hidden" name="old_pass" value="<?php echo $fetch['password_freelancer']; ?>">
                        <br>
                        <div class="card" style="width: 100%; margin-top: 20px;">
                           <div class="field-submit">
                              <h5>Current Password</h5>
                              <input type="password" name="current_password">
                           </div>
                           
                           <div class="field-submit">
                              <h5>New Password</h5>
                              <input type="password" name="new_password">
                           </div>
                           
                           <div class="field-submit">
                              <h5>Repeat New Password</h5>
                              <input type="password" name="repeat_new_password">
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="btn-container">
            <input name="submit" type="submit" class="inline-btn" value="Save Changes">
        </div>
    </form>
<?php include('footer.php');?>
