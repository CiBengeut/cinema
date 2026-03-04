<?php
$title  = "CINEM4 - Join Us";
$active = "";
include 'partials/head.php';
include 'partials/navbar.php';

$mode = $_GET['mode'] ?? 'register'; // register | login
$isLogin = ($mode === 'login');
?>

<link rel="stylesheet" href="assets/css/auth.css">

<div class="container py-5">
    <div class="auth-shell <?= $isLogin ? 'is-login' : 'is-register' ?>">

        <div class="auth-body">

            <!-- REGISTER -->
            <div class="auth-pane auth-pane--register">
                <div class="auth-pane-inner">
                    <h2 class="auth-title text-light">Hallo, Selamat datang di CINEM4!</h2>
                    <div class="text-secondary mb-4">
                        Sudah memiliki akun?
                        <a class="auth-link" href="?mode=login" data-auth="login">Log in</a>
                    </div>

                    <form class="row g-3" method="post" action="register_action.php">
                        <div class="col-md-6">
                            <label class="form-label text-light">First Name <span class="text-danger">*</span></label>
                            <input class="form-control bg-dark text-light border-secondary" name="first_name" required placeholder="Enter your First Name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Last Name <span class="text-danger">*</span></label>
                            <input class="form-control bg-dark text-light border-secondary" name="last_name" required placeholder="Enter your Last Name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control bg-dark text-light border-secondary" name="email" required placeholder="Enter your Email">
                            <div class="form-text text-secondary">Contoh: nama@gmail.com</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Whatsapp Nomor <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark text-light border-secondary">+62</span>
                                <input class="form-control bg-dark text-light border-secondary" name="wa" required placeholder="8xxxxxxxxxx">
                            </div>
                            <div class="form-text text-secondary">9–15 digit (tanpa spasi/tanda)</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control bg-dark text-light border-secondary" name="password" required minlength="8" placeholder="Enter your Password">
                                <button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="form-text text-secondary">Min 8 karakter, harus ada huruf & angka.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-light">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control bg-dark text-light border-secondary" name="password_confirm" required minlength="8" placeholder="Enter your Password">
                                <button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tos" required>
                                <label class="form-check-label text-light" for="tos">
                                    Saya setuju dengan syarat & ketentuan yang berlaku
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-light w-100 py-1 fw-semibold rounded-4" type="submit">
                                Next
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- LOGIN -->
            <div class="auth-pane auth-pane--login">
                <div class="auth-pane-inner">
                    <h2 class="auth-title text-light">Log In</h2>
                    <div class="text-secondary mb-4">
                        Belum punya akun?
                        <a class="auth-link" href="?mode=register" data-auth="register">Daftar di sini</a>
                    </div>

                    <form method="post" action="login_action.php" class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-light">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control bg-dark text-light border-secondary" name="email" required placeholder="Masukkan email Anda">
                        </div>

                        <div class="col-12">
                            <label class="form-label text-light">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control bg-dark text-light border-secondary" name="password" required placeholder="Masukkan password Anda">
                                <button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <a href="#" class="auth-link">Lupa Password?</a>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-light w-100 py-1 fw-semibold rounded-4" type="submit">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MOVIEGOERS COVER -->
            <div class="auth-cover">
                <div class="auth-cover-inner">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="brand-dot"></span>
                        <div class="fw-bold text-white">CINEM4</div>
                    </div>

                    <!-- title -->
                    <div class="auth-big auth-big--register">Hai Moviegoers!</div>
                    <div class="auth-big auth-big--login">Welcome Back!</div>

                    <!-- subtext -->
                    <div class="text-secondary auth-sub auth-sub--register">
                        Buat akun CINEM4 untuk booking lebih cepat & simpan favorit.
                    </div>
                    <div class="text-secondary auth-sub auth-sub--login">
                        Login untuk lanjut booking, lihat tiket, dan favorit kamu.
                    </div>

                    <!-- optional ilustrasi -->
                    <!-- <img class="auth-ill" src="assets/img/auth-ill.png" alt="Join Us"> -->
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // switch mode
    document.addEventListener('click', (e) => {
        const link = e.target.closest('[data-auth]');
        if (!link) return;
        e.preventDefault();

        const mode = link.getAttribute('data-auth'); // login/register
        const shell = document.querySelector('.auth-shell');

        shell.classList.toggle('is-login', mode === 'login');
        shell.classList.toggle('is-register', mode !== 'login');

        const url = new URL(window.location);
        url.searchParams.set('mode', mode);
        history.pushState({}, '', url);
    });

    // toggle password
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-toggle-pass]');
        if (!btn) return;

        const input = btn.parentElement.querySelector('input');
        if (!input) return;

        input.type = (input.type === 'password') ? 'text' : 'password';
        const icon = btn.querySelector('i');
        if (icon) icon.className = (input.type === 'password') ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
</script>

<?php include 'partials/footer.php'; ?>