<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CQUALITÉ ACE</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('/assets/img/cacao_cafe.jpeg') no-repeat center center fixed;
            background-size: cover;
        }

        header {
            background: rgba(0, 51, 102, 0.9);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            height: 50px;
        }

        header .user-info {
            font-size: 14px;
        }

        header .user-info span {
            margin-right: 15px;
            font-weight: bold;
        }

        header .logout {
            background: #cc0000;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        header .logout:hover {
            background: #990000;
        }

        main {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1000px;
            margin: 40px auto;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
        }

        .card:hover {
            background: #003366;
            color: white;
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo ACE">
        <div class="user-info">
            <span>Connecté : <?= htmlspecialchars($user) ?></span>
            <a href="?logout=true" class="logout">Se déconnecter</a>
        </div>
    </header>

    <main>
        <a href="/cqualite_app/modules/traitements/index.php" class="card">Traitements</a>
        <a href="/cqualite_app/modules/echantillons/index.php" class="card">Échantillons</a>
        <a href="/cqualite_app/modules/codifications/index.php" class="card">Codifications</a>
        <a href="/cqualite_app/modules/laboratoires/index.php" class="card">Laboratoires</a>
        <a href="/cqualite_app/modules/stockages/index.php" class="card">Stockages</a>
        <a href="/cqualite_app/modules/facturation/index.php" class="card">Facturation</a>
        <a href="/cqualite_app/modules/base/index.php" class="card">Base de données</a>
        <a href="/cqualite_app/modules/parametrage/index.php" class="card">Paramétrage</a>
        <a href="/cqualite_app/modules/statistiques/index.php" class="card">Statistiques</a>
    </main>
</body>
</html>
