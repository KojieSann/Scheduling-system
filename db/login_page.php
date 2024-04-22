<!DOCTYPE html>
<html lang="en">
  <head>
    <link
      rel="icon"
      type="x-icon"
      href="./img/olivarez-college-tagaytay-logo.png"
    />
    <link rel="stylesheet" href="login.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Olivarez College Tagaytay</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
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
        <form action="login.php" method = "post">
          <div class="info">
            <h1>Welcome Back!</h1>
            <p>Please Login to your account</p>
          </div>
          <div class="login-input">
          <div class="input-box">
            <input type="text" required id="username" name="username"/>
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
          <div class="remember">
            <label for="remember-me"><input type="checkbox" id="remember-me" name="remember" onclick="" /> Remember me?</label>
          </div>
          <button type="submit" class="login" onclick="pass()" name = "login" href >
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
    function pass() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      if (username.lenght == 0 && password.lenght == 0) 
            {
                 alert(" Username and password field is empty!!!");
                    return false;
                }
                else if(username.length==""){
                    alert(" Username field is empty!");
                    return false;
                }
                else if(password.length==""){
                    alert(" Password field is empty!");
                    return false;
                }
                
            }
    </script>
  </body>
</html>
