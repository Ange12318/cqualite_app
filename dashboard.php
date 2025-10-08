<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - CQUALITÉ ACE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            position: relative;
        }

        header {
            background: linear-gradient(135deg, #003366 0%, #0055aa 100%);
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            height: 50px;
            width: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background: white;
            padding: 5px;
        }

        .app-title {
            font-size: 22px;
            font-weight: 700;
            color: white;
        }

        .app-subtitle {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 2px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 14px;
        }

        .user-info span {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout {
            background: linear-gradient(135deg, #cc0000, #ff3333);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(204, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout:hover {
            background: linear-gradient(135deg, #990000, #cc0000);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(204, 0, 0, 0.4);
        }

        .dashboard-container {
            padding: 40px 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto 20px auto;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 51, 102, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #003366, #0055aa);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 51, 102, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #003366;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #003366;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
            font-weight: 500;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 60px;
        }

        .module-card {
            background: white;
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: #003366;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid rgba(0, 51, 102, 0.1);
            position: relative;
            overflow: hidden;
        }

        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #003366, #0055aa);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .module-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.15);
            color: #003366;
        }

        .module-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0.9;
        }

        .card-description {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 8px;
            font-weight: 400;
            line-height: 1.4;
        }

        .recent-activity {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 51, 102, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 51, 102, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #003366;
            font-size: 1rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-weight: 500;
            color: #334155;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 30px 20px;
            }
            
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 15px 20px;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .modules-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-bar {
                grid-template-columns: 1fr;
            }
            
            .user-info {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 20px 15px;
            }
            
            .welcome-section {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .module-card {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-section">
            <img src="logo.png" alt="Logo ACE" class="logo">
            <div>
                <div class="app-title">QUALITIS ACE</div>
                <div class="app-subtitle">Application de traitement des BV</div>
            </div>
        </div>
        
        <div class="user-info">
            <span>
                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($user) ?>
            </span>
            <a href="?logout=true" class="logout">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Section de bienvenue -->
        <div class="welcome-section">
            <h1 class="welcome-title">
                <i class="fas fa-tachometer-alt"></i>
                Tableau de Bord
            </h1>
            <p class="welcome-subtitle">
                Bienvenue dans votre espace de traitement des BV
            </p>
        </div>

        <!-- Statistiques -->
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <span class="stat-number">156</span>
                <span class="stat-label">Demandes Actives</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <span class="stat-number">42</span>
                <span class="stat-label">Analyses Aujourd'hui</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span class="stat-number">89%</span>
                <span class="stat-label">Taux de Qualité</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <span class="stat-number">1,248</span>
                <span class="stat-label">Lots Traités</span>
            </div>
        </div>

        <!-- Modules principaux -->
        <div class="modules-grid">
            <a href="/cqualite_app/modules/traitements/index.php" class="module-card">
                <div class="card-icon">📦</div>
                Traitements
                <div class="card-description">Gestion des demandes et analyses qualité</div>
            </a>
            
            <a href="/cqualite_app/modules/echantillons/index.php" class="module-card">
                <div class="card-icon">🧪</div>
                Échantillons
                <div class="card-description">Sondage et brassage des échantillons</div>
            </a>
            
            <a href="/cqualite_app/modules/codifications/index.php" class="module-card">
                <div class="card-icon">🔖</div>
                Codifications
                <div class="card-description">Gestion des codes et identification</div>
            </a>
            
            <a href="/cqualite_app/modules/laboratoires/index.php" class="module-card">
                <div class="card-icon">⚗️</div>
                Laboratoires
                <div class="card-description">Analyses et contrôles qualité</div>
            </a>
            
            <a href="/cqualite_app/modules/stockages/index.php" class="module-card">
                <div class="card-icon">📦</div>
                Stockages
                <div class="card-description">Gestion des stocks et entreposage</div>
            </a>
            
            <a href="/cqualite_app/modules/facturation/index.php" class="module-card">
                <div class="card-icon">💰</div>
                Facturation
                <div class="card-description">Factures et règlements</div>
            </a>
            
            <a href="/cqualite_app/modules/base/index.php" class="module-card">
                <div class="card-icon">🗄️</div>
                Base de données
                <div class="card-description">Import/Export des données</div>
            </a>
            
            <a href="/cqualite_app/modules/parametrage/index.php" class="module-card">
                <div class="card-icon">⚙️</div>
                Paramétrage
                <div class="card-description">Configuration du système</div>
            </a>
            
            <a href="/cqualite_app/modules/statistiques/index.php" class="module-card">
                <div class="card-icon">📊</div>
                Statistiques
                <div class="card-description">Rapports et analyses statistiques</div>
            </a>
        </div>

        <!-- Activité récente -->
        <div class="recent-activity">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Activité Récente
            </h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Nouvelle demande créée - REF-2024-015</div>
                        <div class="activity-time">Il y a 5 minutes</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Analyse validée - Lot CAF-2024-008</div>
                        <div class="activity-time">Il y a 15 minutes</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-file-export"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Rapport exporté - Bilan Trimestriel</div>
                        <div class="activity-time">Il y a 1 heure</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Nouvel utilisateur ajouté</div>
                        <div class="activity-time">Il y a 2 heures</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Animation des cartes au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.module-card, .stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animation des activités
            const activities = document.querySelectorAll('.activity-item');
            activities.forEach((activity, index) => {
                activity.style.opacity = '0';
                activity.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    activity.style.transition = 'all 0.5s ease';
                    activity.style.opacity = '1';
                    activity.style.transform = 'translateX(0)';
                }, index * 150 + 500);
            });
        });

        // Mise à jour en temps réel des statistiques (simulation)
        function updateStats() {
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                const currentValue = parseInt(stat.textContent);
                const randomChange = Math.floor(Math.random() * 5) - 2; // -2 à +2
                const newValue = Math.max(0, currentValue + randomChange);
                
                if (stat.textContent.includes('%')) {
                    stat.textContent = newValue + '%';
                } else {
                    stat.textContent = newValue.toLocaleString();
                }
            });
        }

        // Mettre à jour les stats toutes les 30 secondes
        setInterval(updateStats, 30000);
    </script>
</body>
</html>