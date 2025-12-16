<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - HomEase</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #F6F5ED;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 35px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #FF6600;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #FF6600;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #e05a00;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">Invalid Email or Password</div>
    <?php endif; ?>

    <form method="POST" action="admin_login_action.php">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>