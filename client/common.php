<?php
   $conn = mysqli_connect("localhost", "root", "", "dnd");
   $id=$_SESSION['client_id'];
   $sql="SELECT * FROM client WHERE id_client = '$id'  ";
   $req = mysqli_query($conn , $sql) ;
   $num_ligne = mysqli_fetch_assoc($req) ;
   $current_page = basename($_SERVER['PHP_SELF'], ".php");
   $current_page_link = $current_page . ".php";
?>
<html>
<head>
   <title>Home</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <link rel="stylesheet" href="CSS/style.css">
   <link rel="stylesheet" href="../CSS/main.css">
</head>
<body>
<header class="header">
      <section class="flex">
      <a href="<?php echo $current_page_link; ?>" class="logo"><?php echo ucfirst($current_page); ?></a>
         <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="profile" id="dropdown-profile">
            <?php   
               if($num_ligne['statut']==0)  {
               echo '<img class="image" src="photoclient/default.jpg">' ;
               } 
               else{
                  $ex=$num_ligne['exentation'];
                  $namf=$id.'.'.$ex;
                  echo ' <img class="image" src="photoclient/'.$namf.'">';
               }
            ?>
            <h3 class="name"><?php echo substr($_SESSION['client_name'] ?? $_SESSION['freelancer_name'], 0, 18); ?></h3>
            <p class="role">Client</p>
            <hr>
            <a href="profile.php" class="sub-menu-link">
               <i class="fa-solid fa-user"></i>
               <p>View Profile</p>
               <span>></span>
            </a>

            <a href="../login/logout.php" class="sub-menu-link">
               <i class="fas fa-sign-out-alt"></i>
               <p style="margin-right: 30px;">Log out</p>
               <span>></span>
            </a>
         </div>
      </section>
   </header>
   
<!-- Sidebar section -->
<div class="side-bar">
    <div class="profile">
        <img src="img/logo.png" class="image" alt="">
    </div>

    <nav class="navbar">
        <ul>
            <li>
                <a href="home.php">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>

            <li>
                <a href="post-a-job.php">
                    <i class="fa-sharp fas fa-upload"></i>
                    <span>Post a Job</span>
                </a>
            </li>

            <li>
                <a href="my-jobs.php">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Jobs</span>
                </a>
            </li>

            <li>
                <a href="freelancers.php">
                    <i class="fas fa-users"></i>
                    <span>Freelancers</span>
                </a>
            </li>
            <li>
               <a href="Inbox.php">
                  <i class="fas fa-comments"></i>
                  <span>Messages</span>
               </a>
            </li>
            <li>
                <a href="all-requests.php">
                    <i class="fa-sharp fa-solid fa-file-circle-check"></i>
                    <span>Job Requests</span>
                </a>
            </li>

            <li>
                <a href="help.php">
                    <i class="fas fa-headset"></i>
                    <span>Help</span>
                </a>
            </li>
            <li>
               <a href="../login/logout.php" class="logout">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Log out</span>
               </a>
            </li>
        </ul>
    </nav>
</div>
<script >let profile = document.querySelector('.header .flex .profile');
let userBtn = document.querySelector('#user-btn');

// Add click event listener to document object
document.addEventListener('click', function(event) {
  // Check if clicked element is inside the profile element
  if (!profile.contains(event.target) && event.target != userBtn) {
    profile.classList.remove('active');
  }
});

// Add click event listener to userBtn element
userBtn.onclick = () =>{
   profile.classList.toggle('active');
}
</script>
</body>
</html>
