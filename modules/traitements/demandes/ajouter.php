<?php include('../../../includes/header.php'); ?>
<?php include('../../../includes/sidebar.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Demande d'Analyse et de Sondage</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fa;
        }
        .content {
            max-width: 1100px;
            margin: 40px auto 0 auto;
            padding: 35px 30px 30px 30px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 35px;
            letter-spacing: 1px;
        }
        .form-header {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px 32px;
            margin-bottom: 32px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }
        .form-group label {
            font-size: 15px;
            color: #003366;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            padding: 9px 12px;
            border: 1px solid #b0b0b0;
            border-radius: 7px;
            font-size: 15px;
            background: #f4f6fa;
            transition: border 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border: 1.5px solid #003366;
            outline: none;
        }
        .table-container {
            overflow-x: auto;
            background: none;
            margin-bottom: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px 7px;
            text-align: center;
            font-size: 15px;
        }
        th {
            background: #003366;
            color: #fff;
            font-weight: bold;
        }
        tr td {
            background: #f4f6fa;
        }
        tr:nth-child(even) td {
            background: #eaf0fa;
        }
        .totals-bar {
            display: flex;
            gap: 40px;
            align-items: center;
            margin-bottom: 18px;
            margin-top: 10px;
            justify-content: flex-start;
        }
        .totals-bar .total-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .totals-bar label {
            font-weight: bold;
            color: #003366;
            font-size: 15px;
        }
        .totals-bar .total-value {
            background: #003366;
            color: #fff;
            padding: 7px 18px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            min-width: 60px;
            text-align: right;
            letter-spacing: 1px;
        }
        .actions-bar {
            display: flex;
            gap: 18px;
            margin-top: 18px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        .actions-bar button, .actions-bar input[type="button"] {
            padding: 10px 22px;
            border: none;
            border-radius: 8px;
            background: #003366;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .actions-bar button:hover, .actions-bar input[type="button"]:hover {
            background: #00509e;
        }
        .actions-bar .delete-btn {
            background: #c62828;
        }
        .actions-bar .delete-btn:hover {
            background: #a31515;
        }
        .actions-bar .disabled {
            background: #b0b0b0;
            color: #fff;
            cursor: not-allowed;
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
        @media (max-width: 1100px) {
            .content { max-width: 98vw; }
            .form-header { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 700px) {
            .form-header { grid-template-columns: 1fr; }
            .totals-bar, .actions-bar { flex-direction: column; gap: 12px; }
        }
    </style>
</head>
<body>
<div class="content">
    <h2>Fiche Demande d'Analyse et de Sondage</h2>
    <form>
        <div class="form-header">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" id="reference" name="reference">
            </div>
            <div class="form-group">
                <label for="num_autorisation">N° Autorisation</label>
                <input type="text" id="num_autorisation" name="num_autorisation">
            </div>
            <div class="form-group">
                <label for="num_dossier">N° Dossier</label>
                <input type="text" id="num_dossier" name="num_dossier">
            </div>
            <div class="form-group">
                <label for="nature">Nature</label>
                <select id="nature" name="nature">
                    <option>Nouveau Lot</option>
                    <option>Ancien Lot</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exportateur">Exportateurs</label>
                <select id="exportateur" name="exportateur">
                    <option>ACE EXPORT</option>
                    <option>COCOA CI</option>
                    <option>CAFÉ IVOIRE</option>
                </select>
            </div>
            <div class="form-group">
                <label for="produit">Produit</label>
                <select id="produit" name="produit">
                    <option>Cacao</option>
                    <option>Café</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ville">Ville</label>
                <select id="ville" name="ville">
                    <option>ABIDJAN</option>
                    <option>YAMOUSSOUKRO</option>
                    <option>BOUAKE</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_autorisation">Date Autorisation</label>
                <input type="date" id="date_autorisation" name="date_autorisation" value="<?php echo date('Y-m-d'); ?>">
                <input type="time" id="heure_autorisation" name="heure_autorisation" value="<?php echo date('H:i:s'); ?>">
            </div>
            <div class="form-group">
                <label for="date_validation">Date Validation</label>
                <input type="date" id="date_validation" name="date_validation" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                <input type="time" id="heure_validation" name="heure_validation" value="<?php echo date('H:i:s'); ?>">
            </div>
            <div class="form-group">
                <label for="campagne">Campagne</label>
                <select id="campagne" name="campagne">
                    <option>2024/2025</option>
                    <option>2023/2024</option>
                    <option>2022/2023</option>
                </select>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>N°Lot</th>
                        <th>Nbre de Sac</th>
                        <th>Poids Net</th>
                        <th>Marque</th>
                        <th>Magasin/Usine</th>
                        <th>Récolte</th>
                        <th>Qualité déclarée</th>
                        <th>Parité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>LOT001</td>
                        <td>50</td>
                        <td>3250</td>
                        <td>ACE2025</td>
                        <td>MAG1</td>
                        <td>2025</td>
                        <td>Supérieure</td>
                        <td>Oui</td>
                    </tr>
                    <tr>
                        <td>LOT002</td>
                        <td>40</td>
                        <td>2600</td>
                        <td>COCOA24</td>
                        <td>MAG2</td>
                        <td>2025</td>
                        <td>Standard</td>
                        <td>Non</td>
                    </tr>
                    <tr>
                        <td>LOT003</td>
                        <td>60</td>
                        <td>3900</td>
                        <td>CAFIV25</td>
                        <td>MAG3</td>
                        <td>2024</td>
                        <td>Supérieure</td>
                        <td>Oui</td>
                    </tr>
                    <tr>
                        <td>LOT004</td>
                        <td>30</td>
                        <td>1950</td>
                        <td>ACE2025</td>
                        <td>MAG1</td>
                        <td>2025</td>
                        <td>Standard</td>
                        <td>Non</td>
                    </tr>
                    <tr>
                        <td>LOT005</td>
                        <td>45</td>
                        <td>2925</td>
                        <td>COCOA24</td>
                        <td>MAG2</td>
                        <td>2025</td>
                        <td>Supérieure</td>
                        <td>Oui</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="totals-bar">
            <div class="total-group">
                <label>Nbre de Sacs</label>
                <span class="total-value">225</span>
            </div>
            <div class="total-group">
                <label>Total Poids Net (Kg)</label>
                <span class="total-value">14625</span>
            </div>
            <div class="total-group">
                <label>Nbre de Lots</label>
                <span class="total-value">5</span>
            </div>
        </div>
        <div class="actions-bar">
            <button type="submit">Valider</button>
            <button type="button" class="delete-btn">Supprimer le lot sélectionné</button>
            <button type="button" class="disabled" disabled>Ordre de Sondage</button>
            <button type="button">Saisir une série de lot</button>
        </div>
    </form>
</div>
<button class="back-btn" onclick="window.history.back();">⬅️ Retour</button>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>