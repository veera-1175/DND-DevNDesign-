<?php
    session_start();

    @include '../login/config.php';
    include 'common.php';
    if(isset($_GET['delete_id'])) {

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM suivi_job WHERE id_request = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: requests.php');
        exit();
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>

        <section>
            <table class="table table-hover text-center" >
                <colgroup>
                    <col style="width: 5%">
                    <col style="width: 20%">
                    <col style="width: 18%">
                    <col style="width: 15%">
                    <col style="width: 15%">
                    <col style="width: 15%">
                    <col style="width: 10%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Message</th>
                        <th scope="col">Status</th>
                        <th scope="col">Time sent</th>
                        <th scope="col">Time accepted</th>
                        <th scope="col">Time completed</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM suivi_job WHERE  id_request LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM suivi_job";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_request'] ?></td>
                                    <td><?php echo substr($row['message_job'], 0, 100) . '...' ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td><?php echo $row['time_sent'] ?></td>
                                    <td><?php echo $row['time_accepted'] ?></td>
                                    <td><?php echo $row['time_completed'] ?></td>
                                    <td>
                                        <a href="edit-request.php?idad=<?php echo $row['id_request']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_request']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                                    </td>
                                </tr>
                            <?php 
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
<?php include 'footer.php'; ?>