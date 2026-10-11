<?php $title='Pet details'; require 'includes/header.php';
$st = db()->prepare('SELECT * FROM pets WHERE id=?'); $st->execute([(int)($_GET['id'] ?? 0)]); $p = $st->fetch();
if (!$p) { http_response_code(404); echo '<main class="yellow narrow"><div class="card">Pet not found.</div></main>'; require 'includes/footer.php'; exit; }
$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  check_csrf();
  if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
  db()->prepare('INSERT INTO adoption_requests (pet_id,user_id,message) VALUES (?,?,?)')
      ->execute([$p['id'], $_SESSION['user']['id'], trim($_POST['message'] ?? '')]);
  $msg = 'Request sent! The shelter will contact you.';
}
?>
<main class="yellow"><article class="pet">
  <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">
  <div class="card"><h2><?= e(strtoupper($p['name'])) ?></h2>
  <p>Species: <?= e($p['species']) ?><br>AGE: <?= e($p['age']) ?><br>GENDER: <?= e($p['gender']) ?></p><p><?= e($p['story']) ?></p>
  <?php if ($msg): ?><p><b><?= e($msg) ?></b></p><?php endif; ?>
  <form method="post"><input type="hidden" name="csrf" value="<?= csrf() ?>">
    <textarea name="message" rows="3" placeholder="Tell us why you'd be a great furparent"></textarea>
    <button class="btn">SEND ADOPTION REQUEST</button></form></div>
</article></main>
<?php require 'includes/footer.php'; ?>
