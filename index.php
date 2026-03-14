<?php
    $conn = mysqli_connect('localhost','root','','dnd');
    $sql_freelancers = "SELECT count(*) from freelancer";
    $result_freelancers = mysqli_query($conn, $sql_freelancers);
    if (!$result_freelancers) {
        die("Error: " . mysqli_error($conn));
    }
    $row_freelancers = mysqli_fetch_array($result_freelancers);
    $freelancers_count = implode(',', $row_freelancers);
    $sql_clients = "SELECT count(*) from client";
    $result_clients = mysqli_query($conn, $sql_clients);
    if (!$result_clients) {
        die("Error: " . mysqli_error($conn));
    }
    $row_clients = mysqli_fetch_array($result_clients);
    $clients_count = implode(',', $row_clients);
    $sql_jobs = "SELECT count(*) from jobs";
    $result_jobs = mysqli_query($conn, $sql_jobs);
    if (!$result_jobs) {
        die("Error: " . mysqli_error($conn));
    }
    $row_jobs = mysqli_fetch_array($result_jobs);
    $jobs_count = implode(',', $row_jobs);
?>
<html>
<head>
<link rel="stylesheet" href="CSS/style.css">
<title>DND</title>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="index.php" class="nav__logo">
                <img src="img/freelancelogo.png" alt="logo">
            </a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="#join" class="nav__link">Join Us</a>
                    </li>
                    
                    <div class="nav__link">
                        <a href="login/login_form.php" class="button nav__button" style="padding: 8px 12px; font-size: 15px;">Log In</a>
                    </div>

                    <div class="nav__link">
                        <a href="login/join_as.php" class="button nav__button" style="padding: 8px 12px; font-size: 15px;">Register Now</a>
                    </div>
                </ul>
            </div>
        </nav>
    </header>
    <main class="main">
<center>
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h2 class="home__subtitle">HIRE/BE THE BEST </h2>
                    <h1 class="home__title">FREELANCERS</h1>
                    <p class="home__description">BROWSE TALENT BY CATEGORY AND FIND GREAT WORK</p>
                    <a href="login/join_as.php" class="button button__flex" style="border-radius: 12px;">Let's Start --></a>
                </div>
                <div class="home__images">
                    <img src="img/programming.png" alt="home image" class="home__img">
                </div>
            </div>
        </section>     
</center>         
        <section class="join section" id="join">
            <div class="container">
                <div class="section__data">
                    <h2 class="section__subtitle">Join Us right now !</h2>
                    <div class="section__titles">
                        <h1 class="section__title-border">Go wherever your</h1>
                        <h1 class="section__title">Imagination takes you.</h1>
                    </div>
                </div>
                <div class="join__container grid">
                    <article class="join__card">
                        <div class="join__shape">
                            <a href="login/register_form_freelancer.php">
                            <img src="img/Freelancer.png" alt="join image" class="join__img"> </a>
                        </div>
                        <h3 class="join__title">Freelancer</h3>
                        <p class="join__description">
                            Register & Find a job
                        </p>
                    </article>
                    <article class="join__card">
                        <div class="join__shape">
                        <a href="login/register_form_client.php">
                            <img src="img/client.png" alt="join image" class="join__img"></a>
                        </div>
                        <h3 class="join__title">Client</h3>
                        <p class="join__description">
                            Register & Hire a freelancer
                        </p>
                    </article>
                </div>
            </div>
            <br>
        </section>
    </main>
    <footer class="footer section" id="footer">        
        <div class="footer-copy">
            <br><br><br><br>
            <p>&#169; Copyright <span>lancer</span>. All rights reserved</p>
        </div>
    </footer>
</body>
</html>