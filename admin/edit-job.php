<?php
    session_start();
    @include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    if(isset($_POST['submit'])) {
        $title = $_POST['title'];
        $type = $_POST['type'];
        $category = $_POST['category'];
        $budget = $_POST['budget'];
        $time = $_POST['time'];
        $description = $_POST['description'];
        $job_status = $_POST['job_status'];
        $sql = "UPDATE jobs SET title='$title', type='$type', category='$category', budget='$budget',
                time='$time', description='$description', job_status='$job_status'
                WHERE id_job = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: jobs.php");
        }else{
            echo "Failed: " . mysqli_error($conn);
        }
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>
<?php
    $sql = "SELECT * FROM jobs WHERE id_job = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>

<div class="form-container">
    <h1>Edit Job Information</h1>
    <form method="post">
        <div class="form-group">
            <label>Job Title:</label>
            <textarea name="title" rows="3"><?php echo $row['title']; ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Job Type:</label>
                <select name="type">
                    <option value="">Select job type...</option>
                    <option value="Hourly project" <?php if ($row['type'] == 'Hourly project') echo 'selected'; ?>>Hourly project</option>
                    <option value="Full-Time" <?php if ($row['type'] == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                    <option value="Part-Time" <?php if ($row['type'] == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                    <option value="Fixed-Price" <?php if ($row['type'] == 'Fixed-Price') echo 'selected'; ?>>Fixed-Price</option>
                    <option value="Contract" <?php if ($row['type'] == 'Contract') echo 'selected'; ?>>Contract</option>
                    <option value="Flexible" <?php if ($row['type'] == 'Flexible') echo 'selected'; ?>>Flexible</option>
                    <option value="Other" <?php if ($row['type'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Job Category:</label>
                <select name="category">
                    <option value="">Select job category...</option>
                    <option value="Web Development" <?php if ($row['category'] == 'Web Development') echo 'selected'; ?>>Web Development</option>
                    <option value="Mobile Development" <?php if ($row['category'] == 'Mobile Development') echo 'selected'; ?>>Mobile Development</option>
                    <option value="Graphic Design" <?php if ($row['category'] == 'Graphic Design') echo 'selected'; ?>>Graphic Design</option>
                    <option value="Other" <?php if ($row['category'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Budget:</label>
                <input type="number" name="budget" min="0" value="<?php echo $row['budget']; ?>">
            </div>
            <div class="form-group">
                <label>Time (in days):</label>
                <input type="number" name="time" min="0" value="<?php echo $row['time']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Job Description:</label>
            <textarea name="description" rows="3"><?php echo $row['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Job Status:</label>
            <select name="job_status">
                <option value="">Select job status...</option>
                <option value="public" <?php if ($row['job_status'] == 'public') echo 'selected'; ?>>Public</option>
                <option value="private" <?php if ($row['job_status'] == 'private') echo 'selected'; ?>>Private</option>
                <option value="completed" <?php if ($row['job_status'] == 'completed') echo 'selected'; ?>>Completed</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn" name="submit">Update</button>
            <button type="button" class="btn" onclick="window.location.href='jobs.php'">Close</button>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>