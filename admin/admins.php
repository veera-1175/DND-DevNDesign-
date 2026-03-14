<?php
session_start();
include 'common.php';
include '../login/config.php';
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM admin WHERE id_admin = $id";
    $result = mysqli_query($conn, $sql);
    header('Location: admins.php');
    exit();
}
$id_admin = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
$req = mysqli_query($conn, $sql);
$num_ligne = mysqli_fetch_assoc($req);
?>
<center><button type="button" class="btn1" onclick="window.location.href='add-admin.php'">Add New Admin</button></center>
<section>
    <table class="table table-hover text-center">
        <colgroup>
            <col style="width: 5%">
            <col style="width: 18%">
            <col style="width: 18%">
            <col style="width: 25%">
            <col style="width: 20%">
            <col style="width: 20%">
        </colgroup>
        <thead style="background-color: #dadfe4;">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['search_box'])) {
                $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                $sql1 = "SELECT * FROM admin WHERE CONCAT(first_name_admin, ' ', last_name_admin) LIKE '%$search_query%' OR id_admin LIKE '%$search_query%'";
            } else {
                $sql1 = "SELECT * FROM admin";
            }

            $result1 = mysqli_query($conn, $sql1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><?php echo $row['id_admin']; ?></td>
                    <td><?php echo $row['first_name_admin']; ?></td>
                    <td><?php echo $row['last_name_admin']; ?></td>
                    <td><?php echo $row['email_admin']; ?></td>
                    <td><?php echo $row['password_admin']; ?></td>
                    <td>
                        <a href="edit-admin.php?idad=<?php echo $row['id_admin']; ?>" ><i class="fa-solid fa-pen-to-square fs-5 me-3 icon-black""></i></a>
                        <a href="?delete_id=<?php echo $row['id_admin']; ?>" ><i class="fa-solid fa-trash fs-5 icon-black""></i></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
<?php include 'footer.php'; ?>