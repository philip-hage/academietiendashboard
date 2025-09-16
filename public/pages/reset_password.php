<?php
session_start();
require_once '../../config/database.php';

$message = '';
$message_type = '';
$token = $_GET['token'] ?? '';
$valid_token = false;

// Check if token is valid and not expired
if (!empty($token)) {
    $sql = "SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $reset_request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset_request) {
        $valid_token = true;
    } else {
        $message = "Deze reset link is ongeldig of verlopen.";
        $message_type = "error";
    }
} else {
    $message = "Geen geldige reset token gevonden.";
    $message_type = "error";
}

// Handle password reset form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_token) {
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_password) || empty($confirm_password)) {
        $message = "Alle velden zijn verplicht.";
        $message_type = "error";
    } elseif (strlen($new_password) < 6) {
        $message = "Wachtwoord moet minimaal 6 karakters lang zijn.";
        $message_type = "error";
    } elseif ($new_password !== $confirm_password) {
        $message = "Wachtwoorden komen niet overeen.";
        $message_type = "error";
    } else {
        try {
            // Hash the new password (recommended for production)
            // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in database (using plain text for now to match your current system)
            $sql = "UPDATE teachers SET teacherPassword = :password WHERE teacherEmail = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':password', $new_password);
            $stmt->bindParam(':email', $reset_request['email']);
            $stmt->execute();

            // Delete the used token
            $sql = "DELETE FROM password_resets WHERE token = :token";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            $message = "Je wachtwoord is succesvol gewijzigd! Je kunt nu inloggen.";
            $message_type = "success";
            $valid_token = false; // Hide the form

        } catch (PDOException $e) {
            $message = "Er is een fout opgetreden. Probeer het later opnieuw.";
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Resetten - Academie Tien</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .message {
            margin: 15px 0;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Linker gekleurde helft -->
        <div class="left"></div>

        <!-- Rechter reset password sectie -->
        <div class="right">
            <div class="login-box">
                <img src="../images/academie_tien_logo.jpeg" alt="Academie Tien Logo" class="logo">
                <h2>🔒 Nieuw Wachtwoord</h2>
                <p class="subtitle">Voer je nieuwe wachtwoord hieronder in</p>

                <?php if (!empty($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($valid_token): ?>
                    <form method="POST" action="">
                        <label for="password">Nieuw Wachtwoord</label>
                        <input type="password" id="password" name="password" required>
                        <div class="password-requirements">Minimaal 6 karakters</div>

                        <label for="confirm_password">Bevestig Wachtwoord</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>

                        <button type="submit">Wachtwoord Wijzigen</button>
                    </form>
                <?php endif; ?>

                <div class="back-link">
                    <a href="../../index.php">← Terug naar Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>