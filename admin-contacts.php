<?php

include "config.php";

/*Database Connection*/
$host = "localhost";
$dbname = "bookstore_db";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

session_start();

$admin_ID = $_SESSION['admin_UID'];

if(!isset($admin_ID)){
    header('location:login-reg.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $sql2 = "DELETE FROM message WHERE MID= '$delete_id'";
    mysqli_query($conn, $sql2) or die('query failed');
    header('location:admin-contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyBooks - Messages</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="admin-home.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">

    <h1 class="title"> messages </h1>

    <div class="box-container">
        <?php
        $sql = "SELECT * FROM message";
        $select_message = mysqli_query($conn, $sql) or die('query failed');
        if(mysqli_num_rows($select_message) > 0){
            while($fetch_message = mysqli_fetch_assoc($select_message)){

                ?>
                <div class="box">
                    <p> UserID : <span><?php echo $fetch_message['UID']; ?></span> </p>
                    <p> Name : <span><?php echo $fetch_message['Name']; ?></span> </p>
                    <p> Phone Number : <span><?php echo $fetch_message['Number']; ?></span> </p>
                    <p> Email : <span><?php echo $fetch_message['Email']; ?></span> </p>
                    <p> Message : <span><?php echo $fetch_message['Message']; ?></span> </p>
                    <a href="https://mail.google.com/mail/u/4/#inbox" target="_blank" class="option-btn button">Reply</a>
                    <a href="admin-contacts.php?delete=<?php echo $fetch_message['MID']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
                </div>
                <?php
            };
        }else{
            echo '<p class="empty">You Have no Messages!</p>';
        }
        ?>
    </div>

</section>

<!-- custom admin js file link  -->
<script src="admin_script.js"></script>

</body>
</html>
