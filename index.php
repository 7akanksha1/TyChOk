<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PetPal Market</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      color: white;
    }

    .page-background {
      background-image: url('pet.png');
      background-size: cover;
      background-position: bottom;
      background-repeat: no-repeat;
      min-height: 100vh;
    }

    header {
      background: rgba(0, 0, 0, 0.8);
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: #ffd700;
    }

    nav {
      display: flex;
      gap: 2rem;
      position: relative;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 1rem;
      transition: color 0.3s;
      position: relative;
    }

    nav a:hover {
      color: #ffd700;
    }

    .dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      background: rgba(0, 0, 0, 0.95);
      padding: 1rem;
      border-radius: 5px;
      display: none;
      color: white;
      z-index: 100;
      min-width: 220px;
      white-space: nowrap;
    }

    .dropdown h4 {
      margin-top: 0.5rem;
      font-size: 1rem;
      color: #ffd700;
    }

    .dropdown ul {
      list-style: none;
      padding-left: 0;
    }

    .dropdown ul li {
      padding: 0.3rem 0;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .dropdown ul li:hover {
      color: #ffd700;
      text-decoration: underline;
    }

    .shop-container {
      position: relative;
    }

    .shop-container:hover .dropdown {
      display: block;
    }

    .dropdown a {
      color: white;
      text-decoration: none;
    }

    .dropdown a:hover {
      text-decoration: underline;
    }

    .icons {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .icons i {
      font-size: 1.2rem;
      cursor: pointer;
      transition: color 0.3s;
    }

    .icons i:hover {
      color: #ffd700;
    }

    .hamburger {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        display: none;
        width: 100%;
        margin-top: 1rem;
      }

      nav.show {
        display: flex;
      }

      .hamburger {
        display: block;
        color: white;
      }
    }

    main {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 170px;
      margin-right: 450px;
    }

    .welcome h1 {
      font-size: 3.1rem;
      margin-bottom: 1rem;
    }

    .welcome p {
      font-size: 1.4rem;
    }

    .modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.9);
      padding: 2rem;
      border-radius: 10px;
      color: white;
      display: none;
      z-index: 1000;
      width: 90%;
      max-width: 400px;
    }

    .modal.active {
      display: block;
    }

    .modal input {
      width: 100%;
      padding: 0.5rem;
      margin: 0.5rem 0;
      border: none;
      border-radius: 5px;
    }

    .modal button {
      padding: 0.5rem 1rem;
      background: #ffd700;
      border: none;
      cursor: pointer;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      margin-top: 1rem;
    }

    .modal .switch {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .modal .switch span {
      color: #ffd700;
      cursor: pointer;
      text-decoration: underline;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      font-size: 1.2rem;
    }

.custom-alert {
  display: none;
  position: fixed;
  z-index: 2000;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.6);
}

.custom-alert-box {
  background-color: #fff;
  color: #000;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  margin: 20% auto;
  text-align: center;
  position: relative;
  box-shadow: 0 0 10px rgba(0,0,0,0.4);
}

.custom-close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  color: red;
  cursor: pointer;
}

.custom-alert-box button {
  margin-top: 15px;
  padding: 8px 16px;
  background-color: #ffd700;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.profile-container {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.profile-icon {
  font-size: 1.8rem;
  color: white;
}

.profile-details {
  display: none;
  position: absolute;
  right: 0;
  background-color: #fff;
  color: #000;
  padding: 10px;
  border-radius: 8px;
  min-width: 220px;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  z-index: 1000;
  top: 120%;
}

.profile-container:hover .profile-details {
  display: block;
}

.logout-btn {
  display: block;
  margin-top: 10px;
  color: red;
  text-decoration: none;
}

.logout-btn:hover {
  text-decoration: underline;
}

  </style>
</head>
<body>
<div class="page-background">
  <header>
    <div class="logo">TyChOk</div>
    <div class="hamburger" onclick="toggleMenu()">
      <i class="fas fa-bars"></i>
    </div>
    <nav id="mainNav">
      <a href="#">Home</a>
      <div class="shop-container">
        <a href="product.php">Shop</a>
        <div class="dropdown">
          <h4><a href="#">All Products</a></h4>
          <h4>By Pet Type</h4>
          <ul>
            <li><a href="#">Dogs</a></li>
            <li><a href="#">Cats</a></li>
            <li><a href="#">Birds</a></li>
            <li><a href="#">Others</a></li>
          </ul>
          <h4>By Category</h4>
          <ul>
            <li><a href="#">Food</a></li>
            <li><a href="#">Toys</a></li>
            <li><a href="#">Grooming</a></li>
            <li><a href="#">Health</a></li>
            <li><a href="#">Accessories</a></li>
          </ul>
        </div>
      </div>
      <a href="aboutUs.html">About Us</a>
      <a href="contactUs.php">Contact Us</a>
      
    </nav>
   <div class="icons">
  <i class="fas fa-search" id="searchIcon"></i>
  <i class="fas fa-shopping-cart" onclick="checkLogin('cart.php')"></i>

  <?php if (isset($_SESSION['user'])): ?>
  <div class="profile-container">
    <i class="fas fa-user-circle profile-icon"></i>
    <div class="profile-details">
      <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
    </div>
  </div>
  <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt" style="color: white; font-size: 1.5rem;"></i></a>
<?php else: ?>
  <i class="fas fa-user" id="loginIcon"></i>
<?php endif; ?>

</div>

  </header>

  <main>
    <div class="welcome">
      <h1>Welcome to TyChOk</h1>
      <p>Your one-stop shop for everything your pet needs!</p>
    </div>
  </main>
</div>

<div class="modal" id="searchModal">
  <span class="close-btn" onclick="closeModal('searchModal')">&times;</span>
  <h2>Search Products</h2>
  <input type="text" placeholder="Search for pet food, toys...">
  <button>Search</button>
</div>

<div class="modal" id="loginModal">
  <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
  <h2>Login</h2>
  <form action="login.php" method="POST">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>
  <div class="switch">Don't have an account? <span onclick="switchModal('loginModal','signupModal')">Sign Up</span></div>
</div>

<div class="modal" id="signupModal">
  <span class="close-btn" onclick="closeModal('signupModal')">&times;</span>
  <h2>Sign Up</h2>
  <form action="signup.php" method="POST">
  <input type="text" name="username" placeholder="Username" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Sign Up</button>
</form>
  <div class="switch">Already have an account? <span onclick="switchModal('signupModal','loginModal')">Login</span></div>
</div>

<!-- Custom Alert -->
<div id="customAlert" class="custom-alert">
  <div class="custom-alert-box">
    <span class="custom-close" onclick="closeCustomAlert()">&times;</span>
    <p id="customAlertMessage"></p>
    <button onclick="closeCustomAlert()">OK</button>
  </div>
</div>
<?php
if (isset($_SESSION['alert'])) {
    $msg = json_encode($_SESSION['alert']);
    $redirect = isset($_SESSION['redirect_after_alert']) ? json_encode($_SESSION['redirect_after_alert']) : 'null';
    echo "<script>
      window.onload = function () {
        showCustomAlert($msg, $redirect);
      };
    </script>";
    unset($_SESSION['alert']);
    unset($_SESSION['redirect_after_alert']);
}
?>


<script>
  function openModal(id) {
    document.getElementById(id).classList.add('active');
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('active');
  }

  function switchModal(from, to) {
    closeModal(from);
    openModal(to);
  }

  document.getElementById('searchIcon').addEventListener('click', () => {
    openModal('searchModal');
  });

  document.getElementById('loginIcon').addEventListener('click', () => {
    openModal('loginModal');
  });

  function toggleMenu() {
    document.getElementById('mainNav').classList.toggle('show');
  }

  function checkLogin(redirectPage) {
  fetch('checkLogin.php')
    .then(res => res.text())
    .then(data => {
      if (data === "1") {
        window.location.href = redirectPage;
      } else {
        alert("Please login first.");
      }
    });
}

function showCustomAlert(message, redirect = null) {
    document.getElementById("customAlertMessage").innerText = message;
    document.getElementById("customAlert").style.display = "block";
    window.customAlertRedirect = redirect;
}

function closeCustomAlert() {
    document.getElementById("customAlert").style.display = "none";
    if (window.customAlertRedirect) {
        window.location.href = window.customAlertRedirect;
    }
}

</script>
</body>
</html>
