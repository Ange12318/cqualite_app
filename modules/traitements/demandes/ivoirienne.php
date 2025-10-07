<?php include('../../../includes/header.php'); ?>
<?php include('../../../includes/sidebar.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes Autorités Ivoirienne</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fa;
        }
        .content {
            max-width: 98vw;
            margin: 30px auto 0 auto;
            padding: 30px 20px 20px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.10);
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 18px 30px;
            margin-bottom: 18px;
            align-items: flex-end;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 180px;
        }
        .filter-group label {
            font-size: 14px;
            color: #003366;
            margin-bottom: 3px;
            font-weight: bold;
        }
        .filter-group input,
        .filter-group select {
            padding: 7px 10px;
            border: 1px solid #b0b0b0;
            border-radius: 6px;
            font-size: 15px;
            background: #f4f6fa;
        }
        .table-container {
            overflow-x: auto;
            background: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 8px 6px;
            text-align: center;
            font-size: 15px;
        }
        th {
            background: #003366;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) td {
            background: #f4f6fa;
        }
        tr:nth-child(odd) td {
            background: #fff;
        }
        .actions-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .actions-bar button, .actions-bar input[type="button"] {
            padding: 8px 18px;
            border: none;
            border-radius: 7px;
            background: #003366;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .actions-bar button:hover, .actions-bar input[type="button"]:hover {
            background: #00509e;
        }
        .refresh-btn {
            background: #003366;
        }
        .refresh-btn:hover {
            background: #00509e;
        }
        .delete-btn {
            background: #c62828;
        }
        .delete-btn:hover {
            background: #a31515;
        }
        .footer-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 18px;
        }
        .total-lots {
            background: #003366;
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
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
            background: #c62828;
        }
    </style>
</head>
<body>
<div class="content">
    <h2 style="text-align:center; color:#003366; margin-bottom:25px;">📋 Liste des Demandes - Autorités Ivoirienne</h2>
    <form class="filters">
        <div class="filter-group">
            <label for="reference">Référence</label>
            <input type="text" id="reference" name="reference">
        </div>
        <div class="filter-group">
            <label for="num_autorisation">N° Autorisation</label>
            <input type="text" id="num_autorisation" name="num_autorisation">
        </div>
        <div class="filter-group">
            <label for="exportateur">Exportateur</label>
            <input type="text" id="exportateur" name="exportateur">
        </div>
        <div class="filter-group">
            <label for="produit">Produit</label>
            <input type="text" id="produit" name="produit">
        </div>
        <div class="filter-group">
            <label for="date_debut">Date Début</label>
            <input type="date" id="date_debut" name="date_debut" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="filter-group">
            <label for="date_fin">Date Fin</label>
            <input type="date" id="date_fin" name="date_fin" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="filter-group">
            <label for="campagne">Campagne</label>
            <select id="campagne" name="campagne">
                <option>2024/2025</option>
                <option>2023/2024</option>
                <option>2022/2023</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="ville">Ville</label>
            <select id="ville" name="ville">
                <option>ABIDJAN</option>
                <option>YAMOUSSOUKRO</option>
                <option>BOUAKE</option>
            </select>
        </div>
    </form>
    <div class="actions-bar">
        <button type="button" class="refresh-btn">Actualiser les Demandes</button>
        <a href="/cqualite_app/modules/traitements/demandes/ajouter.php"><button type="button">Ajouter</button></a>
        <button type="button">Modifier</button>
        <button type="button" class="delete-btn">Supprimer</button>
        <button type="button">Imprimer</button>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Produit</th>
                    <th>Ville</th>
                    <th>Exportateurs</th>
                    <th>Date Réception</th>
                    <th>Date Expiration</th>
                    <th>Campagne</th>
                    <th>Nbre de Lots</th>
                    <th>Poids Net</th>
                    <th>Nbre de BV</th>
                    <th>Nbre de BA</th>
                    <th>Etat</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemple de lignes vides pour l'affichage -->
                <?php for($i=0;$i<15;$i++): ?>
                <tr>
                    <td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="footer-bar">
        <span class="total-lots">Nombre Total de lots : 0</span>
    </div>
</div>
<button class="back-btn" onclick="window.history.back();">⬅️ Retour</button>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>