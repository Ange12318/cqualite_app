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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CQUALITÉ ACE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('assets/img/cacao_cafe.jpeg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            z-index: 0;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e1e5e9;
            position: relative;
            z-index: 1;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .logo-container {
            margin-bottom: 25px;
            padding: 25px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px solid #003366;
        }

        .logo {
            max-width: 150px;
            max-height: 120px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: #003366;
            margin-top: 15px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
            font-weight: 500;
        }

        .login-container h2 {
            margin-bottom: 10px;
            color: #003366;
            font-size: 28px;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #003366;
            font-weight: 600;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #003366;
            font-size: 16px;
            z-index: 2;
        }

        .input-with-icon input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .input-with-icon input:focus {
            border-color: #003366;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
        }

        .btn:hover {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.4);
        }

        .error {
            color: #cc0000;
            margin-top: 15px;
            font-size: 14px;
            background: rgba(204, 0, 0, 0.1);
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #cc0000;
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .feature-item {
            background: rgba(0, 51, 102, 0.05);
            padding: 12px 8px;
            border-radius: 8px;
            font-size: 11px;
            color: #003366;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .welcome-text {
            color: #003366;
            font-size: 15px;
            margin-bottom: 25px;
            font-weight: 500;
            line-height: 1.5;
            padding: 15px;
            background: rgba(0, 51, 102, 0.05);
            border-radius: 10px;
            border-left: 4px solid #003366;
        }

        .demo-credentials {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #856404;
        }

        .demo-credentials strong {
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
                align-items: flex-start;
                min-height: 100vh;
            }

            .login-container {
                margin: 10px 0;
                padding: 30px 20px;
                max-width: 100%;
            }
            
            .logo-container {
                padding: 20px 15px;
            }
            
            .logo {
                max-width: 120px;
                max-height: 100px;
            }
            
            .brand-title {
                font-size: 20px;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .input-with-icon input {
                padding: 12px 15px 12px 45px;
            }
            
            .btn {
                padding: 14px;
            }
        }

        @media (max-height: 700px) {
            body {
                align-items: flex-start;
                padding-top: 40px;
                padding-bottom: 40px;
            }
        }

        /* Assurer que le contenu ne dépasse pas */
        .login-container {
            max-height: 95vh;
            overflow-y: auto;
        }

        /* Scrollbar personnalisée */
        .login-container::-webkit-scrollbar {
            width: 6px;
        }

        .login-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .login-container::-webkit-scrollbar-thumb {
            background: #003366;
            border-radius: 3px;
        }

        .login-container::-webkit-scrollbar-thumb:hover {
            background: #002244;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="logo.png" alt="Logo ACE - CQUALITÉ" class="logo" onerror="this.style.display='none'">
            <div class="brand-title">QUALITIS ACE</div>
            <div class="brand-subtitle">Système de Gestion de la Qualité</div>
        </div>
        
        <h2>Connexion</h2>
        <p class="subtitle">Accédez à votre espace personnel</p>
        
        <div class="demo-credentials">
            <strong>🔐 Identifiants de démonstration</strong>
            Email: <strong>user@ace.ci</strong> | Mot de passe: <strong>12345</strong>
        </div>
        
        <div class="welcome-text">
            Bienvenue dans la plateforme QUALITIS ACE<br>
            Veuillez vous connecter pour accéder à votre espace
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="text" id="email" name="email" placeholder="ex: user@ace.ci" required value="user@ace.ci">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required value="12345">
                </div>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>

            <?php if ($error): ?>
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
        </form>

        <div class="feature-grid">
            <div class="feature-item">
                <i class="fas fa-coffee"></i> Café
            </div>
            <div class="feature-item">
                <i class="fas fa-seedling"></i> Cacao
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line"></i> Qualité
            </div>
        </div>

        <div class="footer">
            &copy; 2025 CQUALITÉ ACE - Tous droits réservés<br>
            <small>Version 1.0</small>
        </div>
    </div>

    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const loginContainer = document.querySelector('.login-container');
            loginContainer.style.opacity = '0';
            loginContainer.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                loginContainer.style.transition = 'all 0.5s ease';
                loginContainer.style.opacity = '1';
                loginContainer.style.transform = 'translateY(0)';
            }, 100);

            // Vérifier si le logo est chargé
            const logo = document.querySelector('.logo');
            logo.addEventListener('load', function() {
                console.log('Logo chargé avec succès');
            });
            
            logo.addEventListener('error', function() {
                console.log('Logo non trouvé, affichage du texte uniquement');
                this.style.display = 'none';
            });

            // Ajustement automatique de la hauteur sur mobile
            function adjustHeight() {
                const vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }

            window.addEventListener('resize', adjustHeight);
            window.addEventListener('orientationchange', adjustHeight);
            adjustHeight();
        });

        // Focus sur le premier champ
        document.getElementById('email').focus();
    </script>
</body>
</html>