<?php include('../../includes/header.php'); ?>
<?php include('../../includes/sidebar.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Module Statistiques</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fa;
        }
        .content {
            padding: 40px;
            max-width: 700px;
            margin: 40px auto 60px auto;
            background: none;
            border-radius: 12px;
        }
        h2 {
            color: #003366;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 35px;
        }
        .submenu {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        .submenu li {
            margin: 0;
        }
        .submenu a {
            display: block;
            background: rgba(255,255,255,0.95);
            color: #003366;
            padding: 30px 40px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
            transition: 0.3s;
        }
        .submenu a:hover {
            background: #003366;
            color: #fff;
            transform: translateY(-5px);
        }
        .back-btn {
            position: fixed;
            left: 30px;
            bottom: 30px;
            padding: 12px 28px;
            background: #003366;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
            z-index: 100;
        }
        .back-btn:hover {
            background: #00509e;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>📊 Module Statistiques</h2>
        <ul class="submenu">
            <li><a href="bilan.php">📌 Bilan trimestriel</a></li>
            <li><a href="tonnage.php">⚖️ Statistiques du tonnage</a></li>
            <li><a href="moyennes.php">📈 Moyenne des déterminants qualité</a></li>
        </ul>
    </div>
    <button class="back-btn" onclick="window.history.back();">⬅️ Retour</button>
</body>
</html>
<?php include('../../includes/footer.php'); ?>
