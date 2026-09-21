<?php

session_start();

include "config/koneksi.php";

$judul = "Login - Luxora Organizer";

$error = "";


// ==================================================
// PROSES LOGIN
// ==================================================

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['email'])
    );

    $password = mysqli_real_escape_string(
        $koneksi,
        $_POST['password']
    );


    // ==============================================
    // CEK USER
    // ==============================================

    $query = mysqli_query(
        $koneksi,
        "SELECT *
         FROM users
         WHERE email = '$email'
         AND password = '$password'
         LIMIT 1"
    );


    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);


        // ==========================================
        // CEK STATUS USER
        // ==========================================

        if (
            isset($user['status']) &&
            $user['status'] == 'nonaktif'
        ) {

            $error = "Akun Anda sedang dinonaktifkan.";

        } else {

            // ======================================
            // SIMPAN SESSION USER
            // ======================================

            $_SESSION['user_id'] =
                $user['id_user'];

            $_SESSION['user_nama'] =
                $user['nama'];

            $_SESSION['user_email'] =
                $user['email'];


            // ======================================
            // REDIRECT
            // ======================================

            header("Location: index.php");
            exit;

        }

    } else {

        $error = "Email atau password tidak sesuai.";

    }

}

?>


<?php include "includes/header.php"; ?>

<?php include "includes/navbar.php"; ?>


<!-- ==================================================
     LOGIN
================================================== -->

<section
    class="auth-section"
>

    <div class="container">

        <div class="auth-container fade-up">


            <!-- ======================================
                 HEADER LOGIN
            ======================================= -->

            <div class="auth-header">

                <p class="login-subtitle">
                    WELCOME BACK
                </p>

                <h1>
                    Sign In
                </h1>

                <p>
                    Masuk ke akun Luxora Organizer Anda.
                </p>

            </div>


            <!-- ======================================
                 ERROR
            ======================================= -->

            <?php if ($error != ""): ?>

                <div class="login-error">

                    <?php
                    echo htmlspecialchars($error);
                    ?>

                </div>

            <?php endif; ?>


            <!-- ======================================
                 FORM LOGIN
            ======================================= -->

            <form
                method="POST"
                action=""
            >


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
                        placeholder="Masukkan email Anda"
                        required
                        autocomplete="email"
                        value="<?php
                            echo htmlspecialchars(
                                $_POST['email'] ?? ''
                            );
                        ?>"
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
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >


                        <!-- ==========================
                             TOMBOL MATA
                        =========================== -->

                        <button
                            type="button"
                            id="togglePassword"
                            class="password-toggle"
                            aria-label="Tampilkan password"
                            title="Tampilkan password"
                        >


                            <!-- MATA TERBUKA -->

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
                     BUTTON LOGIN
                =================================== -->

                <button
                    type="submit"
                    name="login"
                    class="btn-detail login-button"
                >

                    Login

                </button>


            </form>


            <!-- ======================================
                 REGISTER
            ======================================= -->

            <div class="register-link">

                <p>

                    Belum mempunyai akun?

                    <a href="register.php">
                        Daftar Sekarang
                    </a>

                </p>

            </div>


        </div>

    </div>

</section>


<!-- ==================================================
     CSS LOGIN
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


.login-subtitle {

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

.login-error {

    background: #f8e1dc;

    color: #8a4b42;

    padding: 14px 18px;

    border-radius: 10px;

    margin-bottom: 20px;

    text-align: center;

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
   PASSWORD
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
   BUTTON LOGIN
========================================== */

.login-button {

    width: 100%;

    border: none;

    cursor: pointer;

    margin-top: 5px;

}


/* ==========================================
   REGISTER
========================================== */

.register-link {

    text-align: center;

    margin-top: 25px;

}


.register-link p {

    margin: 0;

    color: #765b54;

}


.register-link a {

    color: #b88980;

    font-weight: 700;

    text-decoration: none;

}


.register-link a:hover {

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


        // ==========================================
        // JIKA PASSWORD MASIH TERSEMBUNYI
        // ==========================================

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


        } else {


            // ======================================
            // SEMBUNYIKAN PASSWORD
            // ======================================

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

</script>


<?php include "includes/footer.php"; ?>