<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$err = ''; $login = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  check_csrf();
  $login = trim($_POST['login'] ?? '');
  $st = db()->prepare('SELECT * FROM users WHERE email = ? OR username = ?');
  $st->execute([$login, $login]); $u = $st->fetch();
  if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['first_name']];
    header('Location: index.php'); exit;
  }
  $err = 'Email or password is incorrect.';
}
$title = 'Login – PawPathRole'; require 'includes/header.php';
?>
<main class="auth">
  <div>
    <h1>WELCOME BACK TO <span>PAWPATHROLE</span></h1>
    <p class="sub">Log back to your Account</p>
    <?php if (isset($_GET['registered'])): ?><p class="ok">Account created. You can log in now.</p><?php endif; ?>
    <?php if ($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <label>Email<input name="login" value="<?= e($login) ?>" required autocomplete="username"></label>
      <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
      <button class="btn">LOGIN</button>
      <a class="alt" href="register.php">CREATE ACCOUNT</a>
    </form>
  </div>
  <img class="photo" src="login.jpg" alt="" onerror="this.removeAttribute('src')">
</main>
<?php require 'includes/footer.php'; ?>
