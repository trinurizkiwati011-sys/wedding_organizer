<?php

session_start();

include "config/koneksi.php";

$judul = "Register - Luxora Organizer";

$error = "";
$success = "";


// ==================================================
// PROSES REGISTER
// ==================================================

if (isset($_POST['register'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama'])
    );

    $email = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['email'])
    );

    $password = mysqli_real_escape_string(
        $koneksi,
        $_POST['password']
    );

    $konfirmasi_password = mysqli_real_escape_string(
        $koneksi,
        $_POST['konfirmasi_password']
    );


    // ==============================================
    // CEK DATA KOSONG
    // ==============================================

    if (
        $nama == "" ||
        $email == "" ||
        $password == "" ||
        $konfirmasi_password == ""
    ) {

        $error = "Semua data wajib diisi.";

    }


    // ==============================================
    // CEK PASSWORD
    // ==============================================

    elseif ($password != $konfirmasi_password) {

        $error = "Konfirmasi password tidak sesuai.";

    }


    // ==============================================
    // CEK PANJANG PASSWORD
    // ==============================================

    elseif (strlen($password) < 6) {

        $error =
            "Password minimal terdiri dari 6 karakter.";

    }


    else {

        // ==========================================
        // CEK EMAIL SUDAH TERDAFTAR
        // ==========================================

        $cek_email = mysqli_query(
            $koneksi,
            "SELECT id_user
             FROM users
             WHERE email = '$email'
             LIMIT 1"
        );


        if (mysqli_num_rows($cek_email) > 0) {

            $error =
                "Email tersebut sudah terdaftar.";

        }


        else {

            // ======================================
            // SIMPAN USER
            // ======================================

            $query_register = mysqli_query(
                $koneksi,
                "INSERT INTO users
                (nama, email, password)
                VALUES
                ('$nama', '$email', '$password')"
            );


            if ($query_register) {

                $success =
                    "Pendaftaran berhasil. Silakan login.";

                // Kosongkan password setelah berhasil
                $_POST['password'] = "";
                $_POST['konfirmasi_password'] = "";

            }


            else {

                $error =
                    "Pendaftaran gagal. Silakan coba lagi.";

            }

        }

    }

}

?>


<?php include "includes/header.php"; ?>

<?php include "includes/navbar.php"; ?>


<!-- ==================================================
     REGISTER
================================================== -->

<section class="auth-section">

    <div class="container">

        <div class="auth-container fade-up">


            <!-- ======================================
                 HEADER REGISTER
            ======================================= -->

            <div class="auth-header">

                <p class="register-subtitle">
                    JOIN LUXORA
                </p>

                <h1>
                    Create Account
                </h1>

                <p>
                    Buat akun untuk menikmati
                    fitur Luxora Organizer.
                </p>

            </div>


            <!-- ======================================
                 ERROR
            ======================================= -->

            <?php if ($error != ""): ?>

                <div class="register-error">

                    <?php
                    echo htmlspecialchars($error);
                    ?>

                </div>

            <?php endif; ?>


            <!-- ======================================
                 SUCCESS
            ======================================= -->

            <?php if ($success != ""): ?>

                <div class="register-success">

                    <?php
                    echo htmlspecialchars($success);
                    ?>

                    <br>

                    <a href="login.php">
                        Login sekarang
                    </a>

                </div>

            <?php endif; ?>


            <!-- ======================================
                 FORM REGISTER
            ======================================= -->

            <form
                method="POST"
                action=""
            >


                <!-- ==================================
                     NAMA
                =================================== -->

                <div class="form-group">

                    <label for="nama">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama lengkap"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['nama'] ?? ''
                            );
                        ?>"
                        required
                        autocomplete="name"
                    >

                </div>


                <!-- ==================================
                     EMAIL
                =================================== -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['email'] ?? ''
                            );
                        ?>"
                        required
                        autocomplete="email"
                    >

                </div>


                <!-- ==================================
                     PASSWORD
                =================================== -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 6 karakter"
                            minlength="6"
                            required
                            autocomplete="new-password"
                        >


                        <!-- MATA TERBUKA -->

                        <button
                            type="button"
                            id="togglePassword"
                            class="password-toggle"
                            aria-label="Tampilkan password"
                            title="Tampilkan password"
                        >

                            <svg
                                id="eyeOpen"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                            </svg>


                            <!-- MATA TERTUTUP -->

                            <svg
                                id="eyeClosed"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                style="display:none;"
                            >

                                <path
                                    d="M3 3l18 18"
                                />

                                <path
                                    d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
                                />

                                <path
                                    d="M9.9 4.2A10.7 10.7 0 0 1 12 4c7 0 10 8 10 8a18.5 18.5 0 0 1-3.1 4.3"
                                />

                                <path
                                    d="M6.6 6.6C3.8 8.5 2 12 2 12s3.5 7 10 7a10.7 10.7 0 0 0 3-.4"
                                />

                            </svg>

                        </button>

                    </div>

                </div>


                <!-- ==================================
                     KONFIRMASI PASSWORD
                =================================== -->

                <div class="form-group">

                    <label for="konfirmasi_password">
                        Konfirmasi Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="konfirmasi_password"
                            name="konfirmasi_password"
                            placeholder="Masukkan ulang password"
                            minlength="6"
                            required
                            autocomplete="new-password"
                        >


                        <!-- MATA TERBUKA -->

                        <button
                            type="button"
                            id="toggleConfirmPassword"
                            class="password-toggle"
                            aria-label="Tampilkan konfirmasi password"
                            title="Tampilkan konfirmasi password"
                        >

                            <svg
                                id="eyeConfirmOpen"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                            </svg>


                            <!-- MATA TERTUTUP -->

                            <svg
                                id="eyeConfirmClosed"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                style="display:none;"
                            >

                                <path
                                    d="M3 3l18 18"
                                />

                                <path
                                    d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
                                />

                                <path
                                    d="M9.9 4.2A10.7 10.7 0 0 1 12 4c7 0 10 8 10 8a18.5 18.5 0 0 1-3.1 4.3"
                                />

                                <path
                                    d="M6.6 6.6C3.8 8.5 2 12 2 12s3.5 7 10 7a10.7 10.7 0 0 0 3-.4"
                                />

                            </svg>

                        </button>

                    </div>

                </div>


                <!-- ==================================
                     BUTTON
                =================================== -->

                <button
                    type="submit"
                    name="register"
                    class="btn-detail register-button"
                >
                    Create Account
                </button>


            </form>


            <!-- ======================================
                 LINK LOGIN
            ======================================= -->

            <div class="login-link">

                <p>

                    Sudah mempunyai akun?

                    <a href="login.php">
                        Login Sekarang
                    </a>

                </p>

            </div>


        </div>

    </div>

</section>


<!-- ==================================================
     CSS REGISTER
================================================== -->

<style>

.auth-section {

    min-height: 75vh;

    display: flex;

    align-items: center;

    padding: 60px 0;

}


.auth-container {

    width: 100%;

    max-width: 480px;

    margin: 0 auto;

    background: #ffffff;

    padding: 40px;

    border-radius: 22px;

    box-shadow:
        0 10px 35px
        rgba(74, 48, 43, 0.10);

    box-sizing: border-box;

}


/* ==========================================
   HEADER
========================================== */

.auth-header {

    text-align: center;

    margin-bottom: 30px;

}


.register-subtitle {

    color: #b88980;

    letter-spacing: 3px;

    margin-bottom: 8px;

    font-size: 15px;

}


.auth-header h1 {

    margin-bottom: 8px;

}


.auth-header p:last-child {

    color: #765b54;

    margin-bottom: 0;

}


/* ==========================================
   ERROR
========================================== */

.register-error {

    background: #f8e1dc;

    color: #8a4b42;

    padding: 14px 18px;

    border-radius: 10px;

    margin-bottom: 20px;

    text-align: center;

}


/* ==========================================
   SUCCESS
========================================== */

.register-success {

    background: #e4f2e8;

    color: #496b54;

    padding: 14px 18px;

    border-radius: 10px;

    margin-bottom: 20px;

    text-align: center;

}


.register-success a {

    color: #496b54;

    font-weight: 700;

    text-decoration: none;

}


.register-success a:hover {

    text-decoration: underline;

}


/* ==========================================
   FORM
========================================== */

.form-group {

    margin-bottom: 20px;

}


.form-group label {

    display: block;

    margin-bottom: 8px;

    color: #4a302b;

    font-weight: 600;

}


.form-group input {

    width: 100%;

    box-sizing: border-box;

    padding: 13px 15px;

    border: 1px solid #d9bbb2;

    border-radius: 10px;

    background: #ffffff;

    color: #4a302b;

    font-family: "Crimson Text", serif;

    font-size: 16px;

    outline: none;

    transition: 0.3s ease;

}


.form-group input:focus {

    border-color: #c99f96;

    box-shadow:
        0 0 0 3px
        rgba(201, 159, 150, 0.15);

}


/* ==========================================
   PASSWORD WRAPPER
========================================== */

.password-wrapper {

    position: relative;

    width: 100%;

}


.password-wrapper input {

    padding-right: 55px;

}


/* ==========================================
   TOMBOL MATA
========================================== */

.password-toggle {

    position: absolute;

    right: 10px;

    top: 50%;

    transform: translateY(-50%);

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: none;

    background: transparent;

    color: #765b54;

    cursor: pointer;

    padding: 0;

    border-radius: 50%;

    transition: 0.3s ease;

}


.password-toggle:hover {

    color: #b88980;

    background: #fff8f3;

}


.password-toggle svg {

    width: 21px;

    height: 21px;

    display: block;

    fill: none;

    stroke: currentColor;

    stroke-width: 2;

    stroke-linecap: round;

    stroke-linejoin: round;

}


/* ==========================================
   BUTTON REGISTER
========================================== */

.register-button {

    width: 100%;

    border: none;

    cursor: pointer;

    margin-top: 5px;

}


/* ==========================================
   LOGIN LINK
========================================== */

.login-link {

    text-align: center;

    margin-top: 25px;

}


.login-link p {

    margin: 0;

    color: #765b54;

}


.login-link a {

    color: #b88980;

    font-weight: 700;

    text-decoration: none;

}


.login-link a:hover {

    color: #8f625a;

}


/* ==========================================
   RESPONSIVE
========================================== */

@media (max-width: 600px) {

    .auth-section {

        padding: 40px 15px;

    }


    .auth-container {

        padding: 30px 22px;

    }

}

</style>


<!-- ==================================================
     JAVASCRIPT PASSWORD
================================================== -->

<script>


// ==================================================
// PASSWORD
// ==================================================

const passwordInput =
    document.getElementById("password");

const togglePassword =
    document.getElementById("togglePassword");

const eyeOpen =
    document.getElementById("eyeOpen");

const eyeClosed =
    document.getElementById("eyeClosed");


togglePassword.addEventListener(
    "click",
    function () {


        if (
            passwordInput.type === "password"
        ) {

            passwordInput.type = "text";

            eyeOpen.style.display = "none";

            eyeClosed.style.display = "block";

            togglePassword.setAttribute(
                "aria-label",
                "Sembunyikan password"
            );

            togglePassword.setAttribute(
                "title",
                "Sembunyikan password"
            );

        }

        else {

            passwordInput.type = "password";

            eyeOpen.style.display = "block";

            eyeClosed.style.display = "none";

            togglePassword.setAttribute(
                "aria-label",
                "Tampilkan password"
            );

            togglePassword.setAttribute(
                "title",
                "Tampilkan password"
            );

        }

    }
);


// ==================================================
// KONFIRMASI PASSWORD
// ==================================================

const confirmPasswordInput =
    document.getElementById(
        "konfirmasi_password"
    );

const toggleConfirmPassword =
    document.getElementById(
        "toggleConfirmPassword"
    );

const eyeConfirmOpen =
    document.getElementById(
        "eyeConfirmOpen"
    );

const eyeConfirmClosed =
    document.getElementById(
        "eyeConfirmClosed"
    );


toggleConfirmPassword.addEventListener(
    "click",
    function () {


        if (
            confirmPasswordInput.type === "password"
        ) {

            confirmPasswordInput.type = "text";

            eyeConfirmOpen.style.display = "none";

            eyeConfirmClosed.style.display = "block";

            toggleConfirmPassword.setAttribute(
                "aria-label",
                "Sembunyikan konfirmasi password"
            );

            toggleConfirmPassword.setAttribute(
                "title",
                "Sembunyikan konfirmasi password"
            );

        }

        else {

            confirmPasswordInput.type = "password";

            eyeConfirmOpen.style.display = "block";

            eyeConfirmClosed.style.display = "none";

            toggleConfirmPassword.setAttribute(
                "aria-label",
                "Tampilkan konfirmasi password"
            );

            toggleConfirmPassword.setAttribute(
                "title",
                "Tampilkan konfirmasi password"
            );

        }

    }
);

</script>


<?php include "includes/footer.php"; ?>