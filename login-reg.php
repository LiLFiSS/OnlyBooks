<?php

/*ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);*/

/*if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}*/

/*@include 'config.php';*/
session_start();

if (isset($_POST['register'])) {
    /*Database Connection*/
    $host = "localhost";
    $dbname = "bookstore_db";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];

    $DOB = $_POST['DOB'];
    $PhoneNumber = $_POST['phone-num'];

    $address = $_POST['address'];
    $city = $_POST['city'];

    $email = $_POST['email'];

    $pass = $_POST['password'];
    $re_password = $_POST['re-password'];

    $userType = "user";

    $select = " SELECT * FROM systemusers WHERE Email = '$email' AND Password = '$pass' ";

    $result = mysqli_query($conn, $select) or die('query failed');

    if (mysqli_num_rows($result) == 0){
        $sql = "INSERT INTO systemusers(FirstName, LastName, DOB, 
                        PhoneNo, Address, City, Email, Password, UserType)
                        VALUES('$firstName', '$lastName', '$DOB', '$PhoneNumber', '$address', '$city', '$email', '$pass', '$userType')";

        $result = mysqli_query($conn, $sql);

        if ($result){
            echo $message[] = 'Account Created Successfully!';
            header('refresh:20; location:login-reg.php');
            mysqli_close($conn);
        } else {
            echo $message[] = 'Account Creation Error';
            mysqli_close($conn);
        }

        if ($pass != $re_password) {
            echo $message[] = 'Passwords Do not match';
            mysqli_close($conn);
        }
    } else {
        echo $message[] = 'Account already exists';
        mysqli_close($conn);
    }

    /*if (mysqli_num_rows($result) > 0) {

        $message[] = 'user already exists!';

    } else {
         else {

            header('location:home.php');
            $message[] = 'Account Created Successfully!';
            header('location:login-reg.php');
        }
    }*/
}

if (isset($_POST['login'])){
    /*Database Connection*/
    $host = "localhost";
    $dbname = "bookstore_db";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    $email = $_POST['login-email'];
    $pass = $_POST['login-password'];

    $select = " SELECT * FROM systemusers WHERE Email = '$email' AND Password = '$pass' ";
    $result = mysqli_query($conn, $select) or die('query failed');

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['UserType'] == 'admin') {
            $_SESSION['admin_FirstName'] = $row['FirstName'];
            $_SESSION['admin_Email'] = $row['Email'];
            $_SESSION['admin_UID'] = $row['UID'];
            header('location:admin-home.php');

        } else{
            if ($row['UserType'] == 'user'){
                $_SESSION['user_FirstName'] = $row['FirstName'];
                $_SESSION['user_Email'] = $row['Email'];
                $_SESSION['user_UID'] = $row['UID'];
                $_SESSION['user_Password'] = $row['Password'];
                header('location:home.php');
            }
        }

    }else{
        $message[] = 'Incorrect Email or Password';
    }
    
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="login.css">

    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyBooks SignIn/Register</title>
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
<div class="nav">
    <img src="images/content/images/onlybooks-logo.png">
</div>


<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="images/login/1.png" alt="">
            <div class="text">
                <span class="text-1">Every new book is a <br> new adventure</span>
                <span class="text-2">Let's get connected</span>
            </div>
        </div>
        <div class="back">
            <img class="backImg" src="images/login/3.png" alt="">
            <div class="text">
                <span class="text-1">Complete miles of journey <br> with one step</span>
                <span class="text-2">Let's get started</span>
            </div>
        </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Login</div>
                <form action="" method="post">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="login-email" id="login-email" placeholder="Enter your email" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="login-password" id="login-password" placeholder="Enter your password" required>
                        </div>
                        <div class="text"><a href="#">Forgot password?</a></div>
                        <div class="button input-box">
                            <input type="submit" name="login" value="Submit">
                        </div>
                        <div class="text sign-up-text">Don't have an account? <label for="flip">Signup now</label></div>
                    </div>
                </form>
            </div>
            <div class="signup-form">
                <div class="title">Signup</div>
                <form action="" method="post">
                    <div class="input-boxes">
                        <div class="names">
                            <div class="input-box fname">
                                <i class="fas fa-user"></i>
                                <input type="text" name="first-name" id="first-name" placeholder="First Name" required>
                            </div>

                            <div class="input-box lname">
                                <i class="fas fa-user"></i>
                                <input type="text" name="last-name" id="last-name" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div class="box-2">
                            <div class="input-box">
                                <i class="fa-solid fa-calendar-days"></i>
                                <input type="text" name="DOB" id="DOB" placeholder="Date of Birth" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                            </div>

                            <div class="input-box">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" name="phone-num" class="phone" id="phone-num" placeholder="Phone Number" required>
                            </div>
                        </div>


                        <div class="addy">
                            <div class="input-box add-1">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" name="address" id="address" placeholder="Address" required>
                            </div>

                            <div class="input-box add-2">
                                <i class="fa-solid fa-city"></i>
                                <input type="text" name="city" id="city" placeholder="City" class="city" required>
                            </div>
                        </div>


                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="email" id="email" placeholder="Enter your email" required>
                        </div>

                        <div class="password">
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="re-password" id="re-password" placeholder="Confirm your password" required>
                            </div>
                        </div>


                        <div class="button input-box">
                            <input type="submit" name="register" value="Submit">
                        </div>
                        <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

