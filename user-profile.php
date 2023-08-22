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
/*$user_Password = $_SESSION['user_Password'];*/

if(!isset($user_UID)){
    header('location:login-reg.php');
}

if(isset($_POST['update_user'])){
    $sql5 = "SELECT Password FROM systemusers where UID = '$user_UID'";
    $select_pass = mysqli_query($conn, $sql5);
    if ($select_pass > 0){
        $p_wrd = mysqli_fetch_assoc($select_pass);
    }

    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $re_pass = $_POST['pass-confirm'];

    $update_uid = $_POST['update_uid'];
    $update_user_fName = $_POST['update-f-name'];
    $update_user_LName = $_POST['update-l-name'];
    $update_user_dob = $_POST['update-dob'];
    $update_user_number = $_POST['update-number'];
    $update_user_address = $_POST['update-addy'];
    $update_user_city = $_POST['update-city'];
    $update_user_email = $_POST['update-email'];
    $update_user_password = $_POST['new-password'];

    if ($old_password != $p_wrd){
        $message[] = "Error changing password - Incorrect Old password Entered";
    }else if ($new_password != $re_pass){
        $message[] = 'Passwords Do Not Match';
    }else{
        $sql4 = "UPDATE systemusers SET FirstName = '$update_user_fName', LastName = '$update_user_LName', DOB = '$update_user_dob', PhoneNo = '$update_user_number', 
                       Address = '$update_user_address', City = '$update_user_city', Email = '$update_user_email', Password = '$update_user_password' WHERE UID = '$update_uid'";
        mysqli_multi_query($conn, $sql4) or die('query failed');
        $message[] = 'Account has been Updated!';
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>OnlyBooks - Shop</title>
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
    <!--<link rel="stylesheet" type="text/css" href="update-style.css">-->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font awesome cdn link  -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">-->

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

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
                                <li class="menu-item"><a href="user-orders.php" class="nav-link" data-effect="Orders">Orders</a></li>
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
                    <h1 class="page-title"> <?php echo $_SESSION['user_FirstName'];?>'s Profile</h1>
                    <div class="breadcum-items">
                        <span class="item"><a href="home.php">Home /</a></span>
                        <span class="item colored">User Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--site-banner-->

<section class="padding-large">
    <div class="container" style="padding: 1rem 20rem;">
        <?php
        $sql2 = "SELECT * FROM systemusers WHERE UID = $user_UID";
        $select_user = mysqli_query($conn, $sql2) or die('query failed');
        if (mysqli_num_rows($select_user) > 0){
            while($fetch_user = mysqli_fetch_assoc($select_user)){
                ?>
                <div class="p-box">

                    <div class="pfp">
                        <div class="p-icon">
                            <i class="uil uil-user-circle profile-icon"></i>
                        </div>
                    </div>

                    <div class="profile-box">
                        <ul class="box-1">
                            <li>First Name: <span><?php echo $fetch_user['FirstName'] ?></span></li>
                            <li>Last Name: <span><?php echo $fetch_user['LastName'] ?></span></li>
                            <li>Date of Birth: <span><?php echo $fetch_user['DOB'] ?></span></li>
                            <li>Phone Number: <span><?php echo $fetch_user['PhoneNo'] ?></span></li>
                            <li>Address: <span><?php echo $fetch_user['Address'] ?></span></li>
                            <li>City: <span><?php echo $fetch_user['City'] ?></span></li>
                            <li>Email: <span><?php echo $fetch_user['Email'] ?></span></li>
                            <li><a href="user-profile.php?update=<?php echo $fetch_user['UID']; ?>" class="btn up-btn">Update User</a></li>
                        </ul>
                    </div>
                </div>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">User does Not Exist</p>';
        }
        ?>
    </div>
</section>

<section class="edit-user-profile-form">
    <div class="con">
        <div class="content">
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
                            $DOB = $fetch_update['DOB'];
                            $Address = $fetch_update['Address'];
                            $City = $fetch_update['City'];
                            $Email = $fetch_update['Email'];
                            $PhoneNo = $fetch_update['PhoneNo'];
                            $Pword = $fetch_update['Password'];
                            ?>
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">First Name</span>
                                    <input type="text" name="update-f-name" value="<?php echo $FirstName?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Last Name</span>
                                    <input type="text" name="update-l-name" value="<?php echo $LastName?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date of Birth</span>
                                    <input type="date" name="update-dob" value="<?php echo $DOB?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="update-addy" value="<?php echo $Address?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="update-city" value="<?php echo $City?>" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="text" name="update-email" value="<?php echo $Email?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Phone Number</span>
                                    <input type="text" name="update-number" value="<?php echo $PhoneNo?>" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Old Password</span>
                                    <input type="text" name="old-password" placeholder="Enter your password" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">New Password</span>
                                    <input type="text" name="new-password" placeholder="Enter your password" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Confirm New Password</span>
                                    <input type="text" name="pass-confirm" placeholder="Confirm your password" required>
                                </div>
                            </div>
                            <input type="hidden" name="update_uid" value="<?php echo $fetch_update['UID']; ?>">

                            <input type="submit" value="update" name="update_user" class="btn">
                            <input type="reset" value="cancel" id="close-update" class="option-btn">
                        </form>
                        <?php
                    }
                }
            }else{
                echo '<script>document.querySelector(".edit-user-profile-form").style.display = "none";</script>';
            }
            ?>
        </div>
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

