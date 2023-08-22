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

if (isset($_POST['submit'])){
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $fullName = $firstName. " ". $lastName;

    $email = $_POST['email'];
    $phoneNumber = $_POST['phone-number'];
    $msg = $_POST['message'];

    $sql2 = "SELECT * FROM message WHERE Name = '$fullName' AND Email = '$email' AND Number = '$phoneNumber' AND Message = '$msg'" ;
    $select_message = mysqli_query($conn, $sql2) or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!';
    }else{
        $sql3 = " INSERT INTO message(UID, Name, Email, Number, Message) 
                    VALUES('$user_UID', '$fullName', '$email', '$phoneNumber', '$msg')";
        mysqli_query($conn, $sql3) or die('query failed');
        /*$message[] = 'Message Sent Successfully!';*/
    }

    $errors = '';
    $myemail = 'onlybooksbookstore@gmail.com';//<-----Put Your email address here.

    if(empty($_POST['first-name']) ||
        empty($_POST['last-name']) ||
        empty($_POST['phone-number']) ||
        empty($_POST['email']) ||
        empty($_POST['message']))
    {
        $errors .= "\n Error: all fields are required";
    }

    $fN = $_POST['first-name'];
    $lN = $_POST['last-name'];
    $name = $fN. " ". $lN;
    $phone_number = $_POST['phone-number'];
    $email_address = $_POST['email'];
    $mssg = $_POST['message'];

    if (!preg_match(
        "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
        $email_address))
    {
        $errors .= "\n Error: Invalid email address";
    }


    if( empty($errors)) {

        $to = $myemail;

        $email_subject = "Contact form submission: $name";

        $email_body = "You have received a new message. ".

            "Here are the details:\n Name: $name \n ".

            "Phone Number: $phone_number \n".

            "Email: $email_address\n ".

            "MESSAGE BODY: \n $mssg".

            $headers = "From: OnlyBooks User UID: $user_UID\n";

        $headers .= "Reply-To: $email_address";

        mail($to,$email_subject,$email_body,$headers);



        //redirect to the 'thank you' page

        header('Location: thank-you.php');

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>OnlyBooks - Contact Us</title>
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
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">-->

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>

</head>
<body>

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
                                <li class="menu-item active"><a href="contact.php" class="nav-link" data-effect="Contact">Contact Us</a></li>
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

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Contact us</h1>
                <div class="breadcrumbs">
                    <span class="item"><a href="home.php">Home /</a></span>
                    <span class="item">Contact us</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-information padding-large mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-0 mb-3">

                <h2>Get in Touch</h2>

                <div class="contact-detail d-flex flex-wrap mt-4">
                    <div class="detail mr-6 mb-4">
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <ul class="list-unstyled list-icon">
                            <li><i class="icon icon-phone"></i>+1868-243-0000</li>
                            <li><i class="icon icon-envelope-o"></i><a href="mailto:kaizhacode@gmail.com">onlyBooks@gmail.com</a></li>
                            <li><i class="icon icon-location2"></i>Somewhere, Trinidad</li>
                        </ul>
                    </div><!--detail-->
                    <div class="detail mb-4">
                        <h3>Social Links</h3>
                        <div class="social-links flex-container">
                            <a href="#" class="icon icon-facebook"></a>
                            <a href="#" class="icon icon-twitter"></a>
                            <a href="#" class="icon icon-pinterest-p"></a>
                            <a href="#" class="icon icon-youtube"></a>
                            <a href="#" class="icon icon-linkedin"></a>
                        </div><!--social-links-->
                    </div><!--detail-->

                </div><!--contact-detail-->
            </div><!--col-md-6-->

            <div class="col-md-6 p-0">

                <div class="contact-information">
                    <h2>Send A Message</h2>
                    <form name="contactform" action="contact.php" method="post" class="contact-form d-flex flex-wrap mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" minlength="2" name="first-name" placeholder="First Name" class="u-full-width" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="last-name" placeholder="Last Name" class="u-full-width" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" minlength="8" name="phone-number" placeholder="Phone Number" class="u-full-width" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" placeholder="E-mail" class="u-full-width" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <textarea class="u-full-width" name="message" placeholder="Message" style="height: 150px;" required></textarea>

                                <label>
                                    <input type="checkbox" required>
                                    <span class="label-body">I agree all the <a href="#">terms and conditions</a></span>
                                </label>

                                <button type="submit" name="submit" class="btn btn-full btn-rounded">Submit</button>
                            </div>
                        </div>
                    </form>

                </div><!--contact-information-->

            </div><!--col-md-6-->

        </div>
    </div>
</section>

<!--<section class="google-map">
  <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://getasearch.com/fmovies"></a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:100%;}</style><a href="https://www.embedgooglemap.net">embedgooglemap.net</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:100%;}</style></div></div>
</section>-->


<?php
/*$errors = '';
$myemail = 'kaizhacode@gmail.com';//<-----Put Your email address here.

if(empty($_POST['first-name']) ||
    empty($_POST['last-name']) ||
    empty($_POST['phone-number']) ||
    empty($_POST['email']) ||
    empty($_POST['message']))
{
    $errors .= "\n Error: all fields are required";
}

$fN = $_POST['first-name'];
$lN = $_POST['last-name'];
$name = $fN. " ". $lN;
$phone_number = $_POST['phone-number'];
$email_address = $_POST['email'];
$message = $_POST['message'];

if (!preg_match(
    "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
    $email_address))
{
    $errors .= "\n Error: Invalid email address";
}



if( empty($errors)) {

    $to = $myemail;

    $email_subject = "Contact form submission: $name";

    $email_body = "You have received a new message. ".

        " Here are the details:\n Name: $name \n ".

        "Phone Number: $phone_number \n".

        "Email: $email_address\n ".

        "Message \n $message".

    $headers = "From: OnlyBooks User $user_UID\n";

    $headers .= "Reply-To: $email_address";

    mail($to,$email_subject,$email_body,$headers);

    //redirect to the 'thank you' page

    header('Location: thank-you.php');

}*/
?>


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
