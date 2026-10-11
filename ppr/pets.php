<?php
require 'config.php';
$q = trim($_GET['q'] ?? '');
$sp = array_intersect((array)($_GET['species'] ?? []), ['dog','cat','rabbit']);
$sz = array_intersect((array)($_GET['size'] ?? []), ['small','medium','large']);
$gd = array_intersect((array)($_GET['gender'] ?? []), ['Male','Female']);
$ag = array_intersect((array)($_GET['age'] ?? []), ['1-5','5-10','10+']);
$where = ["status='available'"]; $args = [];
if ($q !== '') { $where[] = '(name LIKE ? OR species LIKE ?)'; $args[] = "%$q%"; $args[] = "%$q%"; }
foreach (['species' => $sp, 'size' => $sz, 'gender' => $gd] as $col => $vals)
  if ($vals) { $where[] = "$col IN (" . implode(',', array_fill(0, count($vals), '?')) . ')'; array_push($args, ...array_values($vals)); }
$ranges = ['1-5' => 'age_years>=1 AND age_years<5', '5-10' => 'age_years>=5 AND age_years<10', '10+' => 'age_years>=10'];
if ($ag) $where[] = '(' . implode(' OR ', array_map(fn($a) => $ranges[$a], $ag)) . ')';
try { $st = db()->prepare('SELECT * FROM pets WHERE ' . implode(' AND ', $where) . ' ORDER BY id'); $st->execute($args); $pets = $st->fetchAll(); }
catch (Throwable $x) { $pets = []; $dberr = true; }
$chk = fn($n, $v) => in_array($v, (array)($_GET[$n] ?? []), true) ? 'checked' : '';
$title = 'Pets – PawPathRole'; require 'includes/header.php';
?>
<main class="browse">
  <h2 class="pagehead">WHY WE RECOMMEND ADOPTING?</h2>
  <p>Adoption is more than simply bringing a pet home, it is an opportunity to change a life. When you adopt through PawPathRole, you give a deserving animal a second chance to experience love, safety, and the comfort of a forever home, while also making room for other animals in need.</p>
  <p>Many pets are waiting in shelters or rescue centers because they have been abandoned, lost, or simply had nowhere else to go. By choosing adoption instead of buying a pet, you help provide these animals with a brighter future and become part of a community working toward giving every pet the loving home they deserve.</p>
  <div class="toolbar">
    <form method="get" id="ff"><div class="sbar">
      <details><summary>Filter ▾</summary><div class="fpanel">
        <div><h4>Species</h4>
          <label><input type="checkbox" name="species[]" value="dog" <?= $chk('species','dog') ?>>Dogs</label>
          <label><input type="checkbox" name="species[]" value="cat" <?= $chk('species','cat') ?>>Cats</label>
          <label><input type="checkbox" name="species[]" value="rabbit" <?= $chk('species','rabbit') ?>>Rabbits</label></div>
        <div><h4>Age</h4>
          <label><input type="checkbox" name="age[]" value="1-5" <?= $chk('age','1-5') ?>>1 to 5 years old</label>
          <label><input type="checkbox" name="age[]" value="5-10" <?= $chk('age','5-10') ?>>5 to 10 years old</label>
          <label><input type="checkbox" name="age[]" value="10+" <?= $chk('age','10+') ?>>10+ years old</label></div>
        <div><h4>Size</h4>
          <label><input type="checkbox" name="size[]" value="small" <?= $chk('size','small') ?>>Small</label>
          <label><input type="checkbox" name="size[]" value="medium" <?= $chk('size','medium') ?>>Medium</label>
          <label><input type="checkbox" name="size[]" value="large" <?= $chk('size','large') ?>>Large</label></div>
        <div><h4>Gender</h4>
          <label><input type="checkbox" name="gender[]" value="Male" <?= $chk('gender','Male') ?>>Male</label>
          <label><input type="checkbox" name="gender[]" value="Female" <?= $chk('gender','Female') ?>>Female</label></div>
        <button class="btn" style="grid-column:1/-1;justify-self:start;font-size:.9rem;padding:3px 12px">APPLY</button>
        <a href="pets.php" title="Reset">⟳ Reset</a>
      </div></details>
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search Pets">
    </div></form>
    <a class="btn" href="#">PET PICKER 🐾</a>
  </div>
  <div class="pgrid">
  <?php if (!empty($dberr)): ?><div class="card empty">Database not connected. Import schema.sql and check config.php.</div><?php endif; ?>
  <?php foreach ($pets as $p): ?>
    <article class="pcard"><img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" onerror="this.removeAttribute('src')">
      <div>Name: <?= e($p['name']) ?><br>Species: <?= e(ucfirst($p['species'])) ?>
      <a class="btn" href="pet.php?id=<?= (int)$p['id'] ?>">VIEW PET PROFILE</a></div></article>
  <?php endforeach; ?>
  <?php if (!$pets && empty($dberr)): ?><div class="card empty">No pets match your filters.</div><?php endif; ?>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
