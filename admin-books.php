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

if (isset($_POST['add_book'])){

    $name = $_POST['name'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    $sql = " SELECT BookName FROM products WHERE BookName = '$name' ";
    $select_book_name = mysqli_query($conn, $sql) or die('query failed');

    if (mysqli_num_rows($select_book_name) > 0){
        $message[] = 'Book Title Already Added';
    } else{
        $sql2 = " INSERT INTO products(BookName, Author, Genre, Price, Image) VALUES ('$name', '$author', '$genre', '$price', '$image')";
        $add_book_query = mysqli_query($conn, $sql2);

        if ($add_book_query){
            if ($image_size > 2000000){
                $message[] = 'image size is too large';
            } else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Book Added Successfully!';
            }
        } else{
            $message[] = 'Books Could Not Be Added!';
        }
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $sql4 = " SELECT Image FROM products WHERE PID = '$delete_id' ";
    $delete_image_query = mysqli_query($conn, $sql4) or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/'.$fetch_delete_image['Image']);
    $del_query = " DELETE FROM products WHERE PID = '$delete_id' ";
    mysqli_query($conn, $del_query) or die('query failed');
    header('location:admin-books.php');
}

if(isset($_POST['update_book'])){

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_author = $_POST['update_author'];
    $update_genre = $_POST['update_genre'];
    $update_price = $_POST['update_price'];

    $sql6 = "UPDATE products SET BookName = '$update_name', Author = '$update_author', Genre = '$update_genre', Price = '$update_price' WHERE PID = '$update_p_id'";
    mysqli_query($conn, $sql6) or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];

    if(!empty($update_image)){
        if($update_image_size > 2000000){
            $message[] = 'image file size is too large';
        }else{
            $sql7 = "UPDATE products SET Image = '$update_image' WHERE PID = '$update_p_id'";
            mysqli_query($conn, $sql7) or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/'.$update_old_image);
        }
    }

    header('location:admin-books.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>

    <!-- Bootstrap Stylesheet -->

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">-->

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="admin-home.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<!--Books CRUD SECTION STARTS-->

<section class="add-products">
    <h1 class="title">Shop Books</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <h3>Add Book</h3>
        <input type="text" name="name" class="box" placeholder="Book Title" required>
        <input type="text" name="author" class="box" placeholder="Author" required>
        <input type="text" name="genre" class="box" placeholder="Book Genre" required>
        <input type="number" min="0" name="price" class="box" placeholder="Price" required>
        <input type="file" name="image" accept="image/jpeg, image/jpg, image/png" class="box" required>
        <input type="submit" value="add_book" name="add_book" class="btn">
    </form>

</section>

<!--Books CRUD SECTION ENDS-->

<!--Show Books-->

<section class="show-products">
    <div class="box-container">
        <?php
        $sql3 = " SELECT * FROM products ";
        $select_books = mysqli_query($conn, $sql3) or die('query failed');

        if(mysqli_num_rows($select_books) > 0){
            while($fetch_books = mysqli_fetch_assoc($select_books)){
                ?>
                <div class="box">
                    <img src="uploaded_img/<?php echo $fetch_books['Image']; ?>" alt="">
                    <div class="name"><?php echo $fetch_books['BookName']; ?></div>
                    <div class="author"><?php echo $fetch_books['Author']; ?></div>
                    <div class="genre"><?php echo $fetch_books['Genre']; ?></div>
                    <div class="price">$<?php echo $fetch_books['Price']; ?>/-</div>
                    <a href="admin-books.php?update=<?php echo $fetch_books['PID']; ?>" class="option-btn">Update</a>
                    <a href="admin-books.php?delete=<?php echo $fetch_books['PID']; ?>" class="delete-btn" onclick="return confirm('Delete This Book?');">Delete</a>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">No Books Added Yet!</p>';
        }
        ?>
    </div>
</section>

<section class="edit-book-form">

    <?php
    if(isset($_GET['update'])){
        $update_id = $_GET['update'];
        $sql5 = " SELECT * FROM products WHERE PID = '$update_id' ";
        $update_query = mysqli_query($conn, $sql5) or die('query failed');
        if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['PID']; ?>">
                    <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['Image']; ?>">
                    <img src="uploaded_img/<?php echo $fetch_update['Image']; ?>" alt="">
                    <input type="text" name="update_name" value="<?php echo $fetch_update['BookName']; ?>" class="box" placeholder="Book Name" required>
                    <input type="text" name="update_author" value="<?php echo $fetch_update['Author']; ?>" class="box" placeholder="Author" required>
                    <input type="text" name="update_genre" value="<?php echo $fetch_update['Genre']; ?>" class="box" required placeholder="Book Genre">
                    <input type="number" name="update_price" value="<?php echo $fetch_update['Price']; ?>" min="0" class="box" required placeholder="Book Price">
                    <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" value="update" name="update_book" class="btn">
                    <input type="reset" value="cancel" id="close-update" class="option-btn">
                </form>
                <?php
            }
        }
    }else{
        echo '<script>document.querySelector(".edit-book-form").style.display = "none";</script>';
    }
    ?>

</section>

<!--Bootstrap script files-->
<!--<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="js/bootstrap.js"></script>-->

<!-- custom admin js file link  -->
<script src="admin_script.js"></script>

</body>
</html>
