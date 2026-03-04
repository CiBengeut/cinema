<?php
function renderPosterCarousel(string $id, array $items, string $mode = 'now')
{
    // split jadi per "slide" (1 slide menampung 5 poster di desktop)
    $chunks = array_chunk($items, 5);
?>
    <div id="<?= $id ?>" class="carousel slide multi-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">

            <?php foreach ($chunks as $i => $chunk): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="row g-3 justify-content-center">
                        <?php foreach ($chunk as $m): ?>
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="movie-wrap"
                                    role="button"
                                    onclick="window.location='movie-detail.php?slug=<?= urlencode($m['slug']) ?>'">

                                    <div class="poster-card">
                                        <div class="poster-media">
                                            <img src="<?= htmlspecialchars($m['poster']) ?>" alt="<?= htmlspecialchars($m['title']) ?>">
                                        </div>

                                        <?php
                                        $slug    = $m['slug']   ?? '';
                                        $titleM  = $m['title']  ?? '';
                                        $poster  = $m['poster'] ?? '';
                                        $trailer = trim($m['trailer'] ?? '');

                                        $age    = trim((string)($m['age'] ?? ''));     // boleh kosong
                                        $dur    = trim((string)($m['dur'] ?? ''));     // boleh kosong
                                        $format = trim((string)($m['format'] ?? ''));  // boleh kosong
                                        $rating = trim((string)($m['rating'] ?? ''));  // boleh kosong
                                        ?>

                                        <div class="poster-overlay">
                                            <div class="poster-actions">
                                                <?php if ($trailer !== ''): ?>
                                                    <button type="button"
                                                        class="btn btn-light btn-sm rounded-pill px-3 watch-trailer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#trailerModal"
                                                        data-trailer="<?= htmlspecialchars($trailer) ?>">
                                                        <i class="bi bi-play-fill me-1"></i> Trailer
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($mode !== 'upcoming'): ?>
                                                    <a href="booking.php?slug=<?= urlencode($slug) ?>"
                                                        class="btn btn-dark btn-sm rounded-pill px-3 btn-ticket">
                                                        <i class="bi bi-ticket-perforated me-1"></i> Tiket
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                            <?php
                                            // untuk upcoming: tampilkan hanya yang ada
                                            $hasAnyMeta = ($format !== '' || $rating !== '' || $dur !== '');
                                            ?>
                                            <?php if ($hasAnyMeta): ?>
                                                <div class="poster-meta">
                                                    <?php if ($format !== ''): ?>
                                                        <span class="badge rounded-pill bg-dark text-light border border-secondary">
                                                            <?= htmlspecialchars($format) ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if ($rating !== '' && $mode !== 'upcoming'): ?>
                                                        <span class="badge rounded-pill bg-danger">
                                                            <?= htmlspecialchars($rating) ?>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if ($dur !== ''): ?>
                                                        <span class="badge rounded-pill bg-dark text-light border border-secondary">
                                                            <?= htmlspecialchars($dur) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($age !== ''): ?>
                                            <div class="poster-badge"><?= htmlspecialchars($age) ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-2 small text-light fw-semibold text-truncate">
                                        <?= htmlspecialchars($m['title']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?= $id ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<?php
}
