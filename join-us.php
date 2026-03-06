<?php
session_start();
$title  = "CINEM4 - Join Us";
$active = "";
include 'partials/head.php';
include 'partials/navbar.php';

$mode = $_GET['mode'] ?? 'register';
$isLogin = ($mode === 'login');
?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-3">
    <?php 
        $err = $_SESSION['error'];
        if ($err=="empty"): ?>
            <i class="bi bi-exclamation-circle"></i>
            <span>Email dan password wajib diisi.</span>
        <?php elseif ($err=="not_verified"): ?>
            <i class="bi bi-envelope-exclamation"></i>
            <span>Akun belum diverifikasi. Silakan cek email.</span>
        <?php elseif ($err=="wrong_password"): ?>
            <i class="bi bi-shield-lock"></i>
            <span>Password salah.</span>
        <?php elseif ($err=="email_not_found"): ?>
            <i class="bi bi-person-x"></i>
            <span>Email tidak ditemukan.</span>
    <?php endif; ?>
</div>

<?php 
unset($_SESSION['error']); // hapus session supaya alert tidak muncul lagi
endif; 
?>

<link rel="stylesheet" href="assets/css/auth.css">

<div class="container py-5">
<div class="auth-shell <?= $isLogin ? 'is-login' : 'is-register' ?>">

<div class="auth-body">

<!-- REGISTER -->
<div class="auth-pane auth-pane--register">
<div class="auth-pane-inner">

<h2 class="auth-title text-light">Hallo, Selamat datang di FOUR CINEMA!</h2>

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
<div class="form-text text-secondary">9–15 digit</div>
</div>

<div class="col-md-6">
<label class="form-label text-light">Password <span class="text-danger">*</span></label>
<div class="input-group">
<input type="password" class="form-control bg-dark text-light border-secondary" name="password" required minlength="8">
<button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
<i class="bi bi-eye"></i>
</button>
</div>
</div>

<div class="col-md-6">
<label class="form-label text-light">Konfirmasi Password</label>
<div class="input-group">
<input type="password" class="form-control bg-dark text-light border-secondary" name="password_confirm" required>
<button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
<i class="bi bi-eye"></i>
</button>
</div>
</div>

<div class="col-12">
<div class="form-check">
<input class="form-check-input" type="checkbox" id="tos" required>
<label class="form-check-label text-light" for="tos">
Saya setuju dengan syarat & ketentuan
</label>
</div>
</div>

<div class="col-12">
<button class="btn btn-light w-100 py-2 fw-semibold rounded-4">
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

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-3">

<?php if ($_GET['error']=="empty"): ?>
<i class="bi bi-exclamation-circle"></i>
<span>Email dan password wajib diisi.</span>

<?php elseif ($_GET['error']=="not_verified"): ?>
<i class="bi bi-envelope-exclamation"></i>
<span>Akun belum diverifikasi. Silakan cek email.</span>

<?php elseif ($_GET['error']=="wrong_password"): ?>
<i class="bi bi-shield-lock"></i>
<span>Password salah.</span>

<?php elseif ($_GET['error']=="email_not_found"): ?>
<i class="bi bi-person-x"></i>
<span>Email tidak ditemukan.</span>

<?php endif; ?>

</div>
<?php endif; ?>

<div class="text-secondary mb-4">
Belum punya akun?
<a class="auth-link" href="?mode=register" data-auth="register">Daftar di sini</a>
</div>

<form method="post" action="login_action.php" class="row g-3">

<div class="col-12">
<label class="form-label text-light">Email</label>
<input type="email" class="form-control bg-dark text-light border-secondary" name="email" required>
</div>

<div class="col-12">
<label class="form-label text-light">Password</label>
<div class="input-group">
<input type="password" class="form-control bg-dark text-light border-secondary" name="password" required>
<button class="btn btn-dark border-secondary" type="button" data-toggle-pass>
<i class="bi bi-eye"></i>
</button>
</div>
</div>

<div class="col-12 d-flex justify-content-end">
<a href="forgot_password.php" class="auth-link">Lupa Password?</a>
</div>

<div class="col-12">
<button class="btn btn-light w-100 py-2 fw-semibold rounded-4">
Log in
</button>
</div>

</form>
</div>
</div>


<!-- COVER -->
<div class="auth-cover">
<div class="auth-cover-inner">

<div class="d-flex align-items-center gap-2 mb-3">
<span class="brand-dot"></span>
<div class="fw-bold text-white">CINEM4</div>
</div>

<div class="auth-big auth-big--register">Hai Moviegoers!</div>
<div class="auth-big auth-big--login">Welcome Back!</div>

<div class="text-secondary auth-sub auth-sub--register">
Buat akun FOUR CINEMA untuk booking lebih cepat.
</div>

<div class="text-secondary auth-sub auth-sub--login">
Login untuk lanjut booking tiket kamu.
</div>

</div>
</div>

</div>
</div>
</div>


<script>

// switch login register
document.addEventListener('click',(e)=>{
const link = e.target.closest('[data-auth]');
if(!link) return;

e.preventDefault();

const mode = link.getAttribute('data-auth');
const shell = document.querySelector('.auth-shell');

shell.classList.toggle('is-login', mode==='login');
shell.classList.toggle('is-register', mode!=='login');

const url = new URL(window.location);
url.searchParams.set('mode',mode);
history.pushState({},'',url);
});


// toggle password
document.addEventListener('click',(e)=>{
const btn = e.target.closest('[data-toggle-pass]');
if(!btn) return;

const input = btn.parentElement.querySelector('input');

input.type = input.type==='password'?'text':'password';

const icon = btn.querySelector('i');
icon.className = input.type==='password'
?'bi bi-eye'
:'bi bi-eye-slash';

});

</script>

<?php include 'partials/footer.php'; ?>