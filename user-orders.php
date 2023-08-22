<?php

include 'config.php';

/*Database Connection*/
$host = "localhost";
$dbname = "bookstore_db";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

session_start();

$user_UID = $_SESSION['user_UID'];

if(!isset($user_UID)){
    header('location:login-reg.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>OnlyBooks - My Orders</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" type="text/css" href="css2/normalize.css">
    <link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" href="css2/vendor.css">
    <link rel="stylesheet" type="text/css" href="user-style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>

</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<div id="header-wrap">

    <div class="top-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="social-links">
                        <ul>
                            <li>
                                <a href="#"><i class="icon icon-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-youtube-play"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-behance-square"></i></a>
                            </li>
                        </ul>
                    </div><!--social-links-->
                </div>
                <div class="col-md-6">
                    <div class="right-element">
                        <a href="#" class="user-account for-buy" id="user-btn"><i class="icon icon-user"></i><span>Hello, <?php echo $_SESSION['user_FirstName']; ?></span></a>
                        <?php
                        $sql = "SELECT * FROM cart WHERE UID = $user_UID";
                        $select_cart_number = mysqli_query($conn, $sql) or die('query failed');
                        $cart_rows_number = mysqli_num_rows($select_cart_number);
                        ?>
                        <a href="cart.php" class="cart for-buy"><i class="icon icon-clipboard"></i><span>Cart:(<?php echo $cart_rows_number;?>)</span></a>


                        <div class="action-menu">
                            <div class="search-bar">
                                <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                                    <i class="icon icon-search"></i>
                                </a>
                                <form role="search" method="get" class="search-box">
                                    <input class="search-field text search-input" placeholder="Search" type="search">
                                </form>
                            </div>
                        </div>


                        <div class="user-box">
                            <a href="user-profile.php" class="profile" style="color: #C5A992;">Your Account</a> <br>
                            <a href="logout.php" class="logout-btn">logout</a>
                        </div>

                    </div><!--top-right-->
                </div>

            </div>
        </div>
    </div> <!--top-content-->

    <header id="header">
        <div class="container">
            <div class="row">

                <div class="col-md-2">
                    <div class="main-logo">
                        <a href="home.php"><img src="images/content/images/onlybooks-logo.png" alt="logo"></a>
                    </div>

                </div>

                <div class="col-md-10">

                    <nav id="navbar">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list">
                                <li class="menu-item"><a href="home.php" data-effect="Home">Home</a></li>
                                <li class="menu-item"><a href="about.php" class="nav-link" data-effect="About">About</a></li>
                                <li class="menu-item"><a href="shop.php" class="nav-link" data-effect="Shop">Shop</a></li>
                                <li class="menu-item"><a href="contact.php" class="nav-link" data-effect="Contact">Contact Us</a></li>
                                <li class="menu-item active"><a href="user-orders.php" class="nav-link" data-effect="Orders">Orders</a></li>
                            </ul>

                            <div class="hamburger">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>

                        </div>
                    </nav>

                </div>

            </div>
        </div>
    </header>

</div><!--header-wrap-->

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="colored">
                    <h1 class="page-title">My Orders</h1>
                    <div class="breadcum-items">
                        <span class="item"><a href="home.php">Home /</a></span>
                        <span class="item colored">Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--site-banner-->

<section class="placed-orders">
    <!--<h1 class=""></h1>-->

    <div class="box-container">

        <?php
        $sql2 = "SELECT * FROM `orders` WHERE UID = '$user_UID'";
        $order_query = mysqli_query($conn, $sql2) or die('query failed');
        if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
                ?>
                <div class="box">
                    <p> Placed on : <span><?php echo $fetch_orders['PlacedOn']; ?></span> </p>
                    <p> Name : <span><?php echo $fetch_orders['Name']; ?></span> </p>
                    <p> Phone Number : <span><?php echo $fetch_orders['Number']; ?></span> </p>
                    <p> Email : <span><?php echo $fetch_orders['Email']; ?></span> </p>
                    <p> Address : <span><?php echo $fetch_orders['Address']; ?></span> </p>
                    <p> Payment Method : <span><?php echo $fetch_orders['Method']; ?></span> </p>
                    <p> Your Items : <span><?php echo $fetch_orders['TotalItems']; ?></span> </p>
                    <p> Total Price : <span>$<?php echo $fetch_orders['TotalPrice']; ?>.00</span> </p>
                    <p> Payment Status : <span style="color:<?php if($fetch_orders['Payment_Status'] == 'Pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['Payment_Status']; ?></span> </p>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">No Orders Placed Yet! <a href="shop.php" style="text-decoration: none">Shop Now</a> </p>';
        }
        ?>

    </div>
</section>

<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4">

                <div class="footer-item">
                    <div class="company-brand">
                        <img src="images/content/images/onlybooks-logo.png" alt="logo" class="footer-logo">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis sed ptibus liberolectus nonet psryroin. Amet sed lorem posuere sit iaculis amet, ac urna. Adipiscing fames semper erat ac in suspendisse iaculis.</p>
                    </div>
                </div>

            </div>

            <div class="col-md-2">

                <div class="footer-menu">
                    <h5>About Us</h5>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="about.php">vision</a>
                        </li>
                        <li class="menu-item">
                            <a href="about.php">articles </a>
                        </li>
                        <li class="menu-item">
                            <a href="about.php">service terms</a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="col-md-2">

                <div class="footer-menu">
                    <h5>Discover</h5>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="home.php">Home</a>
                        </li>
                        <li class="menu-item">
                            <a href="shop.php">Books</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Authors</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-2">

                <div class="footer-menu">
                    <h5>My account</h5>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="login-reg.php">Sign In</a>
                        </li>
                        <li class="menu-item">
                            <a href="cart.php">View Cart</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Track My Order</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-2">

                <div class="footer-menu">
                    <h5>Help</h5>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="contact.php">Help center</a>
                        </li>
                        <li class="menu-item">
                            <a href="contact.php">Report a problem</a>
                        </li>
                        <li class="menu-item">
                            <a href="contact.php">Suggesting edits</a>
                        </li>
                        <li class="menu-item">
                            <a href="contact.php">Contact us</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
        <!-- / row -->

    </div>
</footer>

<div id="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="copyright">
                    <div class="row">

                        <div class="col-md-6">
                            <p>© Kaizha Brathwaite - 84109.</p>
                        </div>

                        <div class="col-md-6">
                            <div class="social-links align-right">
                                <ul>
                                    <li>
                                        <a href="#"><i class="icon icon-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon icon-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon icon-youtube-play"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="icon icon-behance-square"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div><!--grid-->

            </div><!--footer-bottom-content-->
        </div>
    </div>
</div>

<script src="user_script.js"></script>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/script.js"></script>
</body>
</html>
