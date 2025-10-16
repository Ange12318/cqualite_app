<?php 
$pageTitle = "Validation Résultats Café";
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
            grid-template-columns: repeat(4, 1fr);
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

        /* Style du tableau principal - CORRIGÉ POUR DÉFILEMENT */
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
            min-width: 2000px; /* Largeur minimale pour forcer le défilement */
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

        /* Style pour les champs de saisie dans le tableau */
        .table-input {
            width: 100%;
            padding: 6px 4px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.7rem;
            text-align: center;
            background: white;
            min-width: 60px;
        }

        .table-input:focus {
            border-color: #003366;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 51, 102, 0.1);
        }

        .table-select {
            width: 100%;
            padding: 6px 4px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.7rem;
            background: white;
            text-align: center;
            min-width: 80px;
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
                <i class="fas fa-check-circle"></i>
                Validation Résultats Café
            </h1>
            <p class="page-subtitle">
                Validation des analyses de qualité du café
            </p>
        </div>

        <div class="content-section">
            <!-- En-tête du formulaire -->
            <div class="form-header">
                <div class="form-title">Critères de Recherche</div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-hashtag"></i>
                            REF DEMANDE
                        </label>
                        <input type="text" class="form-control" placeholder="Saisir la référence">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Autorisation
                        </label>
                        <input type="text" class="form-control" placeholder="N° d'autorisation">
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
                            <i class="fas fa-building"></i>
                            Exportateur
                        </label>
                        <select class="form-control">
                            <option value="">Sélectionner</option>
                            <option value="ACE">ACE EXPORT</option>
                            <option value="COCOA">COCOA CI</option>
                            <option value="CAFE">CAFÉ IVOIRE</option>
                            <option value="ROBUSTA">ROBUSTA COFFEE</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i>
                            N° Lot
                        </label>
                        <input type="text" class="form-control" placeholder="N° du lot">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-list"></i>
                            Type
                        </label>
                        <input type="text" class="form-control" placeholder="Type d'analyse">
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

            <!-- Tableau principal - AVEC DÉFILEMENT -->
            <div class="scroll-indicator">
                <i class="fas fa-arrows-left-right"></i>
                Faites défiler horizontalement pour voir toutes les colonnes
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Valider</th>
                            <th>Ref Demande</th>
                            <th>Autorisation</th>
                            <th>Exportateur</th>
                            <th>Grade Déclaré</th>
                            <th>N°lot</th>
                            <th>Code secret</th>
                            <th>Analyseur</th>
                            <th>Campagne</th>
                            <th>Date d'analyse</th>
                            <th>Nombre Defauts</th>
                            <th>Poids defauts</th>
                            <th>Humidité</th>
                            <th>Tamis 18</th>
                            <th>Tamis 16</th>
                            <th>Tamis 14</th>
                            <th>Tamis 12</th>
                            <th>Tamis 10</th>
                            <th>Tamis bas</th>
                            <th>Normes Ivoirienne</th>
                            <th>Norme Internationnale</th>
                            <th>Conformitée</th>
                            <th>Remarque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ligne 1 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAF-2024-001</td>
                            <td>AUT-CAF-001</td>
                            <td>CAFÉ IVOIRE</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade A
                                </span>
                            </td>
                            <td>LOT-CAF-001</td>
                            <td>CS-CAF-789456</td>
                            <td>Analyseur Café A</td>
                            <td>2024/2025</td>
                            <td>08/10/2024</td>
                            <td><input type="text" class="table-input" value="12"></td>
                            <td><input type="text" class="table-input" value="45.2"></td>
                            <td><input type="text" class="table-input" value="11.5"></td>
                            <td><input type="text" class="table-input" value="85.2"></td>
                            <td><input type="text" class="table-input" value="12.5"></td>
                            <td><input type="text" class="table-input" value="2.1"></td>
                            <td><input type="text" class="table-input" value="0.2"></td>
                            <td><input type="text" class="table-input" value="0.0"></td>
                            <td><input type="text" class="table-input" value="0.0"></td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td><input type="text" class="table-input" placeholder="Qualité excellente"></td>
                        </tr>
                        
                        <!-- Ligne 2 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAF-2024-002</td>
                            <td>AUT-CAF-002</td>
                            <td>ROBUSTA COFFEE</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade B
                                </span>
                            </td>
                            <td>LOT-CAF-002</td>
                            <td>CS-CAF-789457</td>
                            <td>Analyseur Café B</td>
                            <td>2024/2025</td>
                            <td>07/10/2024</td>
                            <td><input type="text" class="table-input" value="28"></td>
                            <td><input type="text" class="table-input" value="89.6"></td>
                            <td><input type="text" class="table-input" value="13.2"></td>
                            <td><input type="text" class="table-input" value="72.8"></td>
                            <td><input type="text" class="table-input" value="18.9"></td>
                            <td><input type="text" class="table-input" value="6.3"></td>
                            <td><input type="text" class="table-input" value="1.8"></td>
                            <td><input type="text" class="table-input" value="0.2"></td>
                            <td><input type="text" class="table-input" value="0.0"></td>
                            <td>
                                <span class="status-badge status-non-conforme">
                                    <i class="fas fa-times"></i> Non Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-non-conforme">
                                    <i class="fas fa-times"></i> Non Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-non-conforme">
                                    <i class="fas fa-times"></i> Non Conforme
                                </span>
                            </td>
                            <td><input type="text" class="table-input" placeholder="Taux d'humidité élevé"></td>
                        </tr>
                        
                        <!-- Ligne 3 -->
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="check-input">
                            </td>
                            <td>REF-CAF-2024-003</td>
                            <td>AUT-CAF-003</td>
                            <td>CAFÉ IVOIRE</td>
                            <td>
                                <span class="grade-badge">
                                    <i class="fas fa-star"></i> Grade AA
                                </span>
                            </td>
                            <td>LOT-CAF-003</td>
                            <td>CS-CAF-789458</td>
                            <td>Analyseur Café C</td>
                            <td>2024/2025</td>
                            <td>06/10/2024</td>
                            <td><input type="text" class="table-input" value="8"></td>
                            <td><input type="text" class="table-input" value="32.1"></td>
                            <td><input type="text" class="table-input" value="10.8"></td>
                            <td><input type="text" class="table-input" value="91.5"></td>
                            <td><input type="text" class="table-input" value="7.2"></td>
                            <td><input type="text" class="table-input" value="1.1"></td>
                            <td><input type="text" class="table-input" value="0.2"></td>
                            <td><input type="text" class="table-input" value="0.0"></td>
                            <td><input type="text" class="table-input" value="0.0"></td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-conforme">
                                    <i class="fas fa-check"></i> Conforme
                                </span>
                            </td>
                            <td><input type="text" class="table-input" placeholder="Très bon calibrage"></td>
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
                <button type="button" class="btn btn-primary" onclick="validerSelection()">
                    <i class="fas fa-check-double"></i>
                    Valider la Sélection
                </button>
                <button type="button" class="btn btn-success" onclick="exporterResultats()">
                    <i class="fas fa-file-export"></i>
                    Exporter les Résultats
                </button>
                <button type="button" class="btn btn-outline" onclick="imprimerRapport()">
                    <i class="fas fa-print"></i>
                    Imprimer
                </button>
            </div>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour au Tableau de Bord
    </button>

    <script>
        // Fonction pour valider la sélection
        function validerSelection() {
            const selectedRows = document.querySelectorAll('.check-input:checked');
            if (selectedRows.length === 0) {
                showNotification('Veuillez sélectionner au moins une ligne à valider', 'warning');
                return;
            }

            if (confirm(`Êtes-vous sûr de vouloir valider ${selectedRows.length} ligne(s) sélectionnée(s) ?`)) {
                showNotification(`${selectedRows.length} ligne(s) validée(s) avec succès !`, 'success');
                
                // Simulation de validation
                selectedRows.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    row.style.backgroundColor = '#d4edda';
                });
            }
        }

        // Fonction pour exporter les résultats
        function exporterResultats() {
            showNotification('Export des résultats café en cours...', 'info');
            
            // Simulation d'export
            setTimeout(() => {
                showNotification('Résultats café exportés avec succès !', 'success');
            }, 2000);
        }

        // Fonction pour imprimer le rapport
        function imprimerRapport() {
            showNotification('Impression du rapport café en cours...', 'info');
            
            // Simulation d'impression
            setTimeout(() => {
                window.print();
            }, 1000);
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
    </script>
</body>
</html>
<?php include('../../../includes/footer.php'); ?>