<?php include('common.php'); ?>
   <div class="form-container">
      <form action="" method="post">
         <h3>Join As</h3>
         <select name="user_type" onchange="location = this.value;">
            <option value="">Select user type...</option>
            <option value="register_form_freelancer.php">Freelancer</option>
            <option value="register_form_client.php">Client</option>
         </select>
      </form>
   </div>