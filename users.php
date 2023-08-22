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
    $sql2 = "DELETE FROM systemusers WHERE UID = '$delete_id'";
    mysqli_query($conn, $sql2) or die('query failed');
    header('location:users.php');
}

if(isset($_POST['update_user'])){
    $update_uid = $_POST['update_uid'];
    $update_user_type = $_POST['update_user_type'];
    $sql4 = "UPDATE systemusers SET UserType = '$update_user_type' WHERE UID = '$update_uid'";
    mysqli_multi_query($conn, $sql4) or die('query failed');
    $message[] = 'User has been Updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyBooks - Users</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="admin-home.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="users">

    <h1 class="title"> user accounts </h1>

    <div class="box-container">
        <?php
        $sql = "SELECT * FROM systemusers";
        $select_users = mysqli_query($conn, $sql) or die('query failed');
        while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <div class="box">
                <?php
                $FirstName = $fetch_users['FirstName'];
                $LastName = $fetch_users['LastName'];
                $FullName = $FirstName. " " .$LastName;
                ?>
                <p>User ID : <span><?php echo $fetch_users['UID']; ?></span> </p>
                <p>Name : <span><?php echo $FullName; ?></span> </p>
                <p>Email : <span><?php echo $fetch_users['Email']; ?></span> </p>
                <p>User Type : <span style="color:<?php if($fetch_users['UserType'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['UserType']; ?></span> </p>
                <div class="btns">
                    <a href="users.php?update=<?php echo $fetch_users['UID']; ?>" class="option-btn button">Update User</a>
                    <a href="users.php?delete=<?php echo $fetch_users['UID']; ?>" onclick="return confirm('Delete This User?');" class="delete-btn button">Delete User</a>
                </div>
            </div>
            <?php
        };
        ?>
    </div>

</section>

<section class="edit-user-form">

    <?php
    if(isset($_GET['update'])){
        $update_id = $_GET['update'];
        $sql3 = " SELECT * FROM systemusers WHERE UID = '$update_id' ";
        $update_query = mysqli_query($conn, $sql3) or die('query failed');
        if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <?php
                    $FirstName = $fetch_update['FirstName'];
                    $LastName = $fetch_update['LastName'];
                    $FullName = $FirstName. " " .$LastName;
                    ?>
                    <div class="box"> <p>User ID : <span><?php echo $fetch_update['UID']; ?></span></p> </div>
                    <div class="box"> <p>Name : <span><?php echo $FullName; ?></span> </p> </div>
                    <div class="box"> <p>Email : <span><?php echo $fetch_update['Email']; ?></span> </p> </div>
                    <div class="box">
                        <select name="update_user_type">
                            <option value="" selected disabled><?php echo $fetch_update['UserType']; ?></option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <input type="hidden" name="update_uid" value="<?php echo $fetch_update['UID']; ?>">

                    <input type="submit" value="update" name="update_user" class="btn">
                    <input type="reset" value="cancel" id="close-update" class="option-btn">
                </form>
                <?php
            }
        }
    }else{
        echo '<script>document.querySelector(".edit-user-form").style.display = "none";</script>';
    }
    ?>

</section>

<!-- custom admin js file link  -->
<script src="admin_script.js"></script>

</body>
</html>
