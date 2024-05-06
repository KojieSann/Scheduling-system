<?php
session_start();


$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'scheduling_system_db';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


function sanitize_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


function validate_user($username, $password, $conn)
{
    $username = sanitize_input($username);
    $password = sanitize_input($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        return true;
    } else {
        return false;
    }
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validate_user($username, $password, $conn)) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        $_SESSION['error_msg'] = "Invalid username or password!";
        header("Location: login_page.php");
        exit;
    }
}


if (isset($_SESSION['error_msg'])) {
    $error_msg = $_SESSION['error_msg'];
    unset($_SESSION['error_msg']);
}


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_page.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
    <link rel="stylesheet" href="login.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Olivarez College Tagaytay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="area">
            <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>


        <div class="login-form">

            <div class="logo">
                <img src="./img/olivarez-college-tagaytay-logo.png" alt="logo" />
                <h1>Olivarez College Tagaytay</h1>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="info">
                    <h1>Welcome Back!</h1>
                    <p>Please Login to your account</p>
                </div>
                <div class="login-input">
                    <?php if (isset($error_msg)) { ?>
                        <div class="error"><?php echo $error_msg; ?></div>
                    <?php } ?>
                    <div class="input-box">
                        <input type="text" required id="username" name="username" />
                        <span>Username</span>
                    </div>
                    <div class="input-box">
                        <input type="password" required class="password" name="password" />
                        <span>Password</span>
                        <div class="show-hide" onclick="togglePasswordVisibility()">
                            <i class="fa-regular fa-eye show"></i>
                            <i class="fa-regular fa-eye-slash hide"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" class="login" onclick="pass()" name="login">
                    Login
                </button>
            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.querySelector(".password");
            var showHide = document.querySelector(".show-hide");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showHide.classList.toggle("showPass");
            } else {
                passwordInput.type = "password";
                showHide.classList.remove("showPass");
            }
        }
    </script>
</body>

</html>