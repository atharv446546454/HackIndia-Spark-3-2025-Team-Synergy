<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petstore";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT CustomerID, email, password FROM customer WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['CustomerID'] = $row['CustomerID'];
        header("Location: index.html"); // Redirect to dashboard or home page
        exit();
    } else {
        $error = "Invalid email or password";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login to Fudge - Pet Lovers Community</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Inter", sans-serif;
        background-color: #fef6f3;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #333;
      }

      .wrapper {
        max-width: 1000px;
        width: 100%;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        display: flex;
        overflow: hidden;
      }

      .quote-wrapper {
        flex: 1;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
          url("./assets/images/loginpogo.jpeg") center/cover;
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
      }

      .quote-content {
        text-align: center;
        max-width: 320px;
      }

      blockquote {
        font-family: "Pacifico", cursive;
        font-size: 1.75rem;
        line-height: 1.4;
        margin-bottom: 1rem;
        position: relative;
      }

      .author {
        font-family: "Inter", sans-serif;
        font-size: 0.9rem;
        opacity: 0.9;
      }

      .form-wrapper {
        flex: 1;
        padding: 40px;
        background: white;
      }

      .form-title {
        font-family: "Pacifico", cursive;
        color: #ff6b4a;
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
        text-align: center;
      }

      .form-subtitle {
        color: #666;
        text-align: center;
        margin-bottom: 2rem;
      }

      .form-group {
        margin-bottom: 1.5rem;
      }

      label {
        display: block;
        margin-bottom: 0.5rem;
        color: #444;
        font-size: 0.9rem;
        font-weight: 500;
      }

      input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e1e1e1;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s;
      }

      input:focus {
        outline: none;
        border-color: #ff6b4a;
        box-shadow: 0 0 0 3px rgba(255, 107, 74, 0.1);
      }

      .name-group {
        display: flex;
        gap: 1rem;
      }

      .terms-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1.5rem 0;
      }

      .terms-group input[type="checkbox"] {
        width: auto;
        margin-right: 8px;
      }

      .terms-group label {
        margin: 0;
        font-size: 0.85rem;
        color: #666;
      }

      .terms-group a {
        color: #ff6b4a;
        text-decoration: none;
      }

      .submit-btn {
        width: 100%;
        padding: 14px;
        background: #ff6b4a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
      }

      .submit-btn:hover {
        background: #ff5436;
      }

      .login-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: #666;
      }

      .login-link a {
        color: #ff6b4a;
        text-decoration: none;
        font-weight: 500;
      }

      @media (max-width: 768px) {
        .wrapper {
          flex-direction: column;
          margin: 20px;
        }

        .quote-wrapper {
          padding: 60px 20px;
        }

        .form-wrapper {
          padding: 30px 20px;
        }

        .name-group {
          gap: 1rem;
        }
      }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="quote-wrapper">
            <div class="quote-content">
                <blockquote>
                    "The love of a dog is a pure thing. He gives you a trust which is total. You must not betray it."
                </blockquote>
                <p class="author">- Michel Houellebecq</p>
            </div>
        </div>

        <div class="form-wrapper">
            <h1 class="form-title">Welcome Back</h1>
            <p class="form-subtitle">Log in to your Fudge account</p>

            <?php if ($error): ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <button type="submit" class="submit-btn">Log in</button>
            </form>

            <p class="login-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>
