<?php
   @include 'config.php';
   include('common.php');
   if(isset($_POST['submit'])){
      $first_name_free = mysqli_real_escape_string($conn, $_POST['first_name']);
      $last_name_free = mysqli_real_escape_string($conn, $_POST['last_name']);
      $email_freelancer = mysqli_real_escape_string($conn, $_POST['email']);
      $password_freelancer = $_POST['password'];
      $cpassword_freelancer = $_POST['cpassword'];
      $profession = mysqli_real_escape_string($conn, $_POST['profession']);
      $hourly_rate = mysqli_real_escape_string($conn, $_POST['hourly_rate']);
      $select = "SELECT * FROM freelancer WHERE email_freelancer = '$email_freelancer' OR password_freelancer = '$password_freelancer'";
      $result = mysqli_query($conn, $select);
      if(mysqli_num_rows($result) > 0){
         $error[] = 'user already exist!';
      }else{
         if($password_freelancer != $cpassword_freelancer){
            $error[] = 'Password not matched!';
         }elseif(strlen($password_freelancer) < 8){
            $error[] = 'Password must be at least 8 characters long!';
         }else{
            $insert = "INSERT INTO freelancer(first_name_free, last_name_free, email_freelancer, password_freelancer, profession, hourly_rate) VALUES('$first_name_free','$last_name_free','$email_freelancer','$password_freelancer','$profession', '$hourly_rate')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
         }
      }
   };
?>
   <div class="form-container">
      <form action="" method="post">
         <h3>register now</h3>
         <?php
            if(isset($error)){
               foreach($error as $error){
                  echo '<span class="error-msg">'.$error.'</span>';
               };
            };
         ?>
         <div class="form-group">
            <input type="text" name="first_name" style="display: inline-block; width: 48%;" required placeholder="First name" autocomplete="off">
            <input type="text" name="last_name" style="display: inline-block; width: 48%; margin-left: 10px;" required placeholder="Last name" autocomplete="off">
         </div>
         <input type="email" name="email" required placeholder="Enter your email" autocomplete="off">
         <input type="password" name="password" required placeholder="Enter your password" autocomplete="off">
         <input type="password" name="cpassword" required placeholder="Confirm your password" autocomplete="off">
         <select name="profession" required>
            <option value="">Choose profession...</option>
            <option value="Developer">Developer</option>
            <option value="Designer">Designer</option>
            <option value="Other">Other</option>
         </select>          
         <input type="number" min="5" step="5" name="hourly_rate" required placeholder="Enter hourly rate ..." autocomplete="off">
         <input type="submit" name="submit" value="register now" class="form-btn">
         <p>Already have an account? <a href="login_form.php">Login now</a></p>
      </form>
   </div>