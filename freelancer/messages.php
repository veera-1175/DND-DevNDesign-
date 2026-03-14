<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");
    $id = $_SESSION['freelancer_id'];
    $sql="SELECT * FROM freelancer WHERE id_freelancer = '$id'";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;
    $client_id = $_GET['client_id'];
    if ($client_id) {
        $sql3 = "SELECT * FROM client WHERE id_client = '$client_id'";
        $result_name = mysqli_query($conn, $sql3);
        $row_name = mysqli_fetch_assoc($result_name);
        $client_name = $row_name['first_name_cli'] . ' ' . $row_name['last_name_cli'];
        $id_client = $client_id;
        $sql = "SELECT * FROM messages WHERE id_client = '$client_id' AND id_freelancer = '$id' order by id_message ";
        $result = mysqli_query($conn, $sql);
    }
?>
    <section>
        <div class="container-mess" style="border: 2px solid white;">
            <div class="rightSide">
                <div class="headerr">
                    <div class="imgText">
                        <div class="userimg">
                            <?php
                                if($row_name['statut']==0)  {
                                echo '<img class="cover" src="../client/photoclient/default.jpg">' ;
                                }
                                else{
                                    $ex=$row_name['exentation'];
                                    $namf=$client_id.'.'.$ex;
                                    echo ' <img class="cover" src="../client/photoclient/'.$namf.'">';
                                }
                            ?>
                        </div>
                        <h4><?php echo $client_name; ?><br></h4>
                    </div>
                    <div class="logo-profile">
                    <a href="client-profile.php?id_cli=<?php echo $client_id; ?>">
                            <button class="bbbtt" type="submit">
                                <i class="fa-solid fa-user"></i>
                            </button>

                        </a>
                    </div>
                </div>
                <div class="chatbox">
                    <?php if ($result != null) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="message <?php echo $row['id_sender'] == $_SESSION['freelancer_id'] ? 'my_msg' : 'friend_msg'; ?>">
                                <p>
                                    <?php echo $row['message_fc']; ?>
                                    <br><span><?php echo ltrim(date('H:i', strtotime($row['time_sent_message'])), '0'); ?></span>
                                </p>
                            </div>
                        <?php }
                    } ?>
                </div>

                <form method="post" action="insert_messages_free.php?client_id=<?php echo $id_client; ?>">
                    <div class="chat_input">
                        <input type="text" name="message_fc" placeholder="Type a message" required autocomplete="off">
                        <button type="submit" name="send_message"><i class="fas fa-duotone fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
