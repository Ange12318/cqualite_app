<?php 
$pageTitle = "Liste des Lots à Codifier";
include('../../includes/header.php'); 
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

        .form-header {
            background: #f8f9fa;
            border: 2px solid #003366;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .form-title {
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: #003366;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 15px;
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
            border-radius: 8px;
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

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .table-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 20px;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid #003366;
        }

        .table-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
            overflow-x: auto;
            max-width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
        }

        .data-table th {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            padding: 14px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .data-table td {
            padding: 12px 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
            background: white;
            white-space: nowrap;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .data-table tbody tr:hover {
            background: #e9ecef;
        }

        .checkbox-cell {
            text-align: center;
            position: sticky;
            left: 0;
            background: inherit;
            z-index: 5;
        }

        .data-table th:first-child {
            position: sticky;
            left: 0;
            z-index: 20;
        }

        .check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .status-a-codifier {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status-code {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .product-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .product-cacao {
            background: rgba(139, 69, 19, 0.1);
            color: #7c2d12;
            border: 1px solid rgba(139, 69, 19, 0.3);
        }

        .product-cafe {
            background: rgba(120, 53, 15, 0.1);
            color: #78350f;
            border: 1px solid rgba(120, 53, 15, 0.3);
        }

        .rapport-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rapport-disponible {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .rapport-disponible:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: translateY(-1px);
        }

        .rapport-indisponible {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        .decision-section {
            background: #f0f9ff;
            border: 2px solid #0ea5e9;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .decision-title {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .decision-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 0 auto;
        }

        .decision-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .decision-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #003366;
            text-align: center;
        }

        .actions-section {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
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
            box-shadow: 0 2px 8px rgba(0, 51, 102, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
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

        .scroll-indicator {
            text-align: center;
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .table-lots {
            min-width: 1400px;
        }

        .table-codes {
            min-width: 1000px;
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
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-list-ol"></i>
                Liste des Lots à Codifier
            </h1>
            <p class="page-subtitle">
                Gestion de la codification des lots pour analyse
            </p>
        </div>

        <div class="content-section">
            <div class="form-header">
                <div class="form-title">Critères de Recherche</div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-hashtag"></i>
                            Référence
                        </label>
                        <input type="text" class="form-control" placeholder="Saisir la référence">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder"></i>
                            N° Dossier
                        </label>
                        <input type="text" class="form-control" placeholder="N° de dossier">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            N° Lots
                        </label>
                        <input type="text" class="form-control" placeholder="N° des lots">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-building"></i>
                            Exportateur
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="ACE_EXPORT">ACE EXPORT</option>
                            <option value="COCOA_CI">COCOA CI</option>
                            <option value="CAFE_IVOIRE">CAFÉ IVOIRE</option>
                            <option value="ROBUSTA">ROBUSTA COFFEE</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-seedling"></i>
                            Produit
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="CACAO">Cacao</option>
                            <option value="CAFE">Café</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-list"></i>
                            Type
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="STANDARD">Standard</option>
                            <option value="PREMIUM">Premium</option>
                            <option value="EXPERT">Expert</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Récolte
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-city"></i>
                            Ville
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="ABIDJAN">ABIDJAN</option>
                            <option value="YAMOUSSOUKRO">YAMOUSSOUKRO</option>
                            <option value="BOUAKE">BOUAKE</option>
                            <option value="SANPEDRO">SAN PEDRO</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i>
                            Date Début
                        </label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i>
                            Date Fin
                        </label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Rechercher
                    </button>
                    <button type="button" class="btn btn-outline">
                        <i class="fas fa-redo"></i>
                        Réinitialiser
                    </button>
                </div>
            </div>

            <div class="table-section">
                <div class="section-title">
                    <i class="fas fa-table"></i>
                    Lots à Codifier
                </div>
                
                <div class="scroll-indicator">
                    <i class="fas fa-arrows-left-right"></i>
                    Faites défiler horizontalement pour voir toutes les colonnes
                </div>

                <div class="table-wrapper">
                    <table class="data-table table-lots">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="check-input" id="selectAll"></th>
                                <th>Numero lots</th>
                                <th>N°dossier</th>
                                <th>Reference</th>
                                <th>Produit</th>
                                <th>Ville</th>
                                <th>Exportateurs</th>
                                <th>Date reception</th>
                                <th>Date expiration</th>
                                <th>Recolte</th>
                                <th>Magasin</th>
                                <th>Grade lot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="check-input">
                                </td>
                                <td>NUM-LOT-001</td>
                                <td>DOS-2024-001</td>
                                <td>REF-COD-2024-001</td>
                                <td>
                                    <span class="product-badge product-cacao">
                                        <i class="fas fa-seedling"></i> Cacao
                                    </span>
                                </td>
                                <td>ABIDJAN</td>
                                <td>ACE EXPORT</td>
                                <td>08/10/2024</td>
                                <td>08/11/2024</td>
                                <td>2024</td>
                                <td>Magasin Centre</td>
                                <td>
                                    <span class="status-badge status-a-codifier">
                                        <i class="fas fa-clock"></i> À codifier
                                    </span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="check-input">
                                </td>
                                <td>NUM-LOT-002</td>
                                <td>DOS-2024-002</td>
                                <td>REF-COD-2024-002</td>
                                <td>
                                    <span class="product-badge product-cafe">
                                        <i class="fas fa-coffee"></i> Café
                                    </span>
                                </td>
                                <td>YAMOUSSOUKRO</td>
                                <td>ROBUSTA COFFEE</td>
                                <td>07/10/2024</td>
                                <td>07/11/2024</td>
                                <td>2024</td>
                                <td>Magasin Nord</td>
                                <td>
                                    <span class="status-badge status-code">
                                        <i class="fas fa-check"></i> Codifié
                                    </span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="check-input">
                                </td>
                                <td>NUM-LOT-003</td>
                                <td>DOS-2024-003</td>
                                <td>REF-COD-2024-003</td>
                                <td>
                                    <span class="product-badge product-cacao">
                                        <i class="fas fa-seedling"></i> Cacao
                                    </span>
                                </td>
                                <td>BOUAKE</td>
                                <td>COCOA CI</td>
                                <td>06/10/2024</td>
                                <td>06/11/2024</td>
                                <td>2024</td>
                                <td>Magasin Sud</td>
                                <td>
                                    <span class="status-badge status-a-codifier">
                                        <i class="fas fa-clock"></i> À codifier
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-section">
                <div class="section-title">
                    <i class="fas fa-key"></i>
                    Codes Secrets
                </div>
                
                <div class="scroll-indicator">
                    <i class="fas fa-arrows-left-right"></i>
                    Faites défiler horizontalement pour voir toutes les colonnes
                </div>

                <div class="table-wrapper">
                    <table class="data-table table-codes">
                        <thead>
                            <tr>
                                <th>Code secret</th>
                                <th>Numero lot</th>
                                <th>Date sondage</th>
                                <th>Date codification</th>
                                <th>Codifié par</th>
                                <th>Sondeur</th>
                                <th>Rapport</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CS-789456123</td>
                                <td>NUM-LOT-001</td>
                                <td>05/10/2024</td>
                                <td>-</td>
                                <td>-</td>
                                <td>Sondeur A</td>
                                <td>
                                    <span class="rapport-badge rapport-disponible" onclick="voirRapport('NUM-LOT-001')">
                                        <i class="fas fa-eye"></i> Voir
                                    </span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>CS-789456124</td>
                                <td>NUM-LOT-002</td>
                                <td>04/10/2024</td>
                                <td>07/10/2024</td>
                                <td>Codeur B</td>
                                <td>Sondeur B</td>
                                <td>
                                    <span class="rapport-badge rapport-disponible" onclick="voirRapport('NUM-LOT-002')">
                                        <i class="fas fa-eye"></i> Voir
                                    </span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>CS-789456125</td>
                                <td>NUM-LOT-003</td>
                                <td>03/10/2024</td>
                                <td>-</td>
                                <td>-</td>
                                <td>Sondeur C</td>
                                <td>
                                    <span class="rapport-badge rapport-indisponible">
                                        <i class="fas fa-times"></i> N/A
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="decision-section">
                <div class="decision-title">
                    <i class="fas fa-question-circle"></i>
                    Décision de Codification
                </div>
                <div class="decision-form">
                    <div class="decision-group">
                        <label class="decision-label">Codifier ?</label>
                        <select class="form-control">
                            <option value="">-- Sélectionner --</option>
                            <option value="oui">Oui</option>
                            <option value="non">Non</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-success" onclick="validerCodification()">
                            <i class="fas fa-check"></i>
                            Valider la Décision
                        </button>
                    </div>
                </div>
            </div>

            <div class="actions-section">
                <button type="button" class="btn btn-outline" onclick="window.history.back();">
                    <i class="fas fa-times"></i>
                    Retour
                </button>
                <button type="button" class="btn btn-primary" onclick="codifierSelection()">
                    <i class="fas fa-code"></i>
                    Codifier la Sélection
                </button>
                <button type="button" class="btn btn-success" onclick="genererCodes()">
                    <i class="fas fa-key"></i>
                    Générer Codes
                </button>
                <button type="button" class="btn btn-outline" onclick="exporterListe()">
                    <i class="fas fa-file-export"></i>
                    Exporter Liste
                </button>
                <a href="init_code.php" class="btn btn-outline">
                    <i class="fas fa-cog"></i>
                    Init Code du Jour
                </a>
            </div>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour au Tableau de Bord
    </button>

    <script>
        function codifierSelection() {
            const selectedRows = document.querySelectorAll('.check-input:checked:not(#selectAll)');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins un lot à codifier', 'warning');
                return;
            }

            if (confirm(`Êtes-vous sûr de vouloir codifier ${selectedRows.length} lot(s) sélectionné(s) ?`)) {
                showNotification(`Codification de ${selectedRows.length} lot(s) en cours...`, 'info');
                
                setTimeout(() => {
                    selectedRows.forEach(checkbox => {
                        const row = checkbox.closest('tr');
                        const statusCell = row.querySelector('.status-badge');
                        const lotNum = row.cells[1].textContent;
                        
                        statusCell.className = 'status-badge status-code';
                        statusCell.innerHTML = '<i class="fas fa-check"></i> Codifié';
                        
                        updateCodesTable(lotNum);
                        
                        row.style.backgroundColor = '#d4edda';
                    });
                    showNotification(`${selectedRows.length} lot(s) codifié(s) avec succès !`, 'success');
                }, 2000);
            }
        }

        function updateCodesTable(lotNum) {
            const codesTable = document.querySelector('.table-codes tbody');
            const rows = codesTable.querySelectorAll('tr');
            
            rows.forEach(row => {
                if (row.cells[1].textContent === lotNum) {
                    const dateCell = row.cells[3];
                    const codeurCell = row.cells[4];
                    const rapportCell = row.cells[6];
                    
                    dateCell.textContent = new Date().toLocaleDateString('fr-FR');
                    codeurCell.textContent = 'Codeur ' + String.fromCharCode(65 + Math.floor(Math.random() * 3));
                    rapportCell.innerHTML = '<span class="rapport-badge rapport-disponible" onclick="voirRapport(\'' + lotNum + '\')"><i class="fas fa-eye"></i> Voir</span>';
                }
            });
        }

        function validerCodification() {
            const decision = document.querySelector('.decision-section select').value;
            if (!decision) {
                showNotification('Veuillez sélectionner une décision', 'warning');
                return;
            }

            const selectedRows = document.querySelectorAll('.check-input:checked:not(#selectAll)');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins un lot', 'warning');
                return;
            }

            const action = decision === 'oui' ? 'codifier' : 'ne pas codifier';
            if (confirm(`Êtes-vous sûr de vouloir ${action} ${selectedRows.length} lot(s) sélectionné(s) ?`)) {
                showNotification(`Décision appliquée à ${selectedRows.length} lot(s)...`, 'info');
                
                setTimeout(() => {
                    if (decision === 'oui') {
                        selectedRows.forEach(checkbox => {
                            const row = checkbox.closest('tr');
                            const statusCell = row.querySelector('.status-badge');
                            const lotNum = row.cells[1].textContent;
                            
                            statusCell.className = 'status-badge status-code';
                            statusCell.innerHTML = '<i class="fas fa-check"></i> Codifié';
                            updateCodesTable(lotNum);
                            row.style.backgroundColor = '#d4edda';
                        });
                    }
                    showNotification(`Décision "${decision}" appliquée avec succès !`, 'success');
                }, 2000);
            }
        }

        function genererCodes() {
            const selectedRows = document.querySelectorAll('.check-input:checked:not(#selectAll)');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins un lot pour générer les codes', 'warning');
                return;
            }

            showNotification('Génération des codes en cours...', 'info');
            
            setTimeout(() => {
                selectedRows.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const lotNum = row.cells[1].textContent;
                    
                    const codeSecret = 'CS-' + Math.floor(100000000 + Math.random() * 900000000);
                    updateCodeSecret(lotNum, codeSecret);
                });
                showNotification('Codes générés avec succès !', 'success');
            }, 2000);
        }

        function updateCodeSecret(lotNum, codeSecret) {
            const codesTable = document.querySelector('.table-codes tbody');
            const rows = codesTable.querySelectorAll('tr');
            
            rows.forEach(row => {
                if (row.cells[1].textContent === lotNum) {
                    row.cells[0].textContent = codeSecret;
                }
            });
        }

        function voirRapport(lotNum) {
            showNotification(`Ouverture du rapport ${lotNum}...`, 'info');
            
            setTimeout(() => {
                showNotification(`Rapport ${lotNum} ouvert avec succès !`, 'success');
            }, 1000);
        }

        function exporterListe() {
            showNotification('Export de la liste en cours...', 'info');
            
            setTimeout(() => {
                showNotification('Liste exportée avec succès !', 'success');
            }, 2000);
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? '#28a745' : type === 'warning' ? '#ffc107' : '#007bff';
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background: ${bgColor};
                color: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 10000;
                font-weight: 600;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.data-table tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, index * 100);
            });

            const selectAllCheckbox = document.getElementById('selectAll');
            selectAllCheckbox.onclick = function() {
                const allCheckboxes = document.querySelectorAll('.check-input:not(#selectAll)');
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            };
        });
    </script>
</body>
</html>

<?php include('../../includes/footer.php'); ?>