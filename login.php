<?php
// Start session
session_start();

// Include necessary files
include './constant/layout/head.php';
include './constant/connect.php';

// Initialize errors array
$errors = array();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get email and password from form
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate email and password
  if (empty($email)) {
    $errors[] = "Email is required";
  }
  if (empty($password)) {
    $errors[] = "Password is required";
  }

  // If no validation errors, proceed with login
  if (empty($errors)) {
    // Prepare and execute SQL query to fetch user with provided email
    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user exists, verify password
    if ($result->num_rows == 1) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user['password'])) {
        // Password is correct, set session and redirect to dashboard
        $_SESSION['userId'] = $user['user_id'];
        header('Location: dashboard.php');
        exit();
      } else {
        // Incorrect password
        $errors[] = "Incorrect email/password combination";
      }
    } else {
      // User does not exist
      $errors[] = "Email does not exist";
    }
  }
}
?>

<!-- HTML code for login form -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/popup_style.css">

  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    footer {
      margin-top: auto;
      text-align: center;
      background-color: #f8f9fa;
      /* Optional background color */
      padding: 20px 0;
    }
  </style>
</head>

<body>

  <div id="main-wrapper">
    <div class="unix-login">
      <div class="container-fluid" style="background-image: url('assets/uploadImage/Logo/banner3.jpg'); background-color: #ffffff; background-size:cover">
        <div class="row ">
          <div class="col-md-4">
            <div class="login-content ">
              <div class="login-form">
                <center><img src="./assets/uploadImage/Logo/logo.png" style="width: 300px;"></center><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="loginForm" class="row">
                  <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                  </div>
                  <div class="col-md-6 form-check">
                    <input type="checkbox" class="pl-3" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                  </div>
                  <div class="forgot-phone col-md-6 text-right">
                    <a href="#" class="text-right f-w-600 text-gray">Forgot Password?</a>
                  </div>
                  <div class="col-md-12">
                    <button style="background-color: #102b49; border-radius: 50px;" type="submit" name="login" class="f-w-600 text-white btn  btn-flat m-b-30 m-t-30">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>&copy; 2023. All rights reserved Jabed Hossain.</p>
        </div>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  <!-- JavaScript and jQuery -->
  <script src="./assets/js/lib/jquery/jquery.min.js"></script>
  <script src="./assets/js/lib/bootstrap/js/popper.min.js"></script>
  <script src="./assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/jquery.slimscroll.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
  <script src="./assets/js/custom.min.js"></script>

</body>

</html>