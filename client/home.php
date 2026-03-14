<?php
   session_start();
   include('common.php');
   $conn = mysqli_connect("localhost", "root", "", "dnd");
?>
   <section>
      <div class="welcome-areaa">
         <div class="containerr">
            <div class="left-wel">
               <div class="big-titlee">
                  <h1>Hire experts freelancers</h1>
                  <h1>for any job,</h1>
                  <h1>any time.</h1>
               </div>
               <p class="textt">
                  Huge community of designers, developers and creatives ready for your project.
               </p>
               <div class="cta">
                  <a href="post-a-job.php" class="bttn">Post a Job</a>
               </div>
            </div>

            <div class="right-wel">
               <img src="img/person.png" alt="Person Image" class="personn" />
            </div>
         </div>
      </div>
   </section>
   <?php include('footer.php'); ?>