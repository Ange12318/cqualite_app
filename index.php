<?php
session_start();

// --- Utilisateur lambda (provisoire, on passera à la base de données ensuite)
$default_email = "user@ace.ci";
$default_password = "12345";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === $default_email && $password === $default_password) {
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - CQUALITÉ ACE</title>
    <style>
        /* --- RESET --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #003366, #0055aa);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #003366;
        }

        .login-container .logo {
            width: 80px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #003366;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #003366;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
            border-color: #cc0000;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #cc0000;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #990000;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo.png" alt="Logo ACE" class="logo"> <!-- Ton logo -->
        <h2>Connexion</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="ex: user@ace.ci" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>

            <button type="submit" class="btn">Se connecter</button>

            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
        </form>
        <div class="footer">
            &copy; 2025 CQUALITÉ ACE - Tous droits réservés
        </div>
    </div>
</body>
</html>
