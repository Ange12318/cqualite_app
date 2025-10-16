<?php 
$pageTitle = "Export BV Cacao";
include('../../../includes/header.php'); 
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

        /* Style pour l'en-tête du formulaire */
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

        /* Style du tableau principal */
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
            min-width: 2200px;
        }

        .data-table th {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            padding: 14px 6px;
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
            padding: 12px 4px;
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

        /* Style pour les cases à cocher */
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

        /* Style pour les statuts */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .status-conforme {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-non-conforme {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Style pour les grades */
        .grade-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            border: 1px solid rgba(59, 130, 246, 0.3);
            white-space: nowrap;
        }

        /* Style pour les classes */
        .class-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 600;
            background: rgba(168, 85, 247, 0.1);
            color: #7c3aed;
            border: 1px solid rgba(168, 85, 247, 0.3);
            white-space: nowrap;
        }

        /* Actions */
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

        /* Indicateur de défilement */
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
                <i class="fas fa-file-export"></i>
                Export BV Cacao
            </h1>
            <p class="page-subtitle">
                Export des Bulletins de Vente pour le cacao
            </p>
        </div>

        <div class="content-section">
            <!-- En-tête du formulaire -->
            <div class="form-header">
                <div class="form-title">Critères de Recherche pour l'Export</div>
                
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
                            <i class="fas fa-building"></i>
                            Exportateur
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="ACE_EXPORT">ACE EXPORT</option>
                            <option value="COCOA_CI">COCOA CI</option>
                            <option value="CACAO_PLUS">CACAO PLUS</option>
                            <option value="QUALI_CACAO">QUALI CACAO</option>
                            <option value="PRESTIGE_CACAO">PRESTIGE CACAO</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            N° Autorisation
                        </label>
                        <input type="text" class="form-control" placeholder="N° d'autorisation">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tags"></i>
                            N° de lots
                        </label>
                        <input type="text" class="form-control" placeholder="N° des lots">
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
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Campagne
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                            <option value="2022/2023">2022/2023</option>
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
                            <option value="DALOA">DALOA</option>
                            <option value="KORHOGO">KORHOGO</option>
                        </select>
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

            <!-- Tableau principal -->
            <div class="scroll-indicator">
                <i class="fas fa-arrows-left-right"></i>
                Faites défiler horizontalement pour voir toutes les colonnes
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Sélection</th>
                            <th>Ref Demande</th>
                            <th>Exportateur</th>
                            <th>Magasin</th>
                            <th>N°lots</th>
                            <th>Nbre sac</th>
                            <th>Recolte</th>
                            <th>Campagne</th>
                            <th>Grade Lot</th>
                            <th>Agent de Saisie</th>
                            <th>Date Analyse</th>
                            <th>Date Echantillons</th>
                            <th>Analyseur</th>
                            <th>Humidité</th>
                            <th>Grainage</th>
                            <th>Brisure</th>
                            <th>Déchet</th>
                            <th>Crabot</th>
                            <th>Matiere Etrangere</th>
                            <th>Moisie</th>
                            <th>Mitée</th>
                            <th>Ardoisée</th>
                            <th>Plate</th>
                            <th>Gemmée</th>
                            <th>Violette</th>
                            <th>Classe.. NI</th>
                            <th>Classe . NCC</th>
                            <th>Conforme</th>
                            <th>Ref BV BA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ligne 1 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAC-2024-001</td>
                            <td>ACE EXPORT</td>
                            <td>Magasin Principal</td>
                            <td>LOT-CAC-001</td>
                            <td>150</td>
                            <td>2024</td>
                            <td>2024/2025</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade Supérieur
                                </span>
                            </td>
                            <td>Agent A</td>
                            <td>08/10/2024</td>
                            <td>05/10/2024</td>
                            <td>Analyseur Cacao A</td>
                            <td>7.2%</td>
                            <td>85%</td>
                            <td>2.5%</td>
                            <td>1.2%</td>
                            <td>0.8%</td>
                            <td>0.3%</td>
                            <td>1.5%</td>
                            <td>0.8%</td>
                            <td>2.1%</td>
                            <td>1.2%</td>
                            <td>0.5%</td>
                            <td>0.9%</td>
                            <td>
                                <span class="class-badge">Classe I</span>
                            </td>
                            <td>
                                <span class="class-badge">Premium</span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>BV-CAC-2024-001</td>
                        </tr>
                        
                        <!-- Ligne 2 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAC-2024-002</td>
                            <td>COCOA CI</td>
                            <td>Magasin Nord</td>
                            <td>LOT-CAC-002</td>
                            <td>200</td>
                            <td>2024</td>
                            <td>2024/2025</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade Standard
                                </span>
                            </td>
                            <td>Agent B</td>
                            <td>07/10/2024</td>
                            <td>04/10/2024</td>
                            <td>Analyseur Cacao B</td>
                            <td>8.1%</td>
                            <td>78%</td>
                            <td>3.2%</td>
                            <td>2.1%</td>
                            <td>1.5%</td>
                            <td>0.9%</td>
                            <td>2.8%</td>
                            <td>1.9%</td>
                            <td>3.5%</td>
                            <td>2.2%</td>
                            <td>1.1%</td>
                            <td>1.8%</td>
                            <td>
                                <span class="class-badge">Classe II</span>
                            </td>
                            <td>
                                <span class="class-badge">Standard</span>
                            </td>
                            <td>
                                <span class="status-badge status-non-conforme">
                                    <i class="fas fa-times"></i> Non Conforme
                                </span>
                            </td>
                            <td>BV-CAC-2024-002</td>
                        </tr>
                        
                        <!-- Ligne 3 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAC-2024-003</td>
                            <td>CACAO PLUS</td>
                            <td>Magasin Sud</td>
                            <td>LOT-CAC-003</td>
                            <td>180</td>
                            <td>2024</td>
                            <td>2024/2025</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade Premium
                                </span>
                            </td>
                            <td>Agent C</td>
                            <td>06/10/2024</td>
                            <td>03/10/2024</td>
                            <td>Analyseur Cacao C</td>
                            <td>6.5%</td>
                            <td>92%</td>
                            <td>1.8%</td>
                            <td>0.9%</td>
                            <td>0.6%</td>
                            <td>0.2%</td>
                            <td>0.8%</td>
                            <td>0.3%</td>
                            <td>1.2%</td>
                            <td>0.8%</td>
                            <td>0.2%</td>
                            <td>0.5%</td>
                            <td>
                                <span class="class-badge">Classe I</span>
                            </td>
                            <td>
                                <span class="class-badge">Premium</span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>BV-CAC-2024-003</td>
                        </tr>
                        
                        <!-- Ligne 4 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAC-2024-004</td>
                            <td>QUALI CACAO</td>
                            <td>Magasin Est</td>
                            <td>LOT-CAC-004</td>
                            <td>220</td>
                            <td>2024</td>
                            <td>2024/2025</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade Commercial
                                </span>
                            </td>
                            <td>Agent D</td>
                            <td>05/10/2024</td>
                            <td>02/10/2024</td>
                            <td>Analyseur Cacao D</td>
                            <td>9.2%</td>
                            <td>72%</td>
                            <td>4.1%</td>
                            <td>3.2%</td>
                            <td>2.1%</td>
                            <td>1.5%</td>
                            <td>3.5%</td>
                            <td>2.8%</td>
                            <td>4.2%</td>
                            <td>3.1%</td>
                            <td>1.8%</td>
                            <td>2.5%</td>
                            <td>
                                <span class="class-badge">Classe III</span>
                            </td>
                            <td>
                                <span class="class-badge">Commercial</span>
                            </td>
                            <td>
                                <span class="status-badge status-non-conforme">
                                    <i class="fas fa-times"></i> Non Conforme
                                </span>
                            </td>
                            <td>BV-CAC-2024-004</td>
                        </tr>
                        
                        <!-- Ligne 5 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAC-2024-005</td>
                            <td>PRESTIGE CACAO</td>
                            <td>Magasin Ouest</td>
                            <td>LOT-CAC-005</td>
                            <td>190</td>
                            <td>2024</td>
                            <td>2024/2025</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade Supérieur
                                </span>
                            </td>
                            <td>Agent E</td>
                            <td>04/10/2024</td>
                            <td>01/10/2024</td>
                            <td>Analyseur Cacao E</td>
                            <td>7.8%</td>
                            <td>88%</td>
                            <td>2.8%</td>
                            <td>1.5%</td>
                            <td>1.1%</td>
                            <td>0.4%</td>
                            <td>1.2%</td>
                            <td>0.9%</td>
                            <td>1.8%</td>
                            <td>1.1%</td>
                            <td>0.6%</td>
                            <td>0.8%</td>
                            <td>
                                <span class="class-badge">Classe I</span>
                            </td>
                            <td>
                                <span class="class-badge">Premium</span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>BV-CAC-2024-005</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Actions -->
            <div class="actions-section">
                <button type="button" class="btn btn-outline" onclick="window.history.back();">
                    <i class="fas fa-times"></i>
                    Retour
                </button>
                <button type="button" class="btn btn-primary" onclick="exporterSelection()">
                    <i class="fas fa-file-export"></i>
                    Exporter la Sélection
                </button>
                <button type="button" class="btn btn-success" onclick="exporterTout()">
                    <i class="fas fa-download"></i>
                    Exporter Tout
                </button>
                <button type="button" class="btn btn-outline" onclick="genererBV()">
                    <i class="fas fa-file-pdf"></i>
                    Générer BV
                </button>
                <button type="button" class="btn btn-outline" onclick="genererBA()">
                    <i class="fas fa-file-alt"></i>
                    Générer BA
                </button>
            </div>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour au Tableau de Bord
    </button>

    <script>
        // Fonction pour exporter la sélection
        function exporterSelection() {
            const selectedRows = document.querySelectorAll('.check-input:checked');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins une ligne à exporter', 'warning');
                return;
            }

            if (confirm(`Êtes-vous sûr de vouloir exporter ${selectedRows.length} ligne(s) sélectionnée(s) ?`)) {
                showNotification(`Export de ${selectedRows.length} ligne(s) en cours...`, 'info');
                
                // Simulation d'export
                setTimeout(() => {
                    showNotification(`${selectedRows.length} ligne(s) exportées avec succès !`, 'success');
                }, 2000);
            }
        }

        // Fonction pour exporter tout
        function exporterTout() {
            if (confirm('Êtes-vous sûr de vouloir exporter tous les résultats ?')) {
                showNotification('Export de tous les résultats en cours...', 'info');
                
                // Simulation d'export
                setTimeout(() => {
                    showNotification('Tous les résultats exportés avec succès !', 'success');
                }, 3000);
            }
        }

        // Fonction pour générer BV
        function genererBV() {
            const selectedRows = document.querySelectorAll('.check-input:checked');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins une ligne pour générer le BV', 'warning');
                return;
            }

            showNotification('Génération du Bulletin de Vente en cours...', 'info');
            
            // Simulation de génération
            setTimeout(() => {
                showNotification('Bulletin de Vente généré avec succès !', 'success');
            }, 2000);
        }

        // Fonction pour générer BA
        function genererBA() {
            const selectedRows = document.querySelectorAll('.check-input:checked');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins une ligne pour générer le BA', 'warning');
                return;
            }

            showNotification('Génération du Bulletin d\'Analyse en cours...', 'info');
            
            // Simulation de génération
            setTimeout(() => {
                showNotification('Bulletin d\'Analyse généré avec succès !', 'success');
            }, 2000);
        }

        // Fonction pour afficher les notifications
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

        // Animation au chargement
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
        });

        // Sélection/désélection globale
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.createElement('input');
            selectAllCheckbox.type = 'checkbox';
            selectAllCheckbox.className = 'check-input';
            selectAllCheckbox.onclick = function() {
                const allCheckboxes = document.querySelectorAll('.check-input');
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            };

            const firstHeaderCell = document.querySelector('.data-table th:first-child');
            firstHeaderCell.innerHTML = '';
            firstHeaderCell.appendChild(selectAllCheckbox);
        });
    </script>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>