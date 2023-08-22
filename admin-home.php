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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="admin-home.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<!--Dashboard Starts-->
<section class="dashboard">

    <h1 class="title">Dashboard</h1>

    <div class="box-container">

        <div class="box">
            <?php
            $totalPending = 0;
            $sql = " SELECT TotalPrice FROM orders WHERE Payment_Status = 'pending' ";
            $select_pending = mysqli_query($conn, $sql) or die('query failed');
            if (mysqli_num_rows($select_pending) > 0){
                while ($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                    $totalPrice = $fetch_pendings['TotalPrice'];
                    $totalPending += $totalPrice;
                };
            };
            ?>
            <i class="uil uil-clock"></i>
            <h3>$<?php echo $totalPending;?>/-</h3>
            <p>Total Pending</p>
        </div>

        <div class="box" style="background-color: #C5A992">
            <?php
            $totalCompeted = 0;
            $sql2 = " SELECT TotalPrice FROM orders WHERE Payment_Status = 'completed' ";
            $select_Competed = mysqli_query($conn, $sql2) or die('query failed');
            if (mysqli_num_rows($select_Competed) > 0){
                while ($fetch_completed = mysqli_fetch_assoc($select_Competed)){
                    $totalPrice = $fetch_completed['TotalPrice'];
                    $totalCompeted += $totalPrice;
                };
            };
            ?>
            <i class="uil uil-shopping-cart-alt"></i>
            <h3>$<?php echo $totalCompeted;?>/-</h3>
            <p>Completed Payments</p>
        </div>

        <div class="box">
            <?php
            $sql3 = " SELECT * FROM orders ";
            $select_orders = mysqli_query($conn, $sql3) or die('query failed');

            $Num_Orders = mysqli_num_rows($select_orders);
            ?>
            <i class="uil uil-bill"></i>
            <h3><?php echo $Num_Orders; ?></h3>
            <p>Orders Placed</p>
        </div>

        <div class="box" style="background-color: #C5A992">
            <?php
            $sql4 = " SELECT * FROM products ";
            $select_products = mysqli_query($conn, $sql4) or die('query failed');

            $Num_of_Products = mysqli_num_rows($select_products);
            ?>
            <i class="uil uil-book-alt"></i>
            <h3><?php echo $Num_of_Products; ?></h3>
            <p>Books Added</p>
        </div>
    </div>

    <div class="box-container bx-2" style="margin-top: 20px">
        <div class="box" style="background-color: #C5A992">
            <?php
            $sql5 = " SELECT * FROM systemusers WHERE UserType = 'user'";
            $select_users = mysqli_query($conn, $sql5) or die('query failed');

            $Num_of_users = mysqli_num_rows($select_users);
            ?>
            <i class="uil uil-user"></i>
            <h3><?php echo $Num_of_users; ?></h3>
            <p>Customer Accounts</p>
        </div>

        <div class="box">
            <?php
            $sql6 = " SELECT * FROM systemusers WHERE UserType = 'admin'";
            $select_admins = mysqli_query($conn, $sql6) or die('query failed');

            $Num_of_admins = mysqli_num_rows($select_admins);
            ?>
            <i class="uil uil-user-check"></i>
            <h3><?php echo $Num_of_admins; ?></h3>
            <p>Admin Accounts</p>
        </div>

        <div class="box" style="background-color: #C5A992">
            <?php
            $sql7 = " SELECT * FROM systemusers ";
            $select_account = mysqli_query($conn, $sql7) or die('query failed');

            $Num_of_accounts = mysqli_num_rows($select_account);
            ?>
            <i class="uil uil-users-alt"></i>
            <h3><?php echo $Num_of_accounts; ?></h3>
            <p>Total Users</p>
        </div>

        <div class="box">
            <?php
            $sql8 = " SELECT * FROM message ";
            $select_messages = mysqli_query($conn, $sql8) or die('query failed');

            $Num_of_messages = mysqli_num_rows($select_messages);
            ?>
            <i class="uil uil-envelopes"></i>
            <h3><?php echo $Num_of_messages; ?></h3>
            <p>New Messages</p>
        </div>
    </div>


</section>
<!--Dashboard Ends-->

<!-- custom admin js file link  -->
<script src="admin_script.js"></script>

</body>
</html>
