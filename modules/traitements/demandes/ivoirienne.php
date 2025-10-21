<?php 
$pageTitle = "Demandes Autorités Ivoirienne";
include('../../../includes/header.php'); 

// Inclure la configuration de la base de données
require_once('../../../config.php');

// Récupérer les campagnes depuis la base de données
try {
    $stmt = $pdo->query("SELECT CAMP_DEMANDE, DATE_DEBUT_CAMPAGNE, DATE_FIN_CAMPAGNE, ETAT_CAMPAGNE FROM campagne ORDER BY DATE_DEBUT_CAMPAGNE DESC");
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

// Récupérer les demandes avec leurs relations
try {
    $sql = "SELECT 
                d.ID_DEMANDE,
                d.REF_DEMANDE,
                d.AUT_DEMANDE,
                d.DATEEMI_DEMANDE,
                d.DATEREC_DEMANDE,
                d.CAMP_DEMANDE,
                d.NBRELOT_DEMANDE,
                d.POIDS_DEMANDE,
                d.NBRE_BV_DEMANDE,
                d.NBRE_BA_DEMANDE,
                d.ETAT_DEMANDE,
                d.DATE_EXPIR_DEMANDE,
                p.LIBELLE_PRODUIT,
                e.RAISONSOCIALE_EXPORTATEUR,
                e.VILLE_EXPORTATEUR,
                pc.VILLE_POSTE_CONTROLE
            FROM demandes d
            LEFT JOIN produits p ON d.ID_PRODUIT = p.ID_PRODUIT
            LEFT JOIN exportateurs e ON d.ID_EXPORTATEUR = e.ID_EXPORTATEUR
            LEFT JOIN poste_controle pc ON d.CODE_POSTE_CONTROLE = pc.CODE_POSTE_CONTROLE
            ORDER BY d.DATEREC_DEMANDE DESC";
    
    $stmt = $pdo->query($sql);
    $demandes = $stmt->fetchAll();
} catch (PDOException $e) {
    $demandes = [];
    error_log("Erreur lors de la récupération des demandes: " . $e->getMessage());
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
            max-width: 98vw;
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

        .filters-section {
            background: #f8fafc;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #003366;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-control {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            background: white;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .filter-control:focus {
            border-color: #003366;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .actions-toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            align-items: center;
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

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
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

        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
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
            position: relative;
        }

        .data-table th::after {
            content: '';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid rgba(255, 255, 255, 0.6);
        }

        .data-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:hover td {
            background: #f8fafc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status-pending:hover {
            background: rgba(245, 158, 11, 0.2);
            transform: translateY(-1px);
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-approved:hover {
            background: rgba(16, 185, 129, 0.2);
            transform: translateY(-1px);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-rejected:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-1px);
        }

        .product-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(0, 51, 102, 0.1);
            color: #003366;
            border: 1px solid rgba(0, 51, 102, 0.2);
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
        }

        .total-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .total-card {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .pagination-btn:hover {
            border-color: #003366;
            color: #003366;
        }

        .pagination-btn.active {
            background: #003366;
            color: white;
            border-color: #003366;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #475569;
        }

        @media (max-width: 1024px) {
            .filters-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .content-section {
                padding: 25px 30px;
            }
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
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .content-section {
                padding: 20px;
            }
            
            .actions-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                justify-content: center;
            }
            
            .footer-section {
                flex-direction: column;
                gap: 20px;
                text-align: center;
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
                <i class="fas fa-building-columns"></i>
                Demandes Autorités Ivoirienne
            </h1>
            <p class="page-subtitle">
                Gestion des demandes d'analyse et de sondage des autorités ivoiriennes
            </p>
        </div>

        <div class="content-section">
            <!-- Section Filtres -->
            <div class="filters-section">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="reference" class="filter-label">
                            <i class="fas fa-hashtag"></i>
                            Référence
                        </label>
                        <input type="text" id="reference" name="reference" class="filter-control" placeholder="Saisir la référence">
                    </div>
                    
                    <div class="filter-group">
                        <label for="num_autorisation" class="filter-label">
                            <i class="fas fa-file-alt"></i>
                            N° Autorisation
                        </label>
                        <input type="text" id="num_autorisation" name="num_autorisation" class="filter-control" placeholder="Numéro d'autorisation">
                    </div>
                    
                    <div class="filter-group">
                        <label for="exportateur" class="filter-label">
                            <i class="fas fa-building"></i>
                            Exportateur
                        </label>
                        <select id="exportateur" name="exportateur" class="filter-control">
                            <option value="">Tous les exportateurs</option>
                            <?php foreach($exportateurs as $exportateur): ?>
                                <option value="<?= htmlspecialchars($exportateur['ID_EXPORTATEUR']) ?>">
                                    <?= htmlspecialchars($exportateur['RAISONSOCIALE_EXPORTATEUR']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="produit" class="filter-label">
                            <i class="fas fa-seedling"></i>
                            Produit
                        </label>
                        <select id="produit" name="produit" class="filter-control">
                            <option value="">Tous les produits</option>
                            <?php foreach($produits as $produit): ?>
                                <option value="<?= htmlspecialchars($produit['ID_PRODUIT']) ?>">
                                    <?= htmlspecialchars($produit['LIBELLE_PRODUIT']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="date_debut" class="filter-label">
                            <i class="fas fa-calendar"></i>
                            Date Début
                        </label>
                        <input type="date" id="date_debut" name="date_debut" class="filter-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label for="date_fin" class="filter-label">
                            <i class="fas fa-calendar"></i>
                            Date Fin
                        </label>
                        <input type="date" id="date_fin" name="date_fin" class="filter-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label for="campagne" class="filter-label">
                            <i class="fas fa-calendar-alt"></i>
                            Campagne
                        </label>
                        <select id="campagne" name="campagne" class="filter-control">
                            <option value="">Toutes les campagnes</option>
                            <?php foreach($campagnes as $campagne): ?>
                                <option value="<?= htmlspecialchars($campagne['CAMP_DEMANDE']) ?>">
                                    <?= htmlspecialchars($campagne['CAMP_DEMANDE']) ?> 
                                    <?php if($campagne['DATE_DEBUT_CAMPAGNE'] && $campagne['DATE_FIN_CAMPAGNE']): ?>
                                        (<?= date('d/m/Y', strtotime($campagne['DATE_DEBUT_CAMPAGNE'])) ?> - <?= date('d/m/Y', strtotime($campagne['DATE_FIN_CAMPAGNE'])) ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="ville" class="filter-label">
                            <i class="fas fa-city"></i>
                            Ville
                        </label>
                        <select id="ville" name="ville" class="filter-control">
                            <option value="">Toutes les villes</option>
                            <?php foreach($villes as $ville): ?>
                                <option value="<?= htmlspecialchars($ville['VILLE_POSTE_CONTROLE']) ?>">
                                    <?= htmlspecialchars($ville['VILLE_POSTE_CONTROLE']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Barre d'actions -->
            <div class="actions-toolbar">
                <button type="button" class="btn btn-primary" onclick="actualiserDonnees()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
                <a href="/cqualite_app/modules/traitements/demandes/ajouter.php" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                    Nouvelle Demande
                </a>
                <button type="button" class="btn btn-outline">
                    <i class="fas fa-edit"></i>
                    Modifier
                </button>
                <button type="button" class="btn btn-danger" onclick="supprimerSelection()">
                    <i class="fas fa-trash"></i>
                    Supprimer
                </button>
                <button type="button" class="btn btn-outline">
                    <i class="fas fa-print"></i>
                    Imprimer
                </button>
                <button type="button" class="btn btn-outline">
                    <i class="fas fa-download"></i>
                    Exporter
                </button>
            </div>

            <!-- Tableau des données -->
            <div class="table-container">
                <table class="data-table" id="demandesTable">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Produit</th>
                            <th>Ville</th>
                            <th>Exportateur</th>
                            <th>Date Réception</th>
                            <th>Date Expiration</th>
                            <th>Campagne</th>
                            <th>Nbre Lots</th>
                            <th>Poids Net</th>
                            <th>Nbre BV</th>
                            <th>Nbre BA</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody id="demandesBody">
                        <!-- Les données seront chargées dynamiquement -->
                    </tbody>
                </table>
            </div>

            <!-- Pied de page -->
            <div class="footer-section">
                <div class="total-info">
                    <div class="total-card" id="totalLots">
                        <i class="fas fa-boxes"></i>
                        Total Lots: 0
                    </div>
                    <div class="total-card" id="totalPoids">
                        <i class="fas fa-weight-hanging"></i>
                        Poids Total: 0 kg
                    </div>
                </div>
                
                <div class="pagination">
                    <button class="pagination-btn" onclick="changerPage(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <button class="pagination-btn">10</button>
                    <button class="pagination-btn" onclick="changerPage(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour
    </button>

    <script>
        // Variables globales
        let demandes = <?= json_encode($demandes) ?>;
        let currentPage = 1;
        const itemsPerPage = 10;

        // Charger les données depuis PHP
        function chargerDonnees() {
            afficherDemandes();
            calculerTotaux();
        }

        // Afficher les demandes dans le tableau
        function afficherDemandes() {
            const tbody = document.getElementById('demandesBody');
            tbody.innerHTML = '';

            if (demandes.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="12">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h3>Aucune demande trouvée</h3>
                                <p>Créez votre première demande en cliquant sur "Nouvelle Demande"</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            // Appliquer les filtres
            const filteredDemandes = appliquerFiltres(demandes);

            // Pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedDemandes = filteredDemandes.slice(startIndex, endIndex);

            paginatedDemandes.forEach(demande => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${demande.REF_DEMANDE || '-'}</strong></td>
                    <td>
                        <span class="product-badge">
                            <i class="fas fa-${getProductIcon(demande.LIBELLE_PRODUIT)}"></i>
                            ${demande.LIBELLE_PRODUIT || 'Non spécifié'}
                        </span>
                    </td>
                    <td>${demande.VILLE_POSTE_CONTROLE || demande.VILLE_EXPORTATEUR || '-'}</td>
                    <td>${demande.RAISONSOCIALE_EXPORTATEUR || '-'}</td>
                    <td>${formaterDate(demande.DATEREC_DEMANDE)}</td>
                    <td>${formaterDate(demande.DATE_EXPIR_DEMANDE)}</td>
                    <td>${demande.CAMP_DEMANDE || '-'}</td>
                    <td><strong>${demande.NBRELOT_DEMANDE || 0}</strong></td>
                    <td>${(demande.POIDS_DEMANDE || 0).toLocaleString()} kg</td>
                    <td><strong>${demande.NBRE_BV_DEMANDE || 0}</strong></td>
                    <td><strong>${demande.NBRE_BA_DEMANDE || 0}</strong></td>
                    <td>
                        <button class="status-btn status-${getEtatClass(demande.ETAT_DEMANDE)}">
                            <i class="fas fa-${getEtatIcon(demande.ETAT_DEMANDE)}"></i>
                            ${getEtatText(demande.ETAT_DEMANDE)}
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Appliquer les filtres
        function appliquerFiltres(demandes) {
            const reference = document.getElementById('reference').value.toLowerCase();
            const numAutorisation = document.getElementById('num_autorisation').value.toLowerCase();
            const exportateur = document.getElementById('exportateur').value;
            const produit = document.getElementById('produit').value;
            const dateDebut = document.getElementById('date_debut').value;
            const dateFin = document.getElementById('date_fin').value;
            const campagne = document.getElementById('campagne').value;
            const ville = document.getElementById('ville').value;

            return demandes.filter(demande => {
                return (!reference || (demande.REF_DEMANDE && demande.REF_DEMANDE.toLowerCase().includes(reference))) &&
                       (!numAutorisation || (demande.AUT_DEMANDE && demande.AUT_DEMANDE.toLowerCase().includes(numAutorisation))) &&
                       (!exportateur || demande.ID_EXPORTATEUR == exportateur) &&
                       (!produit || demande.ID_PRODUIT == produit) &&
                       (!dateDebut || (demande.DATEREC_DEMANDE && demande.DATEREC_DEMANDE >= dateDebut)) &&
                       (!dateFin || (demande.DATEREC_DEMANDE && demande.DATEREC_DEMANDE <= dateFin)) &&
                       (!campagne || demande.CAMP_DEMANDE === campagne) &&
                       (!ville || (demande.VILLE_POSTE_CONTROLE && demande.VILLE_POSTE_CONTROLE === ville));
            });
        }

        // Fonctions utilitaires pour les états
        function getEtatClass(etat) {
            if (!etat) return 'pending';
            const etatLower = etat.toLowerCase();
            if (etatLower.includes('valid') || etatLower.includes('approuv')) return 'approved';
            if (etatLower.includes('rejet') || etatLower.includes('refus')) return 'rejected';
            return 'pending';
        }

        function getEtatIcon(etat) {
            if (!etat) return 'clock';
            const etatLower = etat.toLowerCase();
            if (etatLower.includes('valid') || etatLower.includes('approuv')) return 'check';
            if (etatLower.includes('rejet') || etatLower.includes('refus')) return 'times';
            return 'clock';
        }

        function getEtatText(etat) {
            if (!etat) return 'En attente';
            const etatLower = etat.toLowerCase();
            if (etatLower.includes('valid') || etatLower.includes('approuv')) return 'Validé';
            if (etatLower.includes('rejet') || etatLower.includes('refus')) return 'Rejeté';
            return etat;
        }

        function getProductIcon(produit) {
            if (!produit) return 'box';
            const produitLower = produit.toLowerCase();
            if (produitLower.includes('cacao') || produitLower.includes('cocoa')) return 'seedling';
            if (produitLower.includes('cafe') || produitLower.includes('coffee')) return 'coffee';
            return 'box';
        }

        function formaterDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        }

        // Calculer les totaux
        function calculerTotaux() {
            const filteredDemandes = appliquerFiltres(demandes);
            const totalLots = filteredDemandes.reduce((sum, d) => sum + (d.NBRELOT_DEMANDE || 0), 0);
            const totalPoids = filteredDemandes.reduce((sum, d) => sum + (d.POIDS_DEMANDE || 0), 0);

            document.getElementById('totalLots').innerHTML = 
                `<i class="fas fa-boxes"></i> Total Lots: ${totalLots}`;
            document.getElementById('totalPoids').innerHTML = 
                `<i class="fas fa-weight-hanging"></i> Poids Total: ${totalPoids.toLocaleString()} kg`;
        }

        function actualiserDonnees() {
            location.reload();
        }

        function supprimerSelection() {
            if (confirm('Êtes-vous sûr de vouloir supprimer les demandes sélectionnées ?')) {
                showNotification('Fonctionnalité de suppression à implémenter', 'info');
            }
        }

        function changerPage(direction) {
            const totalPages = Math.ceil(appliquerFiltres(demandes).length / itemsPerPage);
            const newPage = currentPage + direction;
            
            if (newPage >= 1 && newPage <= totalPages) {
                currentPage = newPage;
                afficherDemandes();
                updatePagination();
            }
        }

        function updatePagination() {
            // Implémentation de la mise à jour de la pagination
            const totalPages = Math.ceil(appliquerFiltres(demandes).length / itemsPerPage);
            const paginationContainer = document.querySelector('.pagination');
            
            // Mettre à jour les boutons de pagination
            const buttons = paginationContainer.querySelectorAll('.pagination-btn');
            buttons.forEach(btn => {
                if (!btn.querySelector('i')) {
                    const pageNum = parseInt(btn.textContent);
                    if (pageNum === currentPage) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                }
            });
        }

        function showNotification(message, type) {
            // Créer une notification simple
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                z-index: 10000;
                font-weight: 600;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            chargerDonnees();
            
            // Ajouter les écouteurs d'événements pour les filtres
            document.querySelectorAll('.filter-control').forEach(input => {
                input.addEventListener('input', function() {
                    currentPage = 1;
                    afficherDemandes();
                    calculerTotaux();
                });
            });
        });
    </script>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>