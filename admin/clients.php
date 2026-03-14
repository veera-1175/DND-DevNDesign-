<?php
    session_start();
    include 'common.php';
    @include '../login/config.php';

    if(isset($_GET['delete_id'])) {

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM client WHERE id_client = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: clients.php');
        exit();
    }

    $id_admin = $_SESSION['admin_id'];

    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>
<section>
            <table class="table table-hover text-center" style="margin-left: 15px; table-layout: fixed;">
                <colgroup>
                    <col style="width: 5%">
                    <col style="width: 18%">
                    <col style="width: 18%">
                    <col style="width: 35%">
                    <col style="width: 20%">
                    <col style="width: 10%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM client WHERE CONCAT(first_name_cli, ' ', last_name_cli) LIKE '%$search_query%' OR id_client LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM client";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_client'] ?></td>
                                    <td><?php echo $row['first_name_cli'] ?></td>
                                    <td><?php echo $row['last_name_cli'] ?></td>
                                    <td><?php echo $row['email_client'] ?></td>
                                    <td><?php echo substr($row['password_client'], 0, 13) . '...' ?></td>
                                    <td>
                                        <a href="edit-client.php?idad=<?php echo $row['id_client']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_client']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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
    