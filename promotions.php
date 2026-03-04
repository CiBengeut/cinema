<?php
$title = "CINEM4 - Promotions";
$active = "promotions";
include 'partials/head.php';
include 'partials/navbar.php';

include 'data/promotions.php';
$promos = $PROMOS;

$cat = $_GET['cat'] ?? 'All';
if ($cat !== 'All') {
  $promos = array_values(array_filter($promos, fn($p) => ($p['category'] ?? '') === $cat));
}

$tabs = [
  "All" => ["label"=>"All Promotion", "icon"=>""],
  "Movie" => ["label"=>"Movie", "icon"=>"bi-ticket-perforated"],
  "Partner" => ["label"=>"Partner", "icon"=>"bi-credit-card-2-front"],
  "Event" => ["label"=>"Event", "icon"=>"bi-calendar-event"],
  "Member" => ["label"=>"Member", "icon"=>"bi-person-badge"],
];
?>

<div class="container py-5">
  <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
    <div>
      <h1 class="display-4 fw-bold mb-1">Promotions</h1>
      <div class="text-secondary">Promo tiket & event pilihan CINEM4.</div>
    </div>

    <div class="d-flex flex-wrap gap-2">
      <?php foreach($tabs as $key=>$t): ?>
        <a href="promotions.php?cat=<?= urlencode($key) ?>"
           class="btn <?= ($cat===$key?'btn-primary':'btn-outline-primary') ?> rounded-pill px-3 py-2 promo-tab">
          <?php if($t['icon']): ?><i class="bi <?= $t['icon'] ?> me-2"></i><?php endif; ?>
          <?= htmlspecialchars($t['label']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="row g-4">
    <?php foreach($promos as $p): ?>
      <div class="col-12 col-md-6 col-lg-4 reveal d1" id="<?= htmlspecialchars($p['id']) ?>">
        <a class="text-decoration-none" href="<?= htmlspecialchars($p['cta_link'] ?? '#') ?>">
          <div class="promo-card card-glass h-100">
            <div class="promo-thumb" style="background-image:url('<?= htmlspecialchars($p['img']) ?>')"></div>
            <div class="p-3">
              <div class="promo-title fw-bold text-light">
                <?= htmlspecialchars($p['title']) ?>
              </div>
              <div class="promo-valid text-secondary mt-2 small">
                <i class="bi bi-calendar2-week me-2"></i><?= htmlspecialchars($p['valid']) ?>
              </div>
            </div>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'partials/footer.php'; ?>