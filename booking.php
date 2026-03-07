<?php
session_start();

$title = "CINEM4 - Booking";
$active = "movies";
include 'partials/head.php';
include 'partials/navbar.php';

include 'data/movies.php';
$movies = $MOVIES;

$slug   = $_GET['slug'] ?? '';
$time   = $_GET['time'] ?? '17:10';
$studio = $_GET['studio'] ?? 'CINEMA04';
$date   = $_GET['date'] ?? date('D, d.m.Y'); // mock format


session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: join-us.php?redirect=booking");
    exit;
}


// cari movie
$movie = null;
foreach ($movies as $m) {
    if (($m['slug'] ?? '') === $slug) {
        $movie = $m;
        break;
    }
}

if (!$movie) {
    echo '<div class="container py-5"><div class="alert alert-dark border-secondary">Film tidak ditemukan. <a href="movies.php" class="alert-link">Kembali</a></div></div>';
    include 'partials/footer.php';
    exit;
}

$titleM  = $movie['title'] ?? '';
$genre   = $movie['genre'] ?? '';
$dur     = $movie['dur'] ?? '';
$poster  = $movie['poster'] ?? '';
$city    = $_GET['cinema'] ?? 'CSB CINEM4'; // mock

// ====== DENAH KURSI (SEDIKIT DULU) ======
$rows = ['A', 'B', 'C', 'D', 'E'];
$cols = [1, 2, 3, 4, 5, 6, 7, 8];

// mock seat status
$booked = ['A3', 'A4', 'B6', 'C2', 'D7']; // kursi sudah dibooking

// selected dari query (opsional)
$selected = array_filter(explode(',', $_GET['seats'] ?? ''));
$selected = array_values(array_unique(array_filter($selected)));
?>

<!-- Banner / Poster besar -->
<section class="booking-hero">
    <div class="booking-hero-bg" style="background-image:url('<?= htmlspecialchars($poster) ?>')"></div>
    <div class="booking-hero-overlay"></div>

    <div class="container booking-hero-content">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div class="booking-hero-left">
                <h1 class="booking-title mb-1"><?= htmlspecialchars($titleM) ?></h1>
                <div class="text-secondary mb-3"><?= htmlspecialchars(strtoupper($genre)) ?> • <?= htmlspecialchars($dur) ?></div>

                <div class="booking-meta">
                    <div><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($city) ?></div>
                    <div><i class="bi bi-calendar-event"></i> <?= htmlspecialchars($date) ?> - <?= htmlspecialchars($time) ?></div>
                    <div><i class="bi bi-door-open"></i> <?= htmlspecialchars($studio) ?></div>
                </div>
            </div>

            <a href="movie-detail.php?slug=<?= urlencode($slug) ?>" class="btn btn-outline-light border-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
</section>

<div class="container py-4">

    <!-- Info bar -->
    <div class="alert alert-dark border-secondary d-flex align-items-center justify-content-between gap-3 booking-note">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle"></i>
            <span class="small">Tiket yang dibeli tidak dapat diubah atau di-refund (mock).</span>
        </div>
        <button type="button" class="btn btn-sm btn-outline-light border-secondary" onclick="this.closest('.booking-note').remove()">✕</button>
    </div>

    <!-- Seat map card -->
    <div class="card-glass p-3 p-md-4">

        <div class="text-center mb-3">
            <img src="assets/ui/screen.png" class="screen-img" alt="Screen">
            <div class="fw-semibold text-light mt-2">STANDARD</div>
        </div>

        <!-- Denah kursi sederhana -->
        <div class="seat-wrap mx-auto">
            <?php foreach ($rows as $r): ?>
                <div class="seat-row">
                    <?php foreach ($cols as $c): ?>
                        <?php
                        $code = $r . $c;
                        $isBooked = in_array($code, $booked, true);
                        $isSelected = in_array($code, $selected, true);

                        $cls = 'seat';
                        if ($isBooked) $cls .= ' is-booked';
                        else if ($isSelected) $cls .= ' is-selected';
                        ?>
                        <button
                            type="button"
                            class="<?= $cls ?>"
                            data-seat="<?= htmlspecialchars($code) ?>"
                            <?= $isBooked ? 'disabled' : '' ?>>
                            <?= htmlspecialchars($code) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Legend -->
        <div class="seat-legend mt-4 d-flex flex-wrap justify-content-center gap-4 small">
            <span class="legend-item"><span class="legend-seat"></span> Available</span>
            <span class="legend-item"><span class="legend-seat booked"></span> Booked</span>
            <span class="legend-item"><span class="legend-seat selected"></span> Selected</span>
        </div>

        <!-- Summary + Next -->
        <hr class="border-secondary opacity-25 my-4">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="text-secondary small">Selected Seats</div>
                <div class="fw-semibold text-light" id="selectedText"><?= $selected ? htmlspecialchars(implode(', ', $selected)) : '—' ?></div>
            </div>

            <div class="d-flex gap-2">
                <a class="btn btn-outline-light border-secondary rounded-pill px-4" id="clearBtn" href="#">
                    Clear
                </a>
                <a class="btn btn-primary rounded-pill px-4" id="nextBtn" href="#">
                    Next
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    const seatButtons = document.querySelectorAll('.seat:not(.is-booked)');
    const selectedText = document.getElementById('selectedText');
    const nextBtn = document.getElementById('nextBtn');
    const clearBtn = document.getElementById('clearBtn');

    // initial from URL
    const url = new URL(window.location.href);
    const selected = new Set((url.searchParams.get('seats') || '').split(',').filter(Boolean));

    function syncLinks() {
        const seatsStr = Array.from(selected).join(',');
        url.searchParams.set('seats', seatsStr);

        // clear
        const clearUrl = new URL(url);
        clearUrl.searchParams.delete('seats');
        clearBtn.href = clearUrl.toString();

        // next (sementara ke payment.php mock)
        const nextUrl = new URL(url);
        nextUrl.pathname = nextUrl.pathname.replace(/booking\.php$/, 'payment.php'); // nanti kamu buat
        nextBtn.href = nextUrl.toString();

        selectedText.textContent = seatsStr ? seatsStr.replaceAll(',', ', ') : '—';

        // disable next kalau kosong
        nextBtn.classList.toggle('disabled', selected.size === 0);
        nextBtn.setAttribute('aria-disabled', selected.size === 0 ? 'true' : 'false');
    }

    function paint() {
        seatButtons.forEach(btn => {
            const code = btn.getAttribute('data-seat');
            btn.classList.toggle('is-selected', selected.has(code));
        });
    }

    seatButtons.forEach(btn => {
        const code = btn.getAttribute('data-seat');
        if (selected.has(code)) btn.classList.add('is-selected');

        btn.addEventListener('click', () => {
            if (selected.has(code)) selected.delete(code);
            else selected.add(code);

            paint();
            syncLinks();
        });
    });

    syncLinks();
</script>

<?php include 'partials/footer.php'; ?>