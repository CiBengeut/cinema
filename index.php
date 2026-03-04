<?php
$title = "CINEM4 - Home";
$active = "home";
include 'partials/head.php';
include 'partials/navbar.php';

include 'data/movies.php';
include 'data/promotions.php';

/* contoh film hits (banner) - kamu ganti img sesuai punya kamu */
$HERO_FILMS = [
  [
    "type" => "film",
    "title" => "PANDA PLAN",
    "meta"  => "FAMILY • 1h 35m",
    "img"   => "assets/img/banner-panda.WEBP",
    "cta1"  => "Book Now",
    "cta2"  => "Details",
    "link1" => "booking.php?slug=panda-plan",
    "link2" => "movie-detail.php?slug=panda-plan",
  ],
  [
    "type" => "film",
    "title" => "SCREAM",
    "meta"  => "HORROR • 1h 50m",
    "img"   => "assets/img/banner-scream.jpg",
    "cta1"  => "Book Now",
    "cta2"  => "Details",
    "link1" => "booking.php?slug=scream",
    "link2" => "movie-detail.php?slug=scream",
  ],
];

/* promo hero (ambil sebagian) */
$HERO_PROMOS = array_values(array_filter($PROMOS, fn($p) => !empty($p['hero'])));
$HERO_PROMOS = array_slice($HERO_PROMOS, 0, 2);

/* konversi promo jadi slide hero */
foreach ($HERO_PROMOS as $p) {
  $HERO_FILMS[] = [
    "type" => "promo",
    "title" => $p["title"],
    "meta"  => strtoupper($p["category"]) . " • " . $p["valid"],
    "img"   => $p["img"],
    "cta1"  => "See Promo",
    "cta2"  => "All Promotions",
    "link1" => $p["cta_link"],
    "link2" => "promotions.php",
  ];
}

/* batasi total slide hero */
$heroSlides = array_slice($HERO_FILMS, 0, 4);

$featuredNow = array_values(array_filter(
  $MOVIES,
  fn($m) => (($m['status'] ?? 'now') === 'now') && (($m['featured'] ?? false) === true)
));

$featuredUp = array_values(array_filter(
  $MOVIES,
  fn($m) => (($m['status'] ?? '') === 'upcoming') && (($m['featured'] ?? false) === true)
));
?>

<!-- HERO -->
<section class="hero">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <?php foreach ($heroSlides as $i => $s): ?>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></button>
      <?php endforeach; ?>
    </div>

    <div class="carousel-inner">
      <?php foreach ($heroSlides as $i => $s): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>" style="background-image:url('<?= $s['img'] ?>')">
          <div class="hero-overlay"></div>
          <div class="container hero-content">
            <div class="row">
              <div class="col-lg-7">
                <div class="text-uppercase text-secondary small mb-2"><?= htmlspecialchars($s['meta']) ?></div>
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($s['title']) ?></h1>
                <div class="d-flex gap-2 flex-wrap">
                  <a href="<?= htmlspecialchars($s['link1'] ?? 'movies.php') ?>" class="btn btn-primary btn-lg rounded-pill px-4">
                    <?= htmlspecialchars($s['cta1']) ?>
                  </a>
                  <a href="<?= htmlspecialchars($s['link2'] ?? '#') ?>" class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <?= htmlspecialchars($s['cta2']) ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<!-- SEARCH BAR (besar seperti contoh) -->
<section class="hero-search">
  <div class="container">
    <div class="card-glass p-3 p-md-4">
      <form class="row g-2 align-items-center" action="movies.php" method="get">
        <div class="col-12 col-md">
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-transparent text-secondary border-secondary">
              <i class="bi bi-search"></i>
            </span>
            <input class="form-control bg-transparent text-light border-secondary"
              name="q" placeholder="Search Movie, Cinema, City...">
          </div>
        </div>
        <div class="col-12 col-md-auto d-grid">
          <button class="btn btn-primary btn-lg rounded-3 px-4" type="submit">
            <i class="bi bi-arrow-right-circle"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- CHOOSE YOUR MOVIE -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-4 reveal">
      <h2 class="section-title display-6 mb-2">Choose Your Movie</h2>
      <div class="text-secondary">Now Showing & Upcoming (mock data)</div>
    </div>

    <!-- Tabs -->
    <ul class="nav justify-content-center gap-2 tab-soft mb-4" id="movieTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabNow" type="button">Now Showing</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabUp" type="button">Upcoming</button>
      </li>
    </ul>

    <div class="tab-content">
      <!-- NOW SHOWING -->
      <div class="tab-pane fade show active" id="tabNow">
        <?php include 'partials/_poster_carousel.php'; ?>
        <?php if (count($featuredNow) === 0): ?>
          <div class="text-center text-secondary py-4">Belum ada film featured.</div>
        <?php else: ?>
          <?php renderPosterCarousel("nowCarousel", $featuredNow, "now"); ?>
        <?php endif; ?>
      </div>

      <!-- UPCOMING -->
      <div class="tab-pane fade" id="tabUp">
        <?php renderPosterCarousel("upcomingCarousel", $featuredUp, "upcoming"); ?>
      </div>
    </div>
  </div>
</section>

<?php
$promoFeatured = array_values(array_filter($PROMOS, fn($p) => !empty($p['featured'])));
$promoFeatured = array_slice($promoFeatured, 0, 6);
?>

<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
      <div>
        <h3 class="section-title mb-1">Featured Promotions</h3>
        <div class="text-secondary">Promo pilihan minggu ini.</div>
      </div>
      <a class="btn btn-outline-light border-secondary rounded-pill" href="promotions.php">View all</a>
    </div>

    <div class="row g-3">
      <?php foreach ($promoFeatured as $p): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <a class="text-decoration-none" href="<?= htmlspecialchars($p['cta_link']) ?>">
            <div class="promo-card card-glass h-100">
              <div class="promo-thumb" style="background-image:url('<?= htmlspecialchars($p['img']) ?>')"></div>
              <div class="p-3">
                <div class="fw-bold text-light"><?= htmlspecialchars($p['title']) ?></div>
                <div class="text-secondary small mt-1"><?= htmlspecialchars($p['valid']) ?></div>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>