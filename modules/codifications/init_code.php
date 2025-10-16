<?php 
$pageTitle = "Initialisation du Code du Jour";
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
            position: relative;
            z-index: 1;
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        .content-section {
            padding: 40px;
        }

        .info-card {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 2px solid #0ea5e9;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-card h2 {
            color: #0369a1;
            font-size: 1.5rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .info-card p {
            color: #075985;
            font-size: 1rem;
            line-height: 1.6;
        }

        .current-code-section {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .current-code-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .code-display {
            background: white;
            border: 3px dashed #003366;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .code-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #003366;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }

        .code-empty {
            font-size: 1.2rem;
            color: #94a3b8;
            font-style: italic;
        }

        .code-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .code-info-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .code-info-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .code-info-value {
            font-size: 1.1rem;
            color: #003366;
            font-weight: 700;
        }

        .init-form {
            background: white;
            border: 2px solid #003366;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .init-form-title {
            text-align: center;
            font-size: 1.4rem;
            font-weight: bold;
            color: #003366;
            margin-bottom: 25px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.9rem;
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
            font-size: 0.95rem;
            background: white;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #003366;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .form-control:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .code-input {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-align: center;
            font-family: 'Courier New', monospace;
            text-transform: uppercase;
        }

        .actions-section {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 51, 102, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover:not(:disabled) {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        .btn-warning:hover:not(:disabled) {
            background: linear-gradient(135deg, #e0a800, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 193, 7, 0.4);
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

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .history-section {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .history-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .history-table th {
            background: linear-gradient(135deg, #003366, #0055aa);
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .history-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
            font-size: 0.9rem;
        }

        .history-table tbody tr:hover {
            background: #f8fafc;
        }

        .history-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-active {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-expired {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
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
            
            .content-section {
                padding: 20px;
            }
            
            .page-title {
                font-size: 1.6rem;
            }
            
            .code-value {
                font-size: 1.8rem;
                letter-spacing: 3px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-section {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .back-btn {
                left: 20px;
                bottom: 20px;
                padding: 12px 20px;
            }

            .history-table {
                font-size: 0.8rem;
            }

            .history-table th,
            .history-table td {
                padding: 8px 5px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-cog"></i>
                Initialisation du Code du Jour
            </h1>
            <p class="page-subtitle">
                Configuration et gestion du code de codification quotidien
            </p>
        </div>

        <div class="content-section">
            <div class="info-card">
                <h2>
                    <i class="fas fa-info-circle"></i>
                    Information
                </h2>
                <p>
                    Le code du jour est utilisé pour codifier les lots de manière sécurisée. 
                    Il doit être initialisé chaque jour et peut être régénéré si nécessaire. 
                    Seul le code actif du jour sera utilisé pour les opérations de codification.
                </p>
            </div>

            <div class="current-code-section">
                <div class="current-code-title">
                    <i class="fas fa-key"></i>
                    Code Actuel
                </div>
                
                <div class="code-display">
                    <div class="code-value" id="currentCodeDisplay">
                        <span class="code-empty">Aucun code initialisé</span>
                    </div>
                </div>

                <div class="code-info">
                    <div class="code-info-item">
                        <div class="code-info-label">Date d'initialisation</div>
                        <div class="code-info-value" id="initDateDisplay">-</div>
                    </div>
                    <div class="code-info-item">
                        <div class="code-info-label">Initialisé par</div>
                        <div class="code-info-value" id="initByDisplay">-</div>
                    </div>
                    <div class="code-info-item">
                        <div class="code-info-label">Statut</div>
                        <div class="code-info-value" id="statusDisplay">
                            <span class="status-expired">
                                <i class="fas fa-times-circle"></i> Non initialisé
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="init-form">
                <div class="init-form-title">
                    <i class="fas fa-plus-circle"></i>
                    Initialiser un Nouveau Code
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i>
                            Date d'application
                        </label>
                        <input type="date" class="form-control" id="dateApplication" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-key"></i>
                            Code du jour
                        </label>
                        <input type="text" class="form-control code-input" id="codeInput" placeholder="CODE" maxlength="10" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            Initialisé par
                        </label>
                        <input type="text" class="form-control" id="initBy" value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Utilisateur'; ?>" readonly>
                    </div>
                </div>

                <div class="actions-section">
                    <button type="button" class="btn btn-warning" onclick="genererNouveauCode()">
                        <i class="fas fa-random"></i>
                        Générer un Code
                    </button>
                    <button type="button" class="btn btn-success" onclick="initialiserCode()" id="btnInit" disabled>
                        <i class="fas fa-check-circle"></i>
                        Initialiser le Code
                    </button>
                    <button type="button" class="btn btn-outline" onclick="reinitialiserFormulaire()">
                        <i class="fas fa-redo"></i>
                        Réinitialiser
                    </button>
                </div>
            </div>

            <div class="history-section">
                <div class="history-title">
                    <i class="fas fa-history"></i>
                    Historique des Codes
                </div>

                <div style="overflow-x: auto;">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Code</th>
                                <th>Initialisé par</th>
                                <th>Heure d'initialisation</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <tr>
                                <td>09/10/2024</td>
                                <td style="font-family: 'Courier New', monospace; font-weight: 700; font-size: 1.1rem;">ABCD1234</td>
                                <td>Admin Principal</td>
                                <td>08:30:15</td>
                                <td>
                                    <span class="status-active">
                                        <i class="fas fa-check-circle"></i> Actif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>08/10/2024</td>
                                <td style="font-family: 'Courier New', monospace; font-weight: 700; font-size: 1.1rem;">WXYZ5678</td>
                                <td>Admin Principal</td>
                                <td>09:15:42</td>
                                <td>
                                    <span class="status-expired">
                                        <i class="fas fa-times-circle"></i> Expiré
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>07/10/2024</td>
                                <td style="font-family: 'Courier New', monospace; font-weight: 700; font-size: 1.1rem;">EFGH9012</td>
                                <td>Gestionnaire 1</td>
                                <td>07:45:30</td>
                                <td>
                                    <span class="status-expired">
                                        <i class="fas fa-times-circle"></i> Expiré
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="actions-section" style="background: white; border: 2px solid #e2e8f0;">
                <a href="lots.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Retour aux Lots
                </a>
                <button type="button" class="btn btn-primary" onclick="exporterHistorique()">
                    <i class="fas fa-file-export"></i>
                    Exporter l'Historique
                </button>
            </div>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i>
        Retour
    </button>

    <script>
        let codeGenere = '';

        function genererNouveauCode() {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            
            for (let i = 0; i < 8; i++) {
                code += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            
            codeGenere = code;
            document.getElementById('codeInput').value = code;
            document.getElementById('btnInit').disabled = false;
            
            showNotification('Code généré avec succès !', 'success');
        }

        function initialiserCode() {
            const dateApp = document.getElementById('dateApplication').value;
            const code = document.getElementById('codeInput').value;
            const initBy = document.getElementById('initBy').value;

            if (!code) {
                showNotification('Veuillez d\'abord générer un code', 'warning');
                return;
            }

            if (!dateApp) {
                showNotification('Veuillez sélectionner une date', 'warning');
                return;
            }

            if (confirm(`Êtes-vous sûr de vouloir initialiser le code "${code}" pour la date du ${formatDate(dateApp)} ?`)) {
                showNotification('Initialisation du code en cours...', 'info');
                
                setTimeout(() => {
                    document.getElementById('currentCodeDisplay').innerHTML = code;
                    document.getElementById('currentCodeDisplay').innerHTML = code;
                    document.getElementById('initDateDisplay').textContent = formatDate(dateApp);
                    document.getElementById('initByDisplay').textContent = initBy;
                    document.getElementById('statusDisplay').innerHTML = `
                        <span class="status-active">
                            <i class="fas fa-check-circle"></i> Actif
                        </span>
                    `;
                    
                    // Ajouter à l'historique
                    ajouterAHistorique(dateApp, code, initBy);
                    
                    // Réinitialiser le formulaire
                    reinitialiserFormulaire();
                    
                    showNotification('Code initialisé avec succès !', 'success');
                }, 1500);
            }
        }

        function ajouterAHistorique(date, code, initBy) {
            const tbody = document.getElementById('historyTableBody');
            const now = new Date();
            const heureInit = now.toTimeString().split(' ')[0];
            
            // Marquer tous les codes existants comme expirés
            const activeStatuses = tbody.querySelectorAll('.status-active');
            activeStatuses.forEach(status => {
                status.className = 'status-expired';
                status.innerHTML = '<i class="fas fa-times-circle"></i> Expiré';
            });
            
            // Créer la nouvelle ligne
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${formatDate(date)}</td>
                <td style="font-family: 'Courier New', monospace; font-weight: 700; font-size: 1.1rem;">${code}</td>
                <td>${initBy}</td>
                <td>${heureInit}</td>
                <td>
                    <span class="status-active">
                        <i class="fas fa-check-circle"></i> Actif
                    </span>
                </td>
            `;
            
            // Insérer en première position
            tbody.insertBefore(newRow, tbody.firstChild);
        }

        function reinitialiserFormulaire() {
            document.getElementById('codeInput').value = '';
            document.getElementById('dateApplication').value = '<?php echo date('Y-m-d'); ?>';
            document.getElementById('btnInit').disabled = true;
            codeGenere = '';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const jour = String(date.getDate()).padStart(2, '0');
            const mois = String(date.getMonth() + 1).padStart(2, '0');
            const annee = date.getFullYear();
            return `${jour}/${mois}/${annee}`;
        }

        function exporterHistorique() {
            const tbody = document.getElementById('historyTableBody');
            const rows = tbody.querySelectorAll('tr');
            
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Date,Code,Initialisé par,Heure d'initialisation,Statut\n";
            
            rows.forEach(row => {
                const cols = row.querySelectorAll('td');
                const date = cols[0].textContent;
                const code = cols[1].textContent;
                const initBy = cols[2].textContent;
                const heure = cols[3].textContent;
                const statut = cols[4].textContent.trim();
                
                csvContent += `${date},${code},${initBy},${heure},${statut}\n`;
            });
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `historique_codes_${new Date().getTime()}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showNotification('Historique exporté avec succès !', 'success');
        }

        function showNotification(message, type) {
            // Créer l'élément de notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                border-radius: 10px;
                color: white;
                font-weight: 600;
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex;
                align-items: center;
                gap: 10px;
                max-width: 400px;
            `;
            
            // Définir la couleur selon le type
            let bgColor, icon;
            switch(type) {
                case 'success':
                    bgColor = 'linear-gradient(135deg, #28a745, #20c997)';
                    icon = '<i class="fas fa-check-circle"></i>';
                    break;
                case 'warning':
                    bgColor = 'linear-gradient(135deg, #ffc107, #ff9800)';
                    icon = '<i class="fas fa-exclamation-triangle"></i>';
                    break;
                case 'error':
                    bgColor = 'linear-gradient(135deg, #dc3545, #c82333)';
                    icon = '<i class="fas fa-times-circle"></i>';
                    break;
                case 'info':
                    bgColor = 'linear-gradient(135deg, #17a2b8, #138496)';
                    icon = '<i class="fas fa-info-circle"></i>';
                    break;
                default:
                    bgColor = 'linear-gradient(135deg, #003366, #0055aa)';
                    icon = '<i class="fas fa-bell"></i>';
            }
            
            notification.style.background = bgColor;
            notification.innerHTML = `${icon} <span>${message}</span>`;
            
            document.body.appendChild(notification);
            
            // Supprimer après 3 secondes
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Ajouter les animations CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Charger le code actuel au chargement de la page (simulé)
        window.addEventListener('load', function() {
            // Ici, vous pourriez faire un appel AJAX pour charger le code actuel depuis la base de données
            // Pour la démonstration, nous utilisons les données statiques déjà présentes
            console.log('Page chargée - Prêt à initialiser un nouveau code');
        });

        // Validation du formulaire en temps réel
        document.getElementById('codeInput').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('dateApplication').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                showNotification('Attention : Vous initialisez un code pour une date passée', 'warning');
            }
        });
    </script>
</body>
</html>

<?php include('../../includes/footer.php'); ?>