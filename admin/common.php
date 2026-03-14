<?php
   $conn = mysqli_connect("localhost", "root", "", "dnd");
   $id=$_SESSION['admin_id'];
   $sql="SELECT * FROM admin WHERE id_admin = '$id'  ";
   $req = mysqli_query($conn , $sql) ;
   $num_ligne = mysqli_fetch_assoc($req) ;
   $current_page = basename($_SERVER['PHP_SELF'], ".php");
   $current_page_link = $current_page . ".php";
?>

<html>
  <head>
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="stylesheet" href="../CSS/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
</head>
<body>
<header class="header">
         <section class="flex">
         <a href="<?php echo $current_page_link; ?>" class="logo"><?php echo ucfirst($current_page); ?></a>
         <?php
         $show_search_pages = ['clients', 'freelancers', 'admins', 'jobs', 'requests', 'reviews', 'contact-us'];
         if (in_array($current_page, $show_search_pages)) {
         ?>
   <form action="#" method="get">
      <input type="text" name="search_box" placeholder="Search..." autocomplete="off"style="border: 2px solid #8e44ad">
      <button type="submit" class="fa-solid fa-magnifying-glass icon" style="border: none; background: transparent;margin-left: 10px; font-size: 20px;color: #530475"></button>
   </form>
   <?php } ?>
            <div class="icons">
               <div id="user-btn" class="fas fa-user"></div>
            </div>
            <div class="profile" id="dropdown-profile">
            <?php
                            if($num_ligne['statut']==0)  {
                                echo '<img class="image" src="photoadmin/default.jpg">' ;
                            }
                            else{
                                $ex=$num_ligne['exentation'];
                                $namf=$id.'.'.$ex;
                                echo ' <img class="image" src="photoadmin/'.$namf.'">';
                            }
                    ?>
            <h3 class="name"><?php echo substr($_SESSION['admin_name'] ?? 'Admin', 0, 18); ?></h3>
            <p class="role">Admin</p>
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

      <div class="side-bar">
      <div class="profile">
        <img src="img/logo.png" class="image" alt="">
    </div>
      <nav class="navbar">
        <ul>
            <li>
               <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
               </li><li>
               <a href="freelancers.php"><i class="fas fa-users"></i><span>Freelancers</span></a>
               </li><li>
               <a href="clients.php"><i class="fas fa-light fa-users-rectangle"></i><span>Clients</span></a>
               </li><li>
               <a href="admins.php"><i class="fa-solid fa-users-gear"></i><span>Admins</span></a>
               </li><li>
               <a href="jobs.php"><i class="fas fa-table-list"></i><span>Jobs</span></a>
               </li><li>
               <a href="requests.php"><i class="fas fa-question"></i><span>Requests</span></a>
               </li><li>
               <a href="reviews.php"><i class="far fa-thumbs-up"></i><span>Reviews</span></a>
               </li><li>
               <a href="contact-us.php"><i class="fas fa-envelope"></i><span>Contact</span></a>
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
