<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex, nofollow');

function field(string $key): string {
    $value = $_POST[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}

function escapeHtml(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$topics = [
    'habitat' => 'Koalas and habitat',
    'adoption' => 'Adoption questions',
    'website' => 'Website feedback',
];

$errors = [];
$name = field('name');
$email = field('email');
$topic = field('topic');
$message = field('message');
$isPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';

if (!$isPost) {
    http_response_code(405);
    header('Allow: POST');
} else {
    if (preg_match('/\A.{1,100}\z/us', $name) !== 1) {
        $errors[] = 'Enter a name of up to 100 characters.';
    }
    if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if (!isset($topics[$topic])) {
        $errors[] = 'Choose one of the listed topics.';
    }
    if (preg_match('/\A.{1,2000}\z/us', $message) !== 1) {
        $errors[] = 'Enter a message of up to 2,000 characters.';
    }
    if ($errors) {
        http_response_code(422);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contact form response page for the Koala Bear National Information Center.">
  <meta name="author" content="Clay Warren">
  <title>Contact Form Response | Koala Bear National Information Center</title>
  <!-- Clay Warren | WDV101 | Assignments 14-1 and 14-2 | November 25, 2026 -->
  <meta name="robots" content="noindex, nofollow">
  <!-- Google Fonts link method with system fallbacks in styles.css. -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/wdv101/koala_site/styles.css">
  <link rel="stylesheet" href="/wdv101/koala_site/contact.css">
</head>
<body>
  <!-- Assignment 9-1: one fixed-width container for the semantic layout. -->
  <div class="site-container">
  <header id="top">
    <!-- Shared banner and navigation appear on every page. -->
    <h1>Contact Form Response</h1>
    <img src="/wdv101/koala_site/images/koala_banner.jpg" alt="Koala website banner">
  </header>
  <nav aria-label="Main navigation">
    <ul>
      <li><a href="/wdv101/koala_site/home.html">Home</a></li>
      <li><a href="/wdv101/koala_site/about.html">About</a></li>
      <li><a href="/wdv101/koala_site/faq.html">FAQ</a></li>
      <li><a href="/wdv101/koala_site/gallery.html">Gallery</a></li>
      <li><a href="/wdv101/koala_site/adoption.html">Adopt</a></li>
      <li><a href="/wdv101/koala_site/contact.html" aria-current="page">Contact</a></li>
    </ul>
  </nav>
  <main>
    <section class="contact-panel" aria-labelledby="response-title">
      <?php if (!$isPost): ?>
      <h2 id="response-title">Use the contact form</h2>
      <p>Open the contact form to submit a question.</p>
      <?php elseif ($errors): ?>
      <h2 id="response-title">Please check your submission</h2>
      <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= escapeHtml($error) ?></li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
      <h2 id="response-title">Message processed</h2>
      <p>Thanks, <?= escapeHtml($name) ?>. Here’s what the form received.</p>
      <dl class="contact-summary">
        <dt>Email</dt><dd><?= escapeHtml($email) ?></dd>
        <dt>Topic</dt><dd><?= escapeHtml($topics[$topic]) ?></dd>
        <dt>Message</dt><dd class="submitted-message"><?= escapeHtml($message) ?></dd>
      </dl>
      <p class="highlight">This is a coursework demo. Your message was not saved or emailed.</p>
      <?php endif; ?>
      <p><a href="/wdv101/koala_site/contact">Return to the contact form</a></p>
    </section>
  </main>
  <footer>
    <p>Copyright 2018 All rights reserved. Australian Koala Foundation</p>
    <img src="/wdv101/koala_site/images/koala_logo.svg" alt="Australian Koala Foundation logo" width="100">
    <p><a href="#top">Back to top</a></p>
  </footer>
  </div>
</body>
</html>
