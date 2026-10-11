<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$err = []; $v = ['last' => '', 'first' => '', 'user' => '', 'email' => '', 'phone' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  check_csrf();
  foreach ($v as $k => $_) $v[$k] = trim($_POST[$k] ?? '');
  $pw = $_POST['password'] ?? '';
  if ($v['last'] === '' || $v['first'] === '') $err[] = 'Please enter your first and last name.';
  if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $v['user'])) $err[] = 'Username must be 3-30 letters, numbers or underscores.';
  if (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) $err[] = 'Please enter a valid email.';
  if (!preg_match('/^\+?[0-9 ]{7,16}$/', $v['phone'])) $err[] = 'Please enter a valid phone number.';
  if (strlen($pw) < 8) $err[] = 'Password must be at least 8 characters.';
  if (empty($_POST['agree'])) $err[] = 'You must agree to the Terms and Policies.';
  if (!$err) {
    try {
      db()->prepare('INSERT INTO users (first_name,last_name,username,email,phone,password_hash) VALUES (?,?,?,?,?,?)')
        ->execute([$v['first'], $v['last'], $v['user'], $v['email'], $v['phone'], password_hash($pw, PASSWORD_DEFAULT)]);
      header('Location: login.php?registered=1'); exit;
    } catch (PDOException $x) { $err[] = 'That email or username is already registered.'; }
  }
}
$title = 'Create Account – PawPathRole'; require 'includes/header.php';
?>
<main class="auth">
  <div>
    <h1>WELCOME TO <span>PAWPATHROLE</span></h1>
    <p class="sub">Create Account</p>
    <?php foreach ($err as $m): ?><p class="err"><?= e($m) ?></p><?php endforeach; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <div class="row2">
        <label>Last Name<input name="last" value="<?= e($v['last']) ?>" required></label>
        <label>First Name<input name="first" value="<?= e($v['first']) ?>" required></label>
      </div>
      <label>Username<input name="user" value="<?= e($v['user']) ?>" required></label>
      <label>Email<input type="email" name="email" value="<?= e($v['email']) ?>" required></label>
      <label>Phone Number<input type="tel" name="phone" value="<?= e($v['phone']) ?>" placeholder="+63 9XXXXXXXXX" required></label>
      <label>Password<input type="password" name="password" minlength="8" required autocomplete="new-password"></label>
      <label class="agree"><input type="checkbox" name="agree" value="1" required> I agree to the PawPathRole Terms and Policies.</label>
      <button class="btn">SIGN UP</button>
      <a class="alt" href="login.php">ALREADY HAVE AN ACCOUNT? LOGIN</a>
    </form>
  </div>
  <img class="photo" src="signup.jpg" alt="" onerror="this.removeAttribute('src')">
</main>
<?php require 'includes/footer.php'; ?>
