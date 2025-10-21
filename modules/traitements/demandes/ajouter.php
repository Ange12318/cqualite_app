<?php 
$pageTitle = "Nouvelle Demande - Autorités Ivoirienne";
include('../../../includes/header.php'); 

// Inclure la configuration de la base de données
require_once('../../../config.php');

// Récupérer les campagnes depuis la base de données
try {
    $stmt = $pdo->query("SELECT CAMP_DEMANDE, DATE_DEBUT_CAMPAGNE, DATE_FIN_CAMPAGNE FROM campagne ORDER BY DATE_DEBUT_CAMPAGNE DESC");
    $campagnes = $stmt->fetchAll();
} catch (PDOException $e) {
    $campagnes = [];
    error_log("Erreur lors de la récupération des campagnes: " . $e->getMessage());
}

// Récupérer les exportateurs depuis la base de données
try {
    $stmt = $pdo->query("SELECT ID_EXPORTATEUR, CODE_EXPORTATEUR, RAISONSOCIALE_EXPORTATEUR FROM exportateurs ORDER BY RAISONSOCIALE_EXPORTATEUR");
    $exportateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    $exportateurs = [];
    error_log("Erreur lors de la récupération des exportateurs: " . $e->getMessage());
}

// Récupérer les produits depuis la base de données
try {
    $stmt = $pdo->query("SELECT ID_PRODUIT, LIBELLE_PRODUIT FROM produits ORDER BY LIBELLE_PRODUIT");
    $produits = $stmt->fetchAll();
} catch (PDOException $e) {
    $produits = [];
    error_log("Erreur lors de la récupération des produits: " . $e->getMessage());
}

// Récupérer les villes depuis poste_controle
try {
    $stmt = $pdo->query("SELECT DISTINCT VILLE_POSTE_CONTROLE FROM poste_controle WHERE VILLE_POSTE_CONTROLE IS NOT NULL ORDER BY VILLE_POSTE_CONTROLE");
    $villes = $stmt->fetchAll();
} catch (PDOException $e) {
    $villes = [];
    error_log("Erreur lors de la récupération des villes: " . $e->getMessage());
}

// Récupérer les marques depuis la base de données
try {
    $stmt = $pdo->query("SELECT ID_MARQUE, CODE_MARQUE, LIBELLE_MARQUE FROM marques ORDER BY LIBELLE_MARQUE");
    $marques = $stmt->fetchAll();
} catch (PDOException $e) {
    $marques = [];
    error_log("Erreur lors de la récupération des marques: " . $e->getMessage());
}

// Récupérer les magasins depuis la base de données
try {
    $stmt = $pdo->query("SELECT ID_MAGASIN, CODE_MAGASIN, NOM_MAGASIN FROM magasins ORDER BY NOM_MAGASIN");
    $magasins = $stmt->fetchAll();
} catch (PDOException $e) {
    $magasins = [];
    error_log("Erreur lors de la récupération des magasins: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 51, 102, 0.1);
        }

        .page-header {
            background: linear-gradient(135deg, #003366 0%, #0055aa 100%);
            color: white;
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
        }

        .content-section {
            padding: 30px 40px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #003366;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            background: white;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #003366;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .required-field {
            border-color: #dc2626 !important;
        }

        .required-field:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 5px;
            display: none;
        }

        .totals-section {
            background: #f8fafc;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .total-group {
            display: flex;
            flex-direction: column;
        }

        .total-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #003366;
            margin-bottom: 8px;
        }

        .total-value {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            background: white;
            color: #003366;
            text-align: center;
        }

        .table-section {
            margin-bottom: 30px;
        }

        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .data-table th {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            padding: 16px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .data-table tbody tr:hover td {
            background: #f8fafc;
        }

        .data-table input,
        .data-table select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.85rem;
            background: white;
        }

        .data-table input:focus,
        .data-table select:focus {
            border-color: #003366;
            outline: none;
        }

        .actions-section {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #047857, #059669);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: #003366;
            border: 2px solid #003366;
        }

        .btn-outline:hover {
            background: #003366;
            color: white;
        }

        .back-btn {
            position: fixed;
            left: 30px;
            bottom: 30px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 51, 102, 0.5);
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .main-container {
                border-radius: 16px;
            }
            
            .page-header {
                padding: 25px 30px;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .content-section {
                padding: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .totals-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-section {
                justify-content: stretch;
            }
            
            .btn {
                justify-content: center;
            }
            
            .back-btn {
                left: 20px;
                bottom: 20px;
                padding: 12px 20px;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .data-table {
                min-width: 1000px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-plus-circle"></i>
                Nouvelle Demande
            </h1>
            <p class="page-subtitle">
                Créer une nouvelle demande d'analyse pour les autorités ivoiriennes
            </p>
        </div>

        <div class="content-section">
            <form id="demandeForm">
                <!-- Informations de base -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="reference" class="form-label">
                            <i class="fas fa-hashtag"></i>
                            Référence *
                        </label>
                        <input type="text" id="reference" name="reference" class="form-control required" placeholder="REF-2024-XXX" required>
                        <div class="error-message" id="reference-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="num_autorisation" class="form-label">
                            <i class="fas fa-file-alt"></i>
                            N° Autorisation *
                        </label>
                        <input type="text" id="num_autorisation" name="num_autorisation" class="form-control required" placeholder="AUT-2024-XXX" required>
                        <div class="error-message" id="num_autorisation-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="num_dossier" class="form-label">
                            <i class="fas fa-folder"></i>
                            N° Dossier
                        </label>
                        <input type="text" id="num_dossier" name="num_dossier" class="form-control" placeholder="DOS-2024-XXX">
                    </div>
                    
                    <div class="form-group">
                        <label for="nature" class="form-label">
                            <i class="fas fa-tag"></i>
                            Nature *
                        </label>
                        <select id="nature" name="nature" class="form-control required" required>
                            <option value="">Sélectionner la nature</option>
                            <option value="nouveau">Nouveau Lot</option>
                            <option value="ancien">Ancien Lot</option>
                        </select>
                        <div class="error-message" id="nature-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exportateur" class="form-label">
                            <i class="fas fa-building"></i>
                            Exportateur *
                        </label>
                        <select id="exportateur" name="exportateur" class="form-control required" required>
                            <option value="">Sélectionner un exportateur</option>
                            <?php foreach($exportateurs as $exportateur): ?>
                                <option value="<?= htmlspecialchars($exportateur['ID_EXPORTATEUR']) ?>">
                                    <?= htmlspecialchars($exportateur['RAISONSOCIALE_EXPORTATEUR']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="exportateur-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="produit" class="form-label">
                            <i class="fas fa-seedling"></i>
                            Produit *
                        </label>
                        <select id="produit" name="produit" class="form-control required" required>
                            <option value="">Sélectionner un produit</option>
                            <?php foreach($produits as $produit): ?>
                                <option value="<?= htmlspecialchars($produit['ID_PRODUIT']) ?>">
                                    <?= htmlspecialchars($produit['LIBELLE_PRODUIT']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="produit-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ville" class="form-label">
                            <i class="fas fa-city"></i>
                            Ville *
                        </label>
                        <select id="ville" name="ville" class="form-control required" required>
                            <option value="">Sélectionner une ville</option>
                            <?php foreach($villes as $ville): ?>
                                <option value="<?= htmlspecialchars($ville['VILLE_POSTE_CONTROLE']) ?>">
                                    <?= htmlspecialchars($ville['VILLE_POSTE_CONTROLE']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="ville-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="campagne" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Campagne *
                        </label>
                        <select id="campagne" name="campagne" class="form-control required" required>
                            <option value="">Sélectionner une campagne</option>
                            <?php foreach($campagnes as $campagne): ?>
                                <option value="<?= htmlspecialchars($campagne['CAMP_DEMANDE']) ?>">
                                    <?= htmlspecialchars($campagne['CAMP_DEMANDE']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="campagne-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_autorisation" class="form-label">
                            <i class="fas fa-calendar"></i>
                            Date Autorisation *
                        </label>
                        <input type="date" id="date_autorisation" name="date_autorisation" class="form-control required" value="<?php echo date('Y-m-d'); ?>" required>
                        <div class="error-message" id="date_autorisation-error">Ce champ est obligatoire</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_validation" class="form-label">
                            <i class="fas fa-calendar-check"></i>
                            Date Validation
                        </label>
                        <input type="date" id="date_validation" name="date_validation" class="form-control" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                    </div>
                </div>

                <!-- Section des totaux -->
                <div class="totals-section">
                    <h3 style="color: #003366; margin-bottom: 20px;">
                        <i class="fas fa-calculator"></i>
                        Totaux Généraux
                    </h3>
                    <div class="totals-grid">
                        <div class="total-group">
                            <label class="total-label">Nombre de Sacs</label>
                            <input type="number" id="total_sacs" name="total_sacs" class="total-value" value="0" min="0" readonly>
                        </div>
                        
                        <div class="total-group">
                            <label class="total-label">Nombre de Lots</label>
                            <input type="number" id="total_lots" name="total_lots" class="total-value" value="0" min="0" readonly>
                        </div>
                        
                        <div class="total-group">
                            <label class="total-label">Total Poids Net (kg)</label>
                            <input type="number" id="total_poids" name="total_poids" class="total-value" value="0" min="0" step="0.01" readonly>
                        </div>
                    </div>
                </div>

                <!-- Tableau des lots -->
                <div class="table-section">
                    <h3 style="color: #003366; margin-bottom: 20px;">
                        <i class="fas fa-list"></i>
                        Détail des Lots
                    </h3>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>N° Lot</th>
                                    <th>Nbre de Sac</th>
                                    <th>Poids Net (kg)</th>
                                    <th>Marque</th>
                                    <th>Magasin/Usine</th>
                                    <th>Récolte</th>
                                    <th>Qualité déclarée</th>
                                    <th>Parité</th>
                                </tr>
                            </thead>
                            <tbody id="lotsTable">
                                <!-- Lignes de lots dynamiques -->
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                <tr data-lot="<?= $i ?>">
                                    <td>
                                        <input type="text" name="lots[<?= $i ?>][numero]" placeholder="LOT-<?= $i ?>" class="lot-input">
                                    </td>
                                    <td>
                                        <input type="number" name="lots[<?= $i ?>][sacs]" min="0" value="0" class="sacs-input" data-index="<?= $i ?>" oninput="calculerPoids(<?= $i ?>)">
                                    </td>
                                    <td>
                                        <input type="number" name="lots[<?= $i ?>][poids]" min="0" step="0.01" value="0" class="poids-input" data-index="<?= $i ?>" readonly>
                                    </td>
                                    <td>
                                        <select name="lots[<?= $i ?>][marque]" class="form-control">
                                            <option value="">-- Sélectionner --</option>
                                            <?php foreach($marques as $marque): ?>
                                                <option value="<?= htmlspecialchars($marque['ID_MARQUE']) ?>">
                                                    <?= htmlspecialchars($marque['LIBELLE_MARQUE']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="lots[<?= $i ?>][magasin]" class="form-control">
                                            <option value="">-- Sélectionner --</option>
                                            <?php foreach($magasins as $magasin): ?>
                                                <option value="<?= htmlspecialchars($magasin['ID_MAGASIN']) ?>">
                                                    <?= htmlspecialchars($magasin['NOM_MAGASIN']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="lots[<?= $i ?>][recolte]" placeholder="2024">
                                    </td>
                                    <td>
                                        <select name="lots[<?= $i ?>][qualite]" class="form-control">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="superieure">Supérieure</option>
                                            <option value="standard">Standard</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="lots[<?= $i ?>][parite]" class="form-control">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="oui">Oui</option>
                                            <option value="non">Non</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="actions-section">
                    <button type="button" class="btn btn-outline" onclick="window.history.back();">
                        <i class="fas fa-times"></i>
                        Annuler
                    </button>
                    <button type="button" class="btn btn-primary" onclick="ajouterLigne()">
                        <i class="fas fa-plus"></i>
                        Ajouter une Ligne
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Enregistrer la Demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour
    </button>

    <script>
        // Variables pour stocker les données
        let demandes = JSON.parse(localStorage.getItem('demandesAutorites')) || [];
        let lotCounter = 5;
        let produitSelectionne = '';

        // Fonction pour calculer le poids automatiquement
        function calculerPoids(index) {
            const produit = document.getElementById('produit').value;
            const sacsInput = document.querySelector(`.sacs-input[data-index="${index}"]`);
            const poidsInput = document.querySelector(`.poids-input[data-index="${index}"]`);
            
            const sacs = parseInt(sacsInput.value) || 0;
            let poids = 0;

            if (produit === 'CACAO') {
                // Pour le cacao : 1 lot = 385 sacs = 25,025 kg
                poids = sacs * (25025 / 385); // Calcul proportionnel
            } else if (produit === 'CAFE') {
                // Pour le café : 1 sac = 60 kg
                poids = sacs * 60;
            }

            poidsInput.value = poids.toFixed(2);
            calculerTotaux();
        }

        // Calcul des totaux
        function calculerTotaux() {
            let totalSacs = 0;
            let totalLots = 0;
            let totalPoids = 0;

            document.querySelectorAll('#lotsTable tr').forEach(row => {
                const sacs = parseInt(row.querySelector('.sacs-input').value) || 0;
                const poids = parseFloat(row.querySelector('.poids-input').value) || 0;
                
                if (sacs > 0 || poids > 0) {
                    totalSacs += sacs;
                    totalLots += 1;
                    totalPoids += poids;
                }
            });

            document.getElementById('total_sacs').value = totalSacs;
            document.getElementById('total_lots').value = totalLots;
            document.getElementById('total_poids').value = totalPoids.toFixed(2);
        }

        // Ajouter une ligne de lot
        function ajouterLigne() {
            lotCounter++;
            const tbody = document.getElementById('lotsTable');
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-lot', lotCounter);
            
            newRow.innerHTML = `
                <td>
                    <input type="text" name="lots[${lotCounter}][numero]" placeholder="LOT-${lotCounter}" class="lot-input">
                </td>
                <td>
                    <input type="number" name="lots[${lotCounter}][sacs]" min="0" value="0" class="sacs-input" data-index="${lotCounter}" oninput="calculerPoids(${lotCounter})">
                </td>
                <td>
                    <input type="number" name="lots[${lotCounter}][poids]" min="0" step="0.01" value="0" class="poids-input" data-index="${lotCounter}" readonly>
                </td>
                <td>
                    <select name="lots[${lotCounter}][marque]" class="form-control">
                        <option value="">-- Sélectionner --</option>
                        <?php foreach($marques as $marque): ?>
                            <option value="<?= htmlspecialchars($marque['ID_MARQUE']) ?>">
                                <?= htmlspecialchars($marque['LIBELLE_MARQUE']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="lots[${lotCounter}][magasin]" class="form-control">
                        <option value="">-- Sélectionner --</option>
                        <?php foreach($magasins as $magasin): ?>
                            <option value="<?= htmlspecialchars($magasin['ID_MAGASIN']) ?>">
                                <?= htmlspecialchars($magasin['NOM_MAGASIN']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="lots[${lotCounter}][recolte]" placeholder="2024">
                </td>
                <td>
                    <select name="lots[${lotCounter}][qualite]" class="form-control">
                        <option value="">-- Sélectionner --</option>
                        <option value="superieure">Supérieure</option>
                        <option value="standard">Standard</option>
                    </select>
                </td>
                <td>
                    <select name="lots[${lotCounter}][parite]" class="form-control">
                        <option value="">-- Sélectionner --</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select>
                </td>
            `;
            
            tbody.appendChild(newRow);
        }

        // Validation des champs obligatoires
        function validerFormulaire() {
            let isValid = true;
            const requiredFields = document.querySelectorAll('.required');
            
            requiredFields.forEach(field => {
                const errorElement = document.getElementById(field.id + '-error');
                if (!field.value.trim()) {
                    field.classList.add('required-field');
                    errorElement.style.display = 'block';
                    isValid = false;
                } else {
                    field.classList.remove('required-field');
                    errorElement.style.display = 'none';
                }
            });

            return isValid;
        }

        // Soumission du formulaire
        document.getElementById('demandeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validerFormulaire()) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }

            const formData = new FormData(this);
            const demande = {
                id: Date.now(),
                reference: formData.get('reference'),
                num_autorisation: formData.get('num_autorisation'),
                num_dossier: formData.get('num_dossier'),
                nature: formData.get('nature'),
                exportateur: formData.get('exportateur'),
                produit: formData.get('produit'),
                ville: formData.get('ville'),
                campagne: formData.get('campagne'),
                date_autorisation: formData.get('date_autorisation'),
                date_validation: formData.get('date_validation'),
                total_sacs: parseInt(formData.get('total_sacs')),
                total_lots: parseInt(formData.get('total_lots')),
                total_poids: parseFloat(formData.get('total_poids')),
                etat: 'en_attente',
                date_creation: new Date().toISOString(),
                lots: []
            };

            // Récupérer les lots
            for (let i = 1; i <= lotCounter; i++) {
                const sacs = parseInt(formData.get(`lots[${i}][sacs]`)) || 0;
                const poids = parseFloat(formData.get(`lots[${i}][poids]`)) || 0;
                
                if (sacs > 0 || poids > 0) {
                    demande.lots.push({
                        numero: formData.get(`lots[${i}][numero]`),
                        sacs: sacs,
                        poids: poids,
                        marque: formData.get(`lots[${i}][marque]`),
                        magasin: formData.get(`lots[${i}][magasin]`),
                        recolte: formData.get(`lots[${i}][recolte]`),
                        qualite: formData.get(`lots[${i}][qualite]`),
                        parite: formData.get(`lots[${i}][parite]`)
                    });
                }
            }

            // Sauvegarder dans le localStorage
            demandes.push(demande);
            localStorage.setItem('demandesAutorites', JSON.stringify(demandes));

            // Redirection vers la page liste
            alert('Demande enregistrée avec succès !');
            window.location.href = 'ivoirienne.php';
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Écouteur pour le changement de produit
            document.getElementById('produit').addEventListener('change', function() {
                produitSelectionne = this.value;
                // Réinitialiser tous les calculs de poids
                document.querySelectorAll('.sacs-input').forEach(input => {
                    const index = input.getAttribute('data-index');
                    calculerPoids(index);
                });
            });

            // Validation en temps réel des champs obligatoires
            document.querySelectorAll('.required').forEach(field => {
                field.addEventListener('input', function() {
                    const errorElement = document.getElementById(this.id + '-error');
                    if (this.value.trim()) {
                        this.classList.remove('required-field');
                        errorElement.style.display = 'none';
                    }
                });
            });

            // Calcul initial
            calculerTotaux();
        });
    </script>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>