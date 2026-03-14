<?php
    session_start();
    include 'common.php';
    @include '../login/config.php';
    if(isset($_GET['delete_id'])) {

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM jobs WHERE id_job = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: jobs.php');
        exit();
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?> <section>
            <table class="table table-hover text-center" >
                <colgroup>
                    <col style="width: 3%">
                    <col style="width: 10%">
                    <col style="width: 9%">
                    <col style="width: 10%">
                    <col style="width: 5%">
                    <col style="width: 15%">
                    <col style="width: 7%">
                    <col style="width: 8%">
                    <col style="width: 5%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Category</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Description</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM jobs WHERE title LIKE '%$search_query%' OR id_job LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM jobs";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_job'] ?></td>
                                    <td><?php echo substr($row['title'], 0, 22) . '...' ?></td>
                                    <td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['budget'] ?>$</td>
                                    <td><?php echo substr($row['description'], 0, 15) . '...' ?></td>
                                    <td><?php echo $row['time'] ?> days</td>
                                    <td><?php echo $row['job_status'] ?></td>
                                    <td>
                                        <a href="edit-job.php?idad=<?php echo $row['id_job']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_job']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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