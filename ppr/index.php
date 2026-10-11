<?php $title='PawPathRole – Pet Adoption';
require 'includes/header.php';
try { $pets = db()->query("SELECT * FROM pets WHERE status='available' ORDER BY id")->fetchAll(); }
catch (Throwable $ex) { $pets = []; $dberr = true; }
require 'includes/data.php';
try { $stories = db()->query('SELECT * FROM stories ORDER BY id')->fetchAll() ?: $default_stories;
      $feedbacks = db()->query('SELECT * FROM feedbacks ORDER BY id DESC')->fetchAll() ?: $default_feedbacks; }
catch (Throwable $ex) { $stories = $default_stories; $feedbacks = $default_feedbacks; }
?>
<header class="hero">
  <link rel="stylesheet" href="assets/css/style.css">
  <div class="stair">
    <div class="step s1"><span class="w">PAW</span><p class="tag">FIND YOUR FUTURE PAW FRIEND</p></div>
    <div class="step s2"><span class="w">PATH</span><p class="tag">DISCOVER EVERY PET'S STORY</p></div>
    <div class="step s3"><span class="w role">ROLE</span><p class="tag">ARE YOU READY TO BE A FURPARENT?</p></div>
  </div><div class="intro"><div class="card" style="text-align: justify;"><i>PawPathRole is a pet adoption platform that helps connect animals in need with responsible and loving adopters. Our goal is to make pet adoption easier while promoting proper animal care and animal welfare.</i></div>
  <div class="card" style="text-align: justify;"><i>Adopting a pet means committing to provide a safe home, proper care, food, medical attention, and love. Make sure you are ready for the time, responsibility, and needs that come with caring for an animal.</i></div>
  <a class="btn big" href="#pets">🐾 ADOPT NOW!</a></div>
</header>
<section class="yellow" id="pets">
<?php if (!empty($dberr)): ?><div class="card">Database not connected. Import schema.sql and check config.php.</div><?php endif; ?>
<?php foreach ($pets as $i => $p): ?>
  <article class="pet <?= $i % 2 ? 'flip' : '' ?>">
    <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" onerror="this.removeAttribute('src')">
    <div class="card"><h2>MEET <?= e(strtoupper($p['name'])) ?>!</h2>
      <p>AGE: <?= e($p['age']) ?><br>GENDER: <?= e($p['gender']) ?></p>
      <p><b>BACKGROUND STORY:</b><br><?= e($p['story']) ?></p>
      <a class="btn" href="pet.php?id=<?= (int)$p['id'] ?>">VIEW MORE DETAILS</a></div>
  </article>
<?php endforeach; ?>
</section>
<section class="yellow narrow" id="about">
  <div class="card"><h2>ABOUT US</h2>
    <p style="text-align: justify;">PawPathRole was created to provide a simpler and more organized way for people to discover animals that are looking for a home. It was developed in response to the need for an accessible platform where potential adopters can easily view available pets and learn about their background, personality, health, and specific care needs before applying for adoption.</p>
    <p style="text-align: justify;">The purpose of PawPathRole is to make the adoption experience easier and more informative for both adopters and animals. By providing detailed pet profiles, adoption information, and educational resources about responsible pet ownership, the platform helps users make informed decisions.</p></div>
  <div class="card"><h2>MISSION &amp; GOALS:</h2>
    <p style="text-align: justify;">PawPathRole's mission is to make pet adoption easier, responsible, and accessible while helping animals find safe, caring, and suitable homes. We aim to provide potential adopters with reliable information about each animal before adopting.</p>
    <p style="text-align: justify;">Our goal is to promote responsible pet ownership, improve animal welfare, and encourage compassion toward animals in need. We also give animals with disabilities or special needs a better opportunity to find loving and suitable homes.</p></div>
</section>
<section class="yellow" id="advocacies"><h2 class="ctr">ADVOCACIES</h2><div class="three">
  <div class="card" style="text-align: justify;">PawPathRole advocates for responsible pet adoption, animal welfare, and compassionate treatment of animals. We support giving shelter animals a second chance by connecting them with loving families.</div>
  <div class="card" style="text-align: justify;">We speak for animals who can't, because every pet deserves love, safety, and a caring home. Stand against abuse, report cruelty, and be their voice for every paw in need.</div>
  <div class="card" style="text-align: justify;">We also promote proper pet care, awareness of animal health and special needs, and responsible pet ownership to help create a safer and more caring community for animals.</div>
</div></section>
<section class="yellow two" id="policies"><div><h2>POLICIES</h2>
  <p style="text-align: justify;">PawPathRole is committed to maintaining a safe, responsible, and respectful adoption process. Users are expected to provide accurate information when creating an account and submitting an adoption application. Each user may only have one active or pending adoption application at a time. After successfully adopting a pet, a 30-day cooldown period is required before applying for another pet.
    Applications are subject to review, verification, and an interview before adoption approval. All users are also expected to respect the privacy of others, follow website guidelines, and provide proper care for adopted animals. <strong><br> Users may only maintain one active adoption application at a time.</strong>
</p></div>
 
  <div><h2>FAQ</h2>
  <ul><li>How can I adopt a pet?<br>
    <small>Create an account, open a pet's profile, and send an adoption request.</small></li></ul>
    <ul><li>Can I apply for more than one pet?<br>
<small> No. Users can only have one active or pending adoption application at a time.</small></li></ul>
 <ul><li>What happens after I submit my application?<br>
  <small>The application will be reviewed by the administrator. If approved for the next step, you may be scheduled for an interview. You can monitor your application status through your account.</small></li></ul>
  <ul><li>Can I adopt another pet after completing an adoption?<br>
    <small>Yes. However, you must wait for the 30-day cooldown period after successfully adopting a pet before applying for another one.</small></li></ul>
    <ul><li>Are pets with special needs available for adoption?<br>
    <small>Yes. Their profiles provide information about their condition, medical history, and special care requirements so potential adopters can understand their needs before applying.</small></li></ul>
      <ul><li>How will I know if my application has been updated?<br>
      <small>You will receive notifications about important updates, including application status, interview schedules, approval or rejection, and other adoption-related announcements.</small></li></ul>
<ul><li>Can I change my application information?<br>
<small>For changes or corrections to submitted information, contact the PawPathRole administrators for assistance.</small></li></ul>

  </div></section>
<?php require 'includes/extras.php'; require 'includes/footer.php'; ?>
