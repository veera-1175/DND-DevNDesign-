<?php
    session_start();
    @include '../login/config.php';
    include('common.php');
    $id_freelancer = $_SESSION['freelancer_id'];
    $sql="SELECT * FROM freelancer WHERE id_freelancer = '$id_freelancer'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $first_name = $_POST['first_name_contact'] ?? '';
        $last_name = $_POST['last_name_contact'] ?? '';
        $email = $_POST['email_contact'] ?? '';
        $subject = $_POST['subject_contact'] ?? '';
        $message = mysqli_real_escape_string($conn, $_POST['message_contact'] ?? '');
          
        $sql = "INSERT INTO contact_us (idsend, first_name_contact, last_name_contact, email_contact, subject_contact, message_contact) VALUES ('$id_client', '$first_name', '$last_name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $sql)) {
            // inserted successfully
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>

    <section>
        <div class="headline">
            <h3><i class="fa-solid fa-envelope"></i> Contact Us</h3>
        </div>
        
        <section class="contact section" id="contact">
            <div class="contact__section">
                <form class="contact__form" action="" method="post" autocomplete="off">
                    <input type="text" name="first_name_contact" class="contact-form-text" style="display: inline-block; width: 48%;" required placeholder="First name">
                    <input type="text" name="last_name_contact" class="contact-form-text" style="display: inline-block; width: 48%; margin-left: 20px;" required placeholder="Last name">
                    <input type="email" name="email_contact" class="contact-form-text" required placeholder="Your email">
                    <input type="text" name="subject_contact" class="contact-form-text" required placeholder="Message Subject...">
                    <textarea name="message_contact" class="contact-form-text" required placeholder="Drop your message here..."></textarea>
                    <input type="submit" class="contact-form-btn" value="Send">
                </form>
            </div>
        </section>
    </section>
<?php include('footer.php');?>
