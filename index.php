<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .checkbox {
      display: flex;
      align-items: center;
      margin-top: 5px;
    }

    .checkbox input {
      margin-right: 5px;
    }

    .actions {
      display: flex;
      justify-content: space-between;
      font-size: 0.9em;
      margin-top: 10px;
    }

    .actions a {
      color: #007bff;
      text-decoration: none;
      cursor: pointer;
    }

    .actions a:hover {
      text-decoration: underline;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1em;
      margin-top: 15px;
    }

    button:hover {
      background: #0056b3;
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Login Form -->
    <div id="loginForm">
      <h2>Library Login</h2>
      <div class="form-group">
        <label for="loginUser">Username or Email</label>
        <input type="text" id="loginUser" />
      </div>
      <div class="form-group">
        <label for="loginPass">Password</label>
        <input type="password" id="loginPass" />
        <div class="checkbox">
          <input type="checkbox" id="showPassword" onclick="togglePassword()" />
          <label for="showPassword">Show Password</label>
        </div>
      </div>
      <div class="actions">
        <a onclick="showForgot()">Forgot Password?</a>
        <a onclick="showRegister()">Register</a>
      </div>
      <button onclick="login()">Login</button>
    </div>

    <!-- Register Form (POSTs to register.php) -->
    <form id="registerForm" class="hidden" method="post" action="register.php">
      <h2>Register</h2>

      <div class="form-group">
        <label for="name">Username</label>
        <input type="text" name="name" id="name" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required />
      </div>

      <div class="actions">
        <a onclick="showLogin()">Back to Login</a>
      </div>

      <button type="submit">Create Account</button>
    </form>

    <!-- Forgot Password Form -->
    <div id="forgotForm" class="hidden">
      <h2>Recover Password</h2>
      <div class="form-group">
        <label for="forgotEmail">Enter your email</label>
        <input type="email" id="forgotEmail" />
      </div>
      <div class="actions">
        <a onclick="showLogin()">Back to Login</a>
      </div>
      <button onclick="recover()">Send Reset Link</button>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("loginPass");
      passwordField.type = passwordField.type === "password" ? "text" : "password";
    }

    function showLogin() {
      document.getElementById("loginForm").classList.remove("hidden");
      document.getElementById("registerForm").classList.add("hidden");
      document.getElementById("forgotForm").classList.add("hidden");
    }

    function showRegister() {
      document.getElementById("loginForm").classList.add("hidden");
      document.getElementById("registerForm").classList.remove("hidden");
      document.getElementById("forgotForm").classList.add("hidden");
    }

    function showForgot() {
      document.getElementById("loginForm").classList.add("hidden");
      document.getElementById("registerForm").classList.add("hidden");
      document.getElementById("forgotForm").classList.remove("hidden");
    }

    function login() {
      const user = document.getElementById("loginUser").value;
      const pass = document.getElementById("loginPass").value;
      alert(`Logged in as ${user}`);
    }

    function recover() {
      const email = document.getElementById("forgotEmail").value;
      alert(`Password reset link sent to ${email}`);
      showLogin();
    }
  </script>
</body>
</html>
