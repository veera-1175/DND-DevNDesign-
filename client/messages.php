<?php
    session_start();
    include('common.php');
    $conn = mysqli_connect("localhost", "root", "", "dnd");

    $id = $_SESSION['client_id'];

    $sql="SELECT * FROM client WHERE id_client = '$id'";
    $req = mysqli_query($conn , $sql) ;
    $num_ligne = mysqli_fetch_assoc($req) ;

    // Get the ID of the freelancer that the client is chatting with
    $freelancer_id = $_GET['freelancer_id'];

    if ($freelancer_id) {
        // Get the name of the freelancer
        $sql3 = "SELECT * FROM freelancer WHERE id_freelancer = '$freelancer_id'";
        $result_name = mysqli_query($conn, $sql3);
        $row_name = mysqli_fetch_assoc($result_name);
        $freelancer_name = $row_name['first_name_free'] . ' ' . $row_name['last_name_free'];
        
        // Get the messages between the client and freelancer
        $id_freelancer = $freelancer_id;

        $sql = "SELECT * FROM messages WHERE id_freelancer = '$freelancer_id' AND id_client = '$id' order by id_message ";
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
                                echo '<img class="cover" src="../freelancer/photofreelancer/default.jpg">' ;
                                } 
                                else{
                                    $ex=$row_name['exentation'];
                                    $namf=$freelancer_id.'.'.$ex;
                                    echo ' <img class="cover" src="../freelancer/photofreelancer/'.$namf.'">';
                                }
                            ?>
                        </div>
                        <h4><?php echo $freelancer_name; ?><br></h4>
                    </div>
                    <div class="logo-profile">
                        <a href="freelancer-profile.php?idfree=<?php echo $freelancer_id; ?>">
                            <button class="bbbtt" type="submit">
                                <i class="fa-solid fa-user"></i>
                            </button>
                            
                        </a>
                    </div>
                </div>
    
                <!-- CHAT-BOX -->
                <div class="chatbox">
                    <?php if ($result != null) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="message <?php echo $row['id_sender'] == $_SESSION['client_id'] ? 'my_msg' : 'friend_msg'; ?>">
                                <p>
                                    <?php echo $row['message_fc']; ?>
                                    <br><span><?php echo ltrim(date('H:i', strtotime($row['time_sent_message'])), '0'); ?></span>
                                </p>
                            </div>
                        <?php }
                    } ?>
                </div>                
                
                <!-- CHAT INPUT -->
                <form method="post" action="insert_messages_cli.php?freelancer_id=<?php echo $id_freelancer; ?>">
                    <div class="chat_input">
                        <input type="text" name="message_fc" placeholder="Type a message" required autocomplete="off">
                        <button type="submit" name="send_message"><i class="fas fa-duotone fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php include('footer.php');?>
