<?php
    session_start();
    include 'common.php';
    @include '../login/config.php';
    if(isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];
        $sql = "DELETE FROM freelancer WHERE id_freelancer = $id";
        $result = mysqli_query($conn, $sql);
        header('Location: freelancers.php');
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
                    <col style="width: 3%">
                    <col style="width: 8%">
                    <col style="width: 8%">
                    <col style="width: 17%">
                    <col style="width: 7%">
                    <col style="width: 12%">
                    <col style="width: 7%">
                    <col style="width: 5%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Profession</th>
                        <th scope="col">Hourly rate</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM freelancer WHERE CONCAT(first_name_free, ' ', last_name_free) LIKE '%$search_query%' OR id_freelancer LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM freelancer";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_freelancer'] ?></td>
                                    <td><?php echo $row['first_name_free'] ?></td>
                                    <td><?php echo $row['last_name_free'] ?></td>
                                    <td><?php echo $row['email_freelancer'] ?></td>
                                    <td><?php echo substr($row['password_freelancer'], 0, 10) . '...' ?></td>
                                    <td><?php echo $row['profession'] ?></td>
                                    <td><?php echo $row['hourly_rate'] ?>₹</td>
                                    <td>
                                        <a href="edit-freelancer.php?idad=<?php echo $row['id_freelancer']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_freelancer']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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