<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id_client = $_SESSION['client_id'];
    $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;

    if(isset($_GET['delete_id'])) {
        $conn = mysqli_connect('localhost','root','','dnd');

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM jobs WHERE id_job = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: my-jobs.php');
        exit();
    }

    // Process job status update form if submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']) && isset($_POST['job_id'])) {
        $status_input = $_POST['status'];
        $job_id_input = $_POST['job_id'];
        $job_status_update = '';

        // Convert display status to database status
        if ($status_input == 'Public') {
            $job_status_update = 'public';
        } elseif ($status_input == 'Private') {
            $job_status_update = 'private';
        } elseif ($status_input == 'Completed') {
            $job_status_update = 'completed';
        }

        if (!empty($job_status_update)) {
            $update_query = "UPDATE jobs SET job_status='$job_status_update' WHERE id_job='$job_id_input'";
            if (mysqli_query($conn, $update_query)) {
                $_SESSION['status_message'] = "Job status updated successfully.";
                $_SESSION['status_type'] = 'success';
            } else {
                $_SESSION['status_message'] = "Error updating job status.";
                $_SESSION['status_type'] = 'error';
            }
        }
        header('Location: my-jobs.php'); // Redirect to refresh the page and show message
        exit();
    }


    $query = "SELECT suivi_job.id_job, suivi_job.status FROM suivi_job WHERE suivi_job.id_client = '$id_client'";

    $results = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($results)) {
        // Update job_status based on the status in suivi_job
        switch ($row['status']) {
            case 'pending':
                $job_status = 'public';
                break;
            case 'accepted':
                $job_status = 'private';
                break;
            case 'rejected':
                $job_status = 'public';
                break;
            case 'completed':
                $job_status = 'completed';
                break;
            default:
                $job_status = null;
        }

        if (!is_null($job_status)) {
            $job_id = $row['id_job'];
            $update_query = "UPDATE jobs SET job_status='$job_status' WHERE id_job='$job_id'";
            mysqli_query($conn, $update_query);
        }
    }

    mysqli_close($conn);
?>
    <section>
        <div class="jobs">
            <div class="job-container">
                <?php
                    // Display status message if set
                    if (isset($_SESSION['status_message'])) {
                        $message_class = ($_SESSION['status_type'] == 'success') ? 'success-message' : 'error-message';
                        echo '<div class="' . $message_class . '">' . $_SESSION['status_message'] . '</div>';
                        unset($_SESSION['status_message']); // Clear message after displaying
                        unset($_SESSION['status_type']);
                    }
                ?>
                <?php
                // Retrieve jobs again after updating the job status in jobs table
                $conn = mysqli_connect("localhost", "root", "", "dnd");
                $query = "SELECT * FROM jobs WHERE id_client = '$id_client'";
                $results = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($results)) { ?>
                    <div class="boox jb">
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <div class="box">
                            <p><span class="category-label">Type :</span> <?php echo $row['type']; ?><span class="category-label" style="margin-left: 233px;">Category :</span> <?php echo $row['category']; ?></p>
                            <p><span class="category-label">Budget :</span> <?php echo $row['budget']; ?>₹<span class="category-label" style="margin-left: 253px;">Delivery Time :</span> <?php echo $row['time']; ?> days</p>
                        </div>

                        <form method="POST" class="job-status-form">
                            <input type="text" name="status" class="job-status-input" value="<?php
                                switch ($row['job_status']) {
                                    case 'private':
                                        echo 'Private';
                                        break;
                                    case 'completed':
                                        echo 'Completed';
                                        break;
                                    default:
                                    echo 'Public';
                                }
                            ?>" readonly>
                            <input type="hidden" name="job_id" value="<?php echo $row['id_job']; ?>">
                        </form>

                        <?php if ($row['job_status'] == 'private' || $row['job_status'] == 'completed') {
                            if ($row['job_status'] == 'private') {
                                $alert_message = 'Sorry, this job is currently in progress and cannot be edited or deleted at this time.';
                            } else {
                                $alert_message = 'Sorry, this job has already been completed and cannot be edited or deleted.';
                            }
                        ?>
                            <button class="inline-btnn mr-2 disabled" style="background-color: #dcdcdc; cursor: pointer;" onclick="alert('<?php echo $alert_message; ?>')"><i class="fa-sharp fa-solid fa-pen-to-square"></i></button>
                            <button class="inline-btnn disabled" style="background-color: #dcdcdc; cursor: pointer;" onclick="alert('<?php echo $alert_message; ?>')"><i class="fa-solid fa-xmark"></i></button>
                        <?php } else { ?>
                            <a href="edit-job.php?id_job=<?php echo $row['id_job']; ?>" class="inline-btnn mr-2" ><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                            <a href="?delete_id=<?php echo $row['id_job']; ?>" class="inline-btnn"><i class="fa-solid fa-xmark"></i></a>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php include('footer.php');?>
<