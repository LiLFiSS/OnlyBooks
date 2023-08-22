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
    <title>OnlyBooks - Home</title>
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
                                <li class="menu-item active"><a href="home.php" data-effect="Home">Home</a></li>
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


<section id="billboard"> <!--Billboard-->

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <button class="prev slick-arrow">
                    <i class="icon icon-arrow-left"></i>
                </button>

                <div class="main-slider pattern-overlay">
                    <div class="slider-item">
                        <div class="banner-content">
                            <h2 class="banner-title">Life of the Wild</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu feugiat amet, libero ipsum enim pharetra hac. Urna commodo, lacus ut magna velit eleifend. Amet, quis urna, a eu.</p>
                            <div class="btn-wrap">
                                <a href="shop.php" class="btn btn-outline-accent btn-accent-arrow">Shop Now<i class="icon icon-ns-arrow-right"></i></a>
                            </div>
                        </div><!--banner-content-->
                        <img src="images/content/images/main-banner1.jpg" alt="banner" class="banner-image">
                    </div><!--slider-item-->

                    <div class="slider-item">
                        <div class="banner-content">
                            <h2 class="banner-title">Birds gonna be Happy</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu feugiat amet, libero ipsum enim pharetra hac. Urna commodo, lacus ut magna velit eleifend. Amet, quis urna, a eu.</p>
                            <div class="btn-wrap">
                                <a href="shop.php" class="btn btn-outline-accent btn-accent-arrow">Shop Now<i class="icon icon-ns-arrow-right"></i></a>
                            </div>
                        </div><!--banner-content-->
                        <img src="images/content/images/main-banner2.jpg" alt="banner" class="banner-image">
                    </div><!--slider-item-->

                </div><!--slider-->

                <button class="next slick-arrow">
                    <i class="icon icon-arrow-right"></i>
                </button>

            </div>
        </div>
    </div>
</section> <!--Billboard-->

<section id="featured-books"> <!--Featured Books-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="section-header align-center">
                    <div class="title">
                        <span>Some quality items</span>
                    </div>
                    <h2 class="section-title">Featured Books</h2>
                </div>

                <div class="product-list" data-aos="fade-up">
                    <div class="row">

                        <?php
                        $sql2 = "SELECT * FROM products LIMIT 4";
                        $select_products = mysqli_query($conn, $sql2) or die('query failed');
                        if (mysqli_num_rows($select_products) > 0){
                            while($fetch_products = mysqli_fetch_assoc($select_products)){
                                ?>
                                <div class="col-md-3">
                                    <form action="" method="post" class="box">
                                        <figure class="product-style">
                                            <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                </div>
                                <?php
                            }
                        }else{
                            echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>

                    </div><!--ft-books-slider-->
                </div><!--grid-->


            </div><!--inner-content-->
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="btn-wrap align-right">
                    <a href="#" class="btn-accent-arrow">View all products <i class="icon icon-ns-arrow-right"></i></a>
                </div>

            </div>
        </div>
    </div>
</section> <!--Featured Books-->

<section id="best-selling" class="leaf-pattern-overlay"> <!--Best Selling-->
    <div class="corner-pattern-overlay"></div>
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                <div class="row">

                    <div class="col-md-6">
                        <figure class="products-thumb">
                            <img src="images/content/images/single-image.jpg" alt="book" class="single-image">
                        </figure>
                    </div>

                    <div class="col-md-6">
                        <div class="product-entry">
                            <h2 class="section-title divider">Best Selling Book</h2>

                            <div class="products-content">
                                <div class="author-name">By Timbur Hood</div>
                                <h3 class="item-title">Birds gonna be happy</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu feugiat amet, libero ipsum enim pharetra hac.</p>
                                <div class="item-price">$ 45.00</div>
                                <div class="btn-wrap">
                                    <a href="shop.php" class="btn-accent-arrow">shop it now <i class="icon icon-ns-arrow-right"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- / row -->

            </div>

        </div>
    </div>
</section> <!--Best Selling-->

<section id="popular-books" class="bookshelf"> <!--Popular Books-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="section-header align-center">
                    <div class="title">
                        <span>Some quality items</span>
                    </div>
                    <h2 class="section-title">Popular Books</h2>
                </div>

                <ul class="tabs">
                    <li data-tab-target="#all-genre" class="active tab">All Genre</li>
                    <li data-tab-target="#business" class="tab">Business</li>
                    <li data-tab-target="#technology" class="tab">Technology</li>
                    <li data-tab-target="#romantic" class="tab">Romantic</li>
                    <li data-tab-target="#adventure" class="tab">Adventure</li>
                    <li data-tab-target="#fictional" class="tab">Fictional</li>
                </ul>

                <div class="tab-content">
                    <div id="all-genre" data-tab-content class="active">
                        <div class="row">

                            <?php
                            $sql2 = "SELECT * FROM products LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>

                        </div>
                        <div class="row">

                            <?php
                            $sql2 = "SELECT * FROM products WHERE PID > 9 LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>

                        </div>

                    </div>
                    <div id="business" data-tab-content>
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM products WHERE Genre = 'Business' LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>

                        </div>
                    </div>

                    <div id="technology" data-tab-content>
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM products WHERE Genre = 'Technology' LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>

                        </div>
                    </div>

                    <div id="romantic" data-tab-content>
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM products WHERE Genre = 'Romance' LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div id="adventure" data-tab-content>
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM products WHERE Genre = 'Adventure' LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div id="fictional" data-tab-content>
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM products WHERE Genre = 'Fiction' LIMIT 4";
                            $select_products = mysqli_query($conn, $sql2) or die('query failed');
                            if (mysqli_num_rows($select_products) > 0){
                                while($fetch_products = mysqli_fetch_assoc($select_products)){
                                    ?>
                                    <div class="col-md-3">
                                        <form action="" method="post" class="box">
                                            <figure class="product-style">
                                                <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                            ?>

                        </div>
                    </div>

                </div>

            </div><!--inner-tabs-->

        </div>
    </div>
</section> <!--Popular Books-->

<section id="quotation" class="align-center"> <!--Quote-->
    <div class="inner-content">
        <h2 class="section-title divider">Quote of the day</h2>
        <blockquote data-aos="fade-up">
            <q>“The more that you read, the more things you will know. The more that you learn, the more places you’ll go.”</q>
            <div class="author-name">Dr. Seuss</div>
        </blockquote>
    </div>
</section> <!--Quote-->

<section id="special-offer" class="bookshelf"> <!--Bookshelf-->

    <div class="section-header align-center">
        <div class="title">
            <span>Grab your opportunity</span>
        </div>
        <h2 class="section-title">Books with offer</h2>
    </div>

    <div class="container">
        <div class="row">
            <div class="inner-content">
                <div class="product-list" data-aos="fade-up">
                    <div class="grid product-grid">
                        <?php
                        $sql2 = "SELECT * FROM products WHERE Price < 40";
                        $select_products = mysqli_query($conn, $sql2) or die('query failed');
                        if (mysqli_num_rows($select_products) > 0){
                            while($fetch_products = mysqli_fetch_assoc($select_products)){
                                ?>
                                    <form action="" method="post" class="box">
                                        <figure class="product-style">
                                            <img class="image product-item" src="uploaded_img/<?php echo $fetch_products['Image']; ?>" alt="Books">
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
                    </div><!--grid-->
                </div>
            </div><!--inner-content-->
        </div>
    </div>
</section> <!--Bookshelf-->

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
