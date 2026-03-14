<?php
    session_start();
    @include '../login/config.php';
    include 'common.php';
    if(isset($_GET['delete_id'])) {

        $id = $_GET['delete_id'];

        $sql = "DELETE FROM reviews WHERE id_review = $id";
        $result = mysqli_query($conn, $sql);

        header('Location: reviews.php');
        exit();
    }
    $id_admin = $_SESSION['admin_id'];
    $sql="SELECT * FROM admin WHERE id_admin = '$id_admin'  ";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req);
?>
 <section>
            <table class="table table-hover text-center">
                <colgroup>
                    <col style="width: 5%">
                    <col style="width: 50%">
                    <col style="width: 10%">
                    <col style="width: 25%">
                    <col style="width: 10%">
                </colgroup>
                <thead style="background-color: #dadfe4;">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Description</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['search_box'])) {
                            $search_query = mysqli_real_escape_string($conn, $_GET['search_box']);
                            $sql1 = "SELECT * FROM reviews WHERE id_review LIKE '%$search_query%'";
                        } else {
                            $sql1 = "SELECT * FROM reviews";
                        }
                    
                        $result1 = mysqli_query($conn, $sql1);
                        while($row = mysqli_fetch_assoc($result1)){
                            ?>
                                <tr>
                                    <td><?php echo $row['id_review'] ?></td>
                                    <td><?php echo substr($row['description'], 0, 100) . '...' ?></td>
                                    <td><?php echo $row['rating'] ?></td>
                                    <td><?php echo $row['created__at'] ?></td>
                                    <td>
                                        <a href="edit-review.php?idad=<?php echo $row['id_review']; ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-2"></i></a>
                                        <a href="?delete_id=<?php echo $row['id_review']; ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                                    </td>
                                </tr>
                            <?php 
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</div>
<?php include 'footer.php'; ?>