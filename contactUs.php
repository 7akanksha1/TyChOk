<?php
session_start();
require 'db.php'; // Connects to your tychokdb

$showLoginAlert = false;
$submissionSuccess = false;
$error = '';

// Check login
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
    $showLoginAlert = true;
} else {
    $sessionEmail = $_SESSION['user']['email'];
    $sessionUsername = $_SESSION['user']['username'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formEmail = $_POST['email'] ?? '';
        $formName = $_POST['name'] ?? '';
        $formMessage = trim($_POST['message'] ?? '');

        if ($formEmail !== $sessionEmail) {
            $error = 'Please use the email you logged in with.';
        } elseif (empty($formMessage)) {
            $error = 'Message cannot be empty.';
        } else {
            // Save to DB
            $stmt = $conn->prepare("INSERT INTO tychok_contactUs (username, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $formName, $formEmail, $formMessage);
            $stmt->execute();
            $stmt->close();

            // Email admin
            $to = "singhakanksha7123@gmail.com"; // change to your real admin email
            $subject = "New Contact Message from $formName";
            $body = "Name: $formName\nEmail: $formEmail\n\nMessage:\n$formMessage";
            $headers = "From: no-reply@petpalmarket.com";

            mail($to, $subject, $body, $headers);

            $submissionSuccess = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - PetPal Market</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('contact.png');
      background-size: cover;
      background-position: bottom;
      background-repeat: no-repeat;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .contact-container {
      max-width: 450px;
      width: 90%;
      background: rgba(0, 0, 0, 0.6);
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.4);
      animation: fadeIn 1s ease-in-out;
    }

    .contact-container h2 {
      margin-bottom: 1rem;
      color: #ffd700;
      text-align: center;
    }

    .form-group { margin-bottom: 1rem; }

    .form-group label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: bold;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 0.5rem;
      border: none;
      border-radius: 5px;
      font-size: 0.9rem;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: 2px solid #ffd700;
    }

    input[readonly] {
      background-color: #e0e0e0;
      color: #555;
      cursor: not-allowed;
    }

    button {
      width: 100%;
      padding: 0.6rem;
      background-color: #ffd700;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      font-size: 1rem;
      color: black;
    }

    button:hover { background-color: #e6c200; }

    .confirmation, .error-message {
      margin-top: 1rem;
      text-align: center;
      font-weight: bold;
    }

    .confirmation { color: lightgreen; }
    .error-message { color: #ff4f4f; }

    .social-media {
      text-align: center;
      margin-top: 1.5rem;
    }

    .social-media a {
      color: white;
      margin: 0 0.8rem;
      font-size: 1.3rem;
      transition: color 0.3s;
    }

    .social-media a:hover { color: #ffd700; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .custom-alert {
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #222;
      color: #ffd700;
      padding: 20px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #000;
      font-family: sans-serif;
      z-index: 9999;
      animation: popIn 0.4s ease-out;
    }

    @keyframes popIn {
      from { transform: translate(-50%, -60%) scale(0.8); opacity: 0; }
      to { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }
  </style>
</head>
<body>
<?php if ($showLoginAlert): ?>
  <div class="custom-alert" id="loginAlert">Please login first</div>
  <script>
    setTimeout(function () {
      window.location.href = 'index.php';
    }, 2000);
  </script>
<?php else: ?>
  <div class="contact-container">
    <h2>Contact Us</h2>

    <?php if ($submissionSuccess): ?>
      <p class="confirmation">Thank you for contacting us! We'll get back to you soon.</p>
    <?php else: ?>
      <?php if ($error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
      <form id="contactForm" method="POST" action="">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($sessionUsername) ?>" required readonly>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($sessionEmail) ?>" required readonly>
          <input type="hidden" id="sessionEmail" value="<?= htmlspecialchars($sessionEmail) ?>">
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="3" required></textarea>
        </div>

        <button type="submit">Send Message</button>
      </form>
    <?php endif; ?>

    <div class="social-media">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>
  </div>
<?php endif; ?>

<script>
  // Optional client-side email match check
  document.getElementById("contactForm")?.addEventListener("submit", function (e) {
    const entered = document.getElementById("email").value.trim();
    const expected = document.getElementById("sessionEmail").value.trim();

    if (entered !== expected) {
      e.preventDefault();
      showCustomAlert("Please use your logged-in email address.");
    }
  });

  function showCustomAlert(message) {
    const alertBox = document.createElement("div");
    alertBox.classList.add("custom-alert");
    alertBox.textContent = message;
    document.body.appendChild(alertBox);
    setTimeout(() => alertBox.remove(), 2500);
  }
</script>
</body>
</html>
