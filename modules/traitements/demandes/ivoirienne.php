<?php
include('../../../includes/header.php');
include('../../../includes/sidebar.php');
include('../../../includes/db.php');

// Récupération des listes dynamiques depuis la base
$exportateurs = $pdo->query("SELECT ID_EXPORTATEUR, RAISONSOCIALE_EXPORTATEUR, MARQUE_EXPORTATEUR, CODE_EXPORTATEUR FROM exportateurs ORDER BY RAISONSOCIALE_EXPORTATEUR")->fetchAll();
$campagnes = $pdo->query("SELECT CAMP_DEMANDE FROM campagne ORDER BY CAMP_DEMANDE DESC")->fetchAll();
$villes = $pdo->query("SELECT DISTINCT VILLE_EXPORTATEUR FROM exportateurs WHERE VILLE_EXPORTATEUR IS NOT NULL AND VILLE_EXPORTATEUR <> '' ORDER BY VILLE_EXPORTATEUR")->fetchAll();
$produits = $pdo->query("SELECT ID_PRODUIT, LIBELLE_PRODUIT FROM produits ORDER BY LIBELLE_PRODUIT")->fetchAll();
?>

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
            max-width: 1200px;
            margin: 30px auto 0 auto;
            padding: 30px 30px 20px 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.10);
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: bold;
        }
        .filters {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px 30px;
            margin-bottom: 18px;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        .filter-group label {
            font-size: 15px;
            color: #003366;
            margin-bottom: 4px;
            font-weight: bold;
        }
        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            border: 1px solid #b0b0b0;
            border-radius: 7px;
            font-size: 15px;
            background: #f4f6fa;
        }
        .actions-bar {
            display: flex;
            gap: 24px;
            margin: 30px 0 0 0;
            flex-wrap: wrap;
        }
        .actions-bar button {
            padding: 12px 32px;
            border: none;
            border-radius: 10px;
            background: #003366;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .actions-bar button:hover {
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
            margin-top: 30px;
        }
        .total-lots {
            background: #003366;
            color: #fff;
            padding: 14px 38px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 20px;
        }
        .back-btn {
            position: fixed;
            left: 45px;
            bottom: 45px;
            padding: 18px 38px;
            background: #003366;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 20px;
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
        @media (max-width: 1100px) {
            .content { max-width: 98vw; }
            .filters { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 700px) {
            .filters { grid-template-columns: 1fr; }
            .actions-bar, .footer-bar { flex-direction: column; gap: 12px; }
        }
    </style>
</head>
<body>
<div class="content">
    <h2>📝 Liste des Demandes - Autorités Ivoirienne</h2>
    <form class="filters" method="get" action="">
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
            <select id="exportateur" name="exportateur">
                <option value="">-- Tous --</option>
                <?php foreach($exportateurs as $exp): ?>
                    <option value="<?= $exp['ID_EXPORTATEUR'] ?>">
                        <?= htmlspecialchars(
                            trim(
                                ($exp['RAISONSOCIALE_EXPORTATEUR'] ?: '') .
                                ($exp['MARQUE_EXPORTATEUR'] ? ' / '.$exp['MARQUE_EXPORTATEUR'] : '') .
                                ($exp['CODE_EXPORTATEUR'] ? ' / '.$exp['CODE_EXPORTATEUR'] : '')
                            )
                        ) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label for="produit">Produit</label>
            <select id="produit" name="produit">
                <option value="">-- Tous --</option>
                <?php foreach($produits as $prod): ?>
                    <option value="<?= $prod['ID_PRODUIT'] ?>"><?= htmlspecialchars($prod['LIBELLE_PRODUIT']) ?></option>
                <?php endforeach; ?>
            </select>
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
                <option value="">-- Toutes --</option>
                <?php foreach($campagnes as $camp): ?>
                    <option value="<?= htmlspecialchars($camp['CAMP_DEMANDE']) ?>"><?= htmlspecialchars($camp['CAMP_DEMANDE']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label for="ville">Ville</label>
            <select id="ville" name="ville">
                <option value="">-- Toutes --</option>
                <?php foreach($villes as $ville): ?>
                    <option value="<?= htmlspecialchars($ville['VILLE_EXPORTATEUR']) ?>"><?= htmlspecialchars($ville['VILLE_EXPORTATEUR']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <div class="actions-bar">
        <button type="button" class="refresh-btn">Actualiser les Demandes</button>
        <button type="button">Ajouter</button>
        <button type="button">Modifier</button>
        <button type="button" class="delete-btn">Supprimer</button>
        <button type="button">Imprimer</button>
    </div>
    <div class="footer-bar">
        <span class="total-lots">Nombre Total de lots : 0</span>
    </div>
</div>
<button class="back-btn" onclick="window.history.back();">⬅️ Retour</button>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>