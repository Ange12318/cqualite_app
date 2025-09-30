<?php include('../../includes/header.php'); ?>
<?php include('../../includes/sidebar.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Module Traitements</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fa;
        }
        .main-content {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            max-width: 900px;
            margin: 40px auto 60px auto;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #003366;
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .card:hover {
            background: #003366;
            color: white;
            transform: translateY(-5px);
        }
        h2 {
            color: #003366;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 35px;
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
    <h2>📦 Module Traitements</h2>
    <div class="main-content">
        <a href="demandes/ivoirienne.php" class="card">📌 Demandes Autorités Ivoirienne</a>
        <a href="demandes/clients.php" class="card">📌 Demandes Clients Standards</a>
        <a href="validations/cacao.php" class="card">📊 Validation Résultats Analyses Cacao</a>
        <a href="validations/cafe.php" class="card">📊 Validation Résultats Analyses Café</a>
        <a href="export/bv_cacao.php" class="card">📤 Export BV Cacao</a>
        <a href="export/bv_cafe.php" class="card">📤 Export BV Café</a>
        <a href="edition/bvba_cacao.php" class="card">📝 Edition BV/BA Cacao</a>
        <a href="edition/bvba_cafe.php" class="card">📝 Edition BV/BA Café</a>
    </div>
    <button class="back-btn" onclick="window.history.back();">⬅️ Retour</button>
</body>
</html>
<?php include('../../includes/footer.php'); ?>
