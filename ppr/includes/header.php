<?php require_once __DIR__.'/../config.php'; ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'PawPathRole') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Bangers&family=Raleway:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css?v=<?= time(); ?>">
</head><body>
<nav class="nav"><a class="brand" href="index.php">🐾 PAWPATHROLE<small>PET ADOPTION SERVICES</small></a>
<div class="links"><a href="pets.php">Pets 🐾</a><a href="index.php">Home</a><a href="index.php#advocacies">Community</a>
<details class="acct"><summary>👤</summary><div>
<?php if (!empty($_SESSION['user'])): ?><span>Hi, <?= e($_SESSION['user']['name']) ?></span><a href="logout.php">Logout</a>
<?php else: ?><a href="login.php">Login</a><a href="register.php">Create Account</a><?php endif; ?>
</div></details></div></nav>
