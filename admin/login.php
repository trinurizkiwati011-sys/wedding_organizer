
<?php

session_start();

include "../config/koneksi.php";

$error = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['email'])
    );

    $password = mysqli_real_escape_string(
        $koneksi,
        $_POST['password']
    );

    $query = mysqli_query(
        $koneksi,
        "SELECT *
         FROM admin
         WHERE email = '$email'
         AND password = '$password'
         LIMIT 1"
    );

    if (mysqli_num_rows($query) > 0) {

        $admin = mysqli_fetch_assoc($query);

        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_nama'] = $admin['nama_admin'];
        $_SESSION['admin_email'] = $admin['email'];

        // Waktu terakhir aktivitas
        $_SESSION['last_activity'] = time();

        header("Location: index.php");
        exit;

    } else {

        $error = "Email atau password admin tidak sesuai.";

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin - Luxora Organizer</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Style+Script&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;

            background: #fff8f3;

            font-family: "Crimson Text", serif;
            color: #4a302b;
        }

        .login-container {
            width: 100%;
            max-width: 430px;

            background: white;

            padding: 45px 40px;

            border-radius: 20px;

            box-shadow:
                0 10px 35px rgba(74, 48, 43, 0.12);
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h1 {
            font-family: "Style Script", cursive;
            font-size: clamp(40px, 10vw, 48px);
            font-weight: 400;
            color: #4a302b;
        }

        .login-title p {
            margin-top: 5px;
            color: #765b54;
            font-size: 17px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;

            font-size: 17px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;

            min-height: 48px;

            padding: 13px 15px;

            border: 1px solid #d9bbb2;
            border-radius: 10px;

            font-family: "Crimson Text", serif;
            font-size: 16px;

            outline: none;

            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #c99f96;

            box-shadow:
                0 0 0 3px rgba(201, 159, 150, 0.15);
        }

        .btn-admin {
            width: 100%;

            min-height: 48px;

            padding: 13px;

            border: none;
            border-radius: 30px;

            background: #c99f96;
            color: white;

            font-family: "Crimson Text", serif;
            font-size: 17px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.3s;
        }

        .btn-admin:hover {
            background: #b88980;
        }

        .error {
            margin-bottom: 20px;

            padding: 12px 15px;

            background: #f8e4e0;

            border: 1px solid #e0b8af;

            border-radius: 10px;

            color: #8a4d43;

            text-align: center;
        }

        .back-user {
            display: block;

            margin-top: 20px;

            text-align: center;

            color: #765b54;

            text-decoration: none;

            font-size: 16px;
        }

        .back-user:hover {
            color: #b88980;
        }


        /* ==============================
           TABLET
           ============================== */

        @media (max-width: 768px) {

            .login-container {
                padding: 40px 30px;
            }

        }


        /* ==============================
           HP
           ============================== */

        @media (max-width: 480px) {

            body {
                padding: 15px;
            }

            .login-container {
                padding: 32px 22px;
                border-radius: 16px;
            }

            .login-title {
                margin-bottom: 25px;
            }

            .login-title h1 {
                font-size: 42px;
            }

            .login-title p {
                font-size: 15px;
            }

            .form-group {
                margin-bottom: 17px;
            }

            .form-group label {
                font-size: 16px;
            }

            .form-group input {
                min-height: 46px;
                padding: 11px 13px;
            }

            .btn-admin {
                min-height: 46px;
                font-size: 16px;
            }

            .back-user {
                font-size: 15px;
            }

        }


        /* ==============================
           HP KECIL
           ============================== */

        @media (max-width: 360px) {

            .login-container {
                padding: 28px 18px;
            }

            .login-title h1 {
                font-size: 38px;
            }

        }

    </style>

</head>

<body>

    <div class="login-container">

        <div class="login-title">

            <h1>Luxora</h1>

            <p>Admin Panel</p>

        </div>

        <?php if ($error != ""): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label for="email">
                    Email Admin
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email admin"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>

            <button
                type="submit"
                name="login"
                class="btn-admin"
            >
                Login Admin
            </button>

        </form>

        <a
            href="../index.php"
            class="back-user"
        >
            ← Kembali ke Website
        </a>

    </div>

</body>

</html>

