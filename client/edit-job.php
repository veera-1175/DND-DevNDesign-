<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id_client = $_SESSION['client_id'];
    $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
    // Check if the job ID is set
    if(isset($_GET['id_job'])) {
        // Retrieve the job details from the database
        $job_id = $_GET['id_job'];
        $query = "SELECT * FROM jobs WHERE id_job = $job_id";
        $result = mysqli_query($conn, $query);
        $job = mysqli_fetch_assoc($result);
    }
    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Get the form data
        $title = $_POST['title'];
        $type = $_POST['type'];
        $category = $_POST['category'];
        $budget = $_POST['budget'];
        $description = $_POST['description'];
        $time = $_POST['time'];

        // Check if the job ID is set
        if(isset($_GET['id_job'])) {
            // Update the job in the database
            $job_id = $_GET['id_job'];
            $query = "UPDATE jobs SET title='$title', type='$type', category='$category', budget=$budget, description='$description', time=$time WHERE id_job=$job_id";
            mysqli_query($conn, $query);

            // Redirect to the my-jobs.php page
            header('Location: my-jobs.php');
            exit();
        }
    }
?>
    <section>
            <div class="modal-content">
                <h3 class="heading">Edit Your Job</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . http_build_query(array('id_job' => $job_id)); ?>" method="post">

                    <input type="text" name="title" required maxlength="50" placeholder="Enter title" class="booxx" autocomplete="off" value="<?php echo $job['title']; ?>">

                    <select required class="booxx" name="type" autocomplete="off">
                        <option value="">Select job type...</option>
                        <option value="Hourly project" <?php if($job['type'] == 'Hourly project') echo 'selected'; ?>>Hourly project</option>
                        <option value="Full-Time" <?php if($job['type'] == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                        <option value="Part-Time" <?php if($job['type'] == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                        <option value="Fixed-Price" <?php if($job['type'] == 'Fixed-Price') echo 'selected'; ?>>Fixed-Price</option>
                        <option value="Contract" <?php if($job['type'] == 'Contract') echo 'selected'; ?>>Contract</option>
                        <option value="Flexible" <?php if($job['type'] == 'Flexible') echo 'selected'; ?>>Flexible </option>
                        <option value="Other"  <?php if($job['type'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>

                    <select name="category" class="booxx" required autocomplete="off">
                        <option value="">Select job category...</option>
                        <option value="Web Development" <?php if($job['category'] == 'Web Development') echo 'selected'; ?>>Web Development</option>
                        <option value="Mobile Development" <?php if($job['category'] == 'Mobile Development') echo 'selected'; ?>>Mobile Development</option>
                        <option value="Graphic Design" <?php if($job['category'] == 'Graphic Design') echo 'selected'; ?>>Graphic Design</option>
                        <option value="Other" <?php if($job['category'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>

                    <input type="number" name="budget" required maxlength="50" placeholder="Enter Budget($)" class="booxx" min="0" step="1" autocomplete="off" value="<?php echo $job['budget']; ?>">

                    <textarea name="description" class="booxx" placeholder="Enter job description" maxlength="1000" cols="30" rows="10" autocomplete="off"><?php echo $job['description']; ?></textarea>
                    
                    <input type="number" name="time" required maxlength="50" placeholder="Delivery Time (days)" class="booxx" min="1" step="1" autocomplete="off" value="<?php echo $job['time']; ?>">
                    
                    <input type="submit" value="Update" name="submit" class="contact-form-btttn"style="margin-bottom: 10px;">
                    <input type="button" value="Close" class="contact-form-btttn" onclick="window.location.href='my-jobs.php';">
                    </form>
</div>
    </section>
<?php include('footer.php'); ?>
