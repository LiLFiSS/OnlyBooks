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

if(isset($_POST['update_order'])){

    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $sql2 = "UPDATE orders SET Payment_Status = '$update_payment' WHERE OrderID = '$order_update_id'";
    mysqli_query($conn, $sql2) or die('query failed');
    $message[] = 'Payment Status Has Been Updated!';

}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $sql3 = "DELETE FROM orders WHERE OrderID = '$delete_id'";
    mysqli_query($conn, $sql3) or die('query failed');
    header('location:orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyBooks - Orders</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="admin-home.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="orders">

    <h1 class="title">Orders Placed</h1>

    <div class="box-container">
        <?php
        $sql = "SELECT * FROM orders";
        $select_orders = mysqli_query($conn, $sql) or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                ?>
                <div class="box">
                    <p> USER ID : <span><?php echo $fetch_orders['UID']; ?></span> </p>
                    <p> Placed On : <span><?php echo $fetch_orders['PlacedOn']; ?></span> </p>
                    <p> Name : <span><?php echo $fetch_orders['Name']; ?></span> </p>
                    <p> Number : <span><?php echo $fetch_orders['Number']; ?></span> </p>
                    <p> Email : <span><?php echo $fetch_orders['Email']; ?></span> </p>
                    <p> Address : <span><?php echo $fetch_orders['Address']; ?></span> </p>
                    <p> Total Books : <span><?php echo $fetch_orders['TotalItems']; ?></span> </p>
                    <p> Total price : <span>$<?php echo $fetch_orders['TotalPrice']; ?>/-</span> </p>
                    <p> Payment method : <span><?php echo $fetch_orders['Method']; ?></span> </p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['OrderID']; ?>">
                        <select name="update_payment">
                            <option value="" selected disabled><?php echo $fetch_orders['Payment_Status']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                        <input type="submit" value="update" name="update_order" class="option-btn">
                        <a href="orders.php?delete=<?php echo $fetch_orders['OrderID']; ?>" onclick="return confirm('Delete This Order?');" class="delete-btn">delete</a>
                    </form>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">No Orders Placed Yet!</p>';
        }
        ?>
    </div>

</section>

<!-- custom admin js file link  -->
<script src="admin_script.js"></script>

</body>
</html>

