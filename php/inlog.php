<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style2.css">

</head>
<body>

 <header>
  <nav>
    <a href="index.php">← Terug</a>
  </nav>
  <h1>Login</h1>
</header>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit">Inloggen</button>
        </form>
    </div>
</body>
</html>