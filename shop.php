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

if (isset($_POST['add-to-cart'])){
    $book_title = $_POST['book_name'];
    $book_author = $_POST['book_author'];
    $book_price = $_POST['book_price'];
    $book_image = $_POST['book_image'];
    $book_qty = $_POST['book_quantity'];

    $sql3 = "SELECT * FROM cart WHERE ItemName = '$book_title' AND UID = '$user_UID'";
    $check_cart_numbers = mysqli_query($conn, $sql3) or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Already Added to Cart!';
    }else{
        $sql4 = "INSERT INTO cart(UID, ItemName, BookAuthor, Price, Quantity, Image) 
                    VALUES('$user_UID', '$book_title', '$book_author', '$book_price', '$book_qty', '$book_image')";
        mysqli_query($conn, $sql4) or die('query failed');
        $message[] = 'Book Added to Cart!';
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
                                <li class="menu-item active"><a href="shop.php" class="nav-link" data-effect="Shop">Shop</a></li>
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
                    <h1 class="page-title">Shop</h1>
                    <div class="breadcum-items">
                        <span class="item"><a href="shop.php">Home /</a></span>
                        <span class="item colored">Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--site-banner-->

<section class="padding-large">
    <div class="container">
        <div class="row">

            <div class="products-grid grid">
                <?php
                $sql2 = "SELECT * FROM products";
                $select_products = mysqli_query($conn, $sql2) or die('query failed');
                if (mysqli_num_rows($select_products) > 0){
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
                        ?>

                        <form action="" method="post">
                            <figure class="product-style" style="width: 20rem;" >
                                <img class="product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
                                <button type="submit" class="add-to-cart" value="add to cart" name="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                                <figcaption>
                                    <h3><?php echo $fetch_products['BookName']; ?></h3>
                                    <p><?php echo $fetch_products['Author']; ?></p>
                                    <input type="number" min="1" name="book_quantity" value="1" class="qty">
                                    <div class="item-price">$<?php echo $fetch_products['Price']; ?>.00</div>
                                </figcaption>
                                <input type="hidden" name="book_name" value="<?php echo $fetch_products['BookName']; ?>">
                                <input type="hidden" name="book_author" value="<?php echo $fetch_products['Author']; ?>">
                                <input type="hidden" name="book_price" value="<?php echo $fetch_products['Price']; ?>">
                                <input type="hidden" name="book_image" value="<?php echo $fetch_products['Image']; ?>">
                            </figure>
                        </form>

                        <?php
                    }
                }else{
                    echo '<p class="empty">no products added yet!</p>';
                }
                ?>



                <!--<figure class="product-style">
                    <img src="images/tab-item2.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Once upon a time</h3>
                        <p>Klien Marry</p>
                        <div class="item-price">$ 35.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item3.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Tips of simple lifestyle</h3>
                        <p>Bratt Smith</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item4.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Just felt from outside</h3>
                        <p>Nicole Wilson</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item5.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Peaceful Enlightment</h3>
                        <p>Marmik Lama</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item6.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Great travel at desert</h3>
                        <p>Sanchit Howdy</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item7.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Life among the pirates</h3>
                        <p>Armor Ramsey</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>

                <figure class="product-style">
                    <img src="images/tab-item8.jpg" alt="Books" class="product-item">
                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button>
                    <figcaption>
                        <h3>Simple way of piece life</h3>
                        <p>Armor Ramsey</p>
                        <div class="item-price">$ 40.00</div>
                    </figcaption>
                </figure>-->

            </div>

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
