<?php
    session_start();
    include 'common.php';
    @include '../login/config.php';
    if(isset($_GET['delete_id'])) {

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM contact_us WHERE id_contact = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: inbox.php');
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
                    <col style="width: 10%">
                    <col style="width: 10%">
                    <col style="width: 20%">
                    <col style="width: 12%">
                    <col style="width: 20%">
                    <col style="width: 10%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Message</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM contact_us WHERE CONCAT(first_name_contact, ' ', last_name_contact) LIKE '%$search_query%' OR id_contact  LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM contact_us";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_contact'] ?></td>
                                    <td><?php echo $row['first_name_contact'] ?></td>
                                    <td><?php echo $row['last_name_contact'] ?></td>
                                    <td><?php echo strlen($row['email_contact']) < 25 ? $row['email_contact'] : substr($row['email_contact'], 0, 25) . '...' ?></td>
                                    <td><?php echo $row['subject_contact'] ?></td>
                                    <td><?php echo strlen($row['message_contact']) < 80 ? $row['message_contact'] : substr($row['message_contact'], 0, 80) . '...' ?></td>
                                    <td>
                                        <a href="edit-contact.php?idad=<?php echo $row['id_contact']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_contact']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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
