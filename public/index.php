<?php
session_start();
require_once __DIR__ . "/../config/db.php";

// Fonction pour créer un nouveau message
function createMessage($message)
{
    global $pdo;

    $query = "INSERT INTO messages (message) VALUES (:message)";
    $statement = $pdo->prepare($query);
    $statement->execute(['message' => $message]);
}

// Fonction pour récupérer tous les messages
function getAllMessages()
{
    global $pdo;

    $query = "SELECT * FROM messages ORDER BY created_at DESC";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour supprimer un message par son ID
function deleteMessage($id)
{
    global $pdo;

    $query = "DELETE FROM messages WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $id]);
}

// Si le formulaire est soumis pour créer un nouveau message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $message = $_POST["message"];
    createMessage($message);
    header("Location: index.php"); // Redirection pour éviter de renvoyer le formulaire après la soumission
    exit();
}

// Si une requête DELETE est envoyée pour supprimer un message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_message"])) {
    $id = $_POST["delete_message"];
    deleteMessage($id);
    header("Location: index.php"); // Redirection après la suppression
    exit();
}

$messages = getAllMessages();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
<!-- Header -->
<header>
    <div >
        <nav>
            <ul >
                <?php if (empty($_SESSION['isLoggedIn'])): ?>
                    <li><a href="/../security/login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="/../security/logout.php">Logout</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</header>    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat Room</h2>
        </div>
        <div class="chat-messages" id="chat-messages">
            <?php foreach ($messages as $message) : ?>
                <div class="message">
                    <span><?php echo htmlspecialchars($message['message']); ?></span>
                    <form method="post" class="delete-form">
                        <input type="hidden" name="delete_message" value="<?php echo $message['id']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-input">
            <!-- Le formulaire pour envoyer des messages doit se trouver ci-dessous -->
            <form method="post" action="index.php">
                <input type="text" name="message" placeholder="Entrez votre message ici" required>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>

</html>