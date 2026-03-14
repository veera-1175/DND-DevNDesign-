<?php
    session_start();
    @include '../login/config.php';
    include 'common.php';
    $id = $_GET['idad'];
    if(isset($_POST['submit'])) {
        $message_job = $_POST['message_job'];
        $status = $_POST['status'];
        $time_sent = $_POST['time_sent'];
        $time_accepted = $_POST['time_accepted'];
        $time_completed = $_POST['time_completed'];

        if ($status === 'pending') {
            $time_completed = '0000-00-00 00:00:00';
            $time_accepted = '0000-00-00 00:00:00';
        }
    
        if ($status === 'accepted') {
            $time_accepted = date('Y-m-d H:i:s');
            $time_completed = '0000-00-00 00:00:00';
        }

        if ($status === 'completed') {
            $time_accepted = date('Y-m-d H:i:s');
            $time_completed = date('Y-m-d H:i:s');
        }

        $sql = "UPDATE suivi_job SET message_job='$message_job', status='$status', time_sent='$time_sent', time_accepted='$time_accepted', time_completed='$time_completed' WHERE id_request = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: requests.php");
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
    $sql = "SELECT * FROM suivi_job WHERE id_request = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>

<div class="form-container">
    <h1>Edit Request</h1>
    <form method="post">
        <div class="form-group">
            <label for="message_job">Request Description:</label>
            <textarea name="message_job" id="message_job" rows="3"><?php echo $row['message_job']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Request Status:</label>
            <select name="status" id="status">
                <option value="" selected>Select request status...</option>
                <option value="pending" <?php if($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="accepted" <?php if($row['status'] == 'accepted') echo 'selected'; ?>>Accepted</option>
                <option value="rejected" <?php if($row['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                <option value="completed" <?php if($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="time_sent">Time Sent:</label>
                <input type="datetime-local" name="time_sent" id="time_sent" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['time_sent'])); ?>">
            </div>
            <div class="form-group">
                <label for="time_accepted">Time Accepted:</label>
                <input type="datetime-local" name="time_accepted" id="time_accepted" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['time_accepted'])); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="time_completed">Time Completed:</label>
            <input type="datetime-local" name="time_completed" id="time_completed" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['time_completed'])); ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn" name="submit">Update</button>
            <button type="button" class="btn" onclick="window.location.href='requests.php'">Close</button>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>