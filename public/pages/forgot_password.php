<?php
session_start();
require_once '../../config/database.php';
require_once '../../config/email.php';
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    if (!empty($email)) {
        // Check if email exists in database
        $sql = "SELECT * FROM teachers WHERE teacherEmail = :email AND teacherIsActive = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate unique reset token
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store token in database (you'll need to create this table)
            try {
                $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at) 
                        ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':expires_at', $expires_at);
                $stmt->execute();

                // Create reset link
                $reset_link = RESET_LINK_DOMAIN . "/public/pages/reset_password.php?token=" . $token;

                // Initialize PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    if (MAIL_METHOD === 'mailhog') {
                        // MailHog configuratie (lokale ontwikkeling)
                        $mail->isSMTP();
                        $mail->Host = MAILHOG_HOST;
                        $mail->Port = MAILHOG_PORT;
                        $mail->SMTPAuth = false;
                    } else {
                        // Gmail SMTP configuratie
                        $mail->isSMTP();
                        $mail->Host = GMAIL_HOST;
                        $mail->SMTPAuth = true;
                        $mail->Username = GMAIL_USERNAME;
                        $mail->Password = GMAIL_PASSWORD;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = GMAIL_PORT;
                    }

                    // Recipients
                    $mail->setFrom(GMAIL_FROM_EMAIL, GMAIL_FROM_NAME);
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Wachtwoord Reset - Academie Tien';
                    $mail->Body = "
                    <html>
                    <head>
                        <title>Wachtwoord Reset</title>
                    </head>
                    <body style='font-family: Arial, sans-serif;'>
                        <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                            <h2 style='color: #333;'>🔒 Wachtwoord Reset Verzoek</h2>
                            <p>Hallo,</p>
                            <p>Je hebt een verzoek ingediend om je wachtwoord te resetten voor je Academie Tien account.</p>
                            <p>Klik op de onderstaande knop om je wachtwoord te resetten:</p>
                            <div style='text-align: center; margin: 30px 0;'>
                                <a href='$reset_link' style='background-color: #4CAF50; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;'>Reset Wachtwoord</a>
                            </div>
                            <p><strong>Deze link is geldig voor 1 uur.</strong></p>
                            <p>Als je dit verzoek niet hebt ingediend, kun je deze email negeren.</p>
                            <hr style='margin: 30px 0; border: 1px solid #eee;'>
                            <p style='color: #666; font-size: 12px;'>
                                Als de knop niet werkt, kopieer en plak deze link in je browser:<br>
                                <a href='$reset_link'>$reset_link</a>
                            </p>
                            <p style='color: #666;'>Met vriendelijke groet,<br><strong>Academie Tien</strong></p>
                        </div>
                    </body>
                    </html>";

                    $mail->send();
                    $message = "Een reset link is verstuurd naar je email adres.";
                    $message_type = "success";
                } catch (Exception $e) {
                    $message = "Er is een fout opgetreden bij het versturen van de email: " . $mail->ErrorInfo;
                    $message_type = "error";
                }
            } catch (PDOException $e) {
                $message = "Er is een fout opgetreden. Probeer het later opnieuw.";
                $message_type = "error";
            }
        } else {
            // Don't reveal if email exists or not for security
            $message = "Als dit email adres bestaat, is er een reset link verstuurd.";
            $message_type = "success";
        }
    } else {
        $message = "Voer een geldig email adres in.";
        $message_type = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Vergeten - Academie Tien</title>
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Linker gekleurde helft -->
        <div class="left"></div>

        <!-- Rechter forgot password sectie -->
        <div class="right">
            <div class="login-box">
                <img src="../images/academie_tien_logo.jpeg" alt="Academie Tien Logo" class="logo">
                <h2>⚡ Wachtwoord Vergeten?</h2>
                <p class="subtitle">Voer je e-mailadres hieronder in om een reset link te ontvangen</p>

                <?php if (!empty($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <label for="email">Email Adres</label>
                    <input type="email" id="email" name="email" placeholder="je-email@example.com" required>

                    <button type="submit">Reset Link Versturen</button>
                </form>

                <div class="back-link">
                    <a href="../../index.php">← Terug naar Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>