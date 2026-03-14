<?php
session_start();
include 'common.php';
include 'config.php';    
?>
      <section class="home-grid">
         <div class="box-container">
               <div class="imagee">
                  <img src="img/PngItem_1246919.png" alt="">
               </div>
         </div>
         <div class="box">
                  <h2 class="title">Hello back !</h2>
                  <p class="tutor">It is time to be productive ! using your time and resources wisely, you can unlock your full potential. </p>
               </div>
      </section>
      <section >
        <h2><i class="fas fa-quote-left	"></i> Some of the categories</h2>
        <hr><br>
        <div class="categoryy">
          <div class="itemm">
            <img src="img/originals/Untitled-1.jpg" alt="Item 1">
            <h3>Designer</h3>
            <p>A designer is a professional who uses creativity and technical skills to create visual or functional designs, such as graphics, logos, websites, or products.</p>
          </div>
          <div class="itemm">
            <img src="img/originals/Untitled-6.jpg" alt="Item 6">
            <h3>Developer</h3>
            <p>A developer creates software applications using programming languages and tools.</p>
          </div>
        </div>
        <div class="box" style="   text-align: center;" >
            <a href="job-list.php" class="inline-btn">Check on more !</a>
         </div>
      </section>
<?php include 'footer.php'; ?>


