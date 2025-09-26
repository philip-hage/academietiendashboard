<?php
// Set timezone to Amsterdam/Netherlands
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ./public/pages/index.php");
    exit();
}
date_default_timezone_set('Europe/Amsterdam');

$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=academietien", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set MySQL timezone to match PHP timezone
$conn->exec("SET time_zone = '+01:00'"); // CET timezone (winter time)
// Note: For automatic daylight saving time, you might want to use:
// $conn->exec("SET time_zone = '" . date('P') . "'");



$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputEmail = $_POST['userEmail'] ?? '';
    $inputPassword = $_POST['userPassword'] ?? '';

    // First get user by email only
    $sql = "SELECT * FROM teachers WHERE teacherEmail = :userEmail AND teacherIsActive = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userEmail', $inputEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Then verify the password using password_verify()
    if ($user && password_verify($inputPassword, $user['teacherPassword'])) {
        $_SESSION['user_id'] = $user['teacherId'];
        $_SESSION['userEmail'] = $user['teacherEmail'];
        header("Location: ./public/pages/index.php");
        exit();
    } else {
        $error_message = 'Onjuiste email of wachtwoord!';
    }
}


?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Titel</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
</head>


<body>

    <!DOCTYPE html>
    <html lang="nl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Academie Tien</title>
        <link rel="stylesheet" href="./public/css/style.css">
    </head>

    <body>
        <div class="container">
            <!-- Linker gekleurde helft -->
            <div class="left"></div>

            <!-- Rechter login sectie -->
            <div class="right">
                <div class="login-box">
                    <img src="./public/images/academie_tien_logo.jpeg" alt="Academie Tien Logo" class="logo">
                    <h2>Login met je docenten account</h2>
                    <p class="subtitle">Voer je e-mailadres hieronder in om in te loggen op je account</p>

                    <form method="POST" action="">
                        <label for="email">Email</label>
                        <input type="email" name="userEmail" id="email" placeholder="me@example.com">

                        <div class="password-row">
                            <label for="password">Password</label>
                            <a href="./public/pages/forgot_password.php">Wachtwoord vergeten?</a>
                        </div>
                        <input name="userPassword" type="password" id="password">

                        <?php if (!empty($error_message)): ?>
                            <p style="color: red; margin-top: 10px;"><?php echo htmlspecialchars($error_message); ?></p>
                        <?php endif; ?>

                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>


</body>



</html>