<?php 
$pageTitle = "Module Traitements";
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
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .main-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 60px;
        }

        .card {
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

        .card::before {
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

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 51, 102, 0.15);
            color: #003366;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .card-description {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 8px;
            font-weight: 400;
            line-height: 1.4;
        }

        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #cc0000;
            color: white;
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .back-btn {
            position: fixed;
            left: 30px;
            bottom: 30px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #003366, #0055aa);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #002244, #003366);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.4);
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #003366;
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
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .main-content {
                grid-template-columns: 1fr;
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
                <i class="fas fa-cogs"></i>
                Module Traitements
            </h1>
            <p class="page-subtitle">
                Gestion complète des demandes d'analyse, validations et éditions des bulletins de qualité
            </p>
        </div>

        <div class="quick-stats">
            <div class="stat-card">
                <span class="stat-number">24</span>
                <span class="stat-label">Demandes en attente</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">156</span>
                <span class="stat-label">Analyses terminées</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">89%</span>
                <span class="stat-label">Taux de validation</span>
            </div>
        </div>

        <div class="main-content">
            <a href="demandes/ivoirienne.php" class="card">
                <span class="card-icon">🏛️</span>
                Demandes Autorités Ivoirienne
                <div class="card-description">Gestion des demandes officielles des autorités ivoiriennes</div>
                <span class="card-badge">12 Nouveau</span>
            </a>
            
            <a href="demandes/clients.php" class="card">
                <span class="card-icon">👥</span>
                Demandes Clients Standards
                <div class="card-description">Traitement des demandes clients standards</div>
            </a>
            
            <a href="validations/cacao.php" class="card">
                <span class="card-icon">✅</span>
                Validation Résultats Cacao
                <div class="card-description">Validation des analyses qualité cacao</div>
                <span class="card-badge">8 En attente</span>
            </a>
            
            <a href="validations/cafe.php" class="card">
                <span class="card-icon">✅</span>
                Validation Résultats Café
                <div class="card-description">Validation des analyses qualité café</div>
                <span class="card-badge">5 En attente</span>
            </a>
            
            <a href="export/bv_cacao.php" class="card">
                <span class="card-icon">📤</span>
                Export BV Cacao
                <div class="card-description">Export des bulletins de vente cacao</div>
            </a>
            
            <a href="export/bv_cafe.php" class="card">
                <span class="card-icon">📤</span>
                Export BV Café
                <div class="card-description">Export des bulletins de vente café</div>
            </a>
            
            <a href="edition/bvba_cacao.php" class="card">
                <span class="card-icon">📝</span>
                Edition BV/BA Cacao
                <div class="card-description">Édition bulletins de vente et d'analyse cacao</div>
            </a>
            
            <a href="edition/bvba_cafe.php" class="card">
                <span class="card-icon">📝</span>
                Edition BV/BA Café
                <div class="card-description">Édition bulletins de vente et d'analyse café</div>
            </a>
        </div>
    </div>

    <button class="back-btn" onclick="window.history.back();">
        <i class="fas fa-arrow-left"></i> Retour
    </button>

    <script>
        // Animation des cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
<?php include('../../includes/footer.php'); ?>