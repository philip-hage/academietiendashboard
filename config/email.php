<?php
// Email configuration for forgot password functionality

// Optie 2: Gmail SMTP (voor productie-achtige testing)
// Zorg dat je een App Password hebt aangemaakt in je Google account
define('MAIL_METHOD', 'gmail'); // Nu ingesteld op Gmail

// MailHog instellingen
define('MAILHOG_HOST', 'localhost');
define('MAILHOG_PORT', 1025);

// Gmail SMTP instellingen (voor productie)
// Je moet een App Password aanmaken in je Google account
define('GMAIL_HOST', 'smtp.gmail.com');
define('GMAIL_PORT', 587);
define('GMAIL_USERNAME', 'academietienofficial@gmail.com'); // ← VERVANG DIT met je echte Gmail adres
define('GMAIL_PASSWORD', 'qrfb npxn lnao yghh');    // ← VERVANG DIT met je 16-karakter App Password
define('GMAIL_FROM_EMAIL', 'academietienofficial@gmail.com'); // ← Gebruik hetzelfde Gmail adres
define('GMAIL_FROM_NAME', 'Academie Tien');

// Algemene email instellingen
define('RESET_LINK_DOMAIN', 'http://academietien.nl'); // Aanpassen voor productie
