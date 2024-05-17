<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header('Location: /index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM user WHERE email=:email AND password=:password";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user && $user['isActive']) {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user['id'];
        $_SESSION['isLoggedIn'] = true;
        session_regenerate_id(true);

        header("Location: /index.php");
        exit;
    } else {
        $error = "Identifiants incorrects !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Connexion</title>
</head>
<body>
<!-- Login Form -->
<div class="login_form">
        <form method="POST">
            <h2 >Login</h2>
            
                <label for="email" >Email</label>
                <input type="email" id="email" name="email" required >
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required >
            <?php if (!empty($error)) : ?>
                <p><?= $error; ?></p>
            <?php endif; ?>
                <button type="submit">
                    Login
                </button>
            
        </form>
    </div>

</body>