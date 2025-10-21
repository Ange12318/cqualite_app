<?php
require_once 'config.php';

try {
    // Test simple de requête
    $stmt = $pdo->query("SELECT DATABASE() as db_name");
    $result = $stmt->fetch();
    
    echo "✅ Connexion réussie à la base : " . $result['db_name'] . "<br>";
    
    // Test des tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    
    echo "📊 Nombre de tables : " . count($tables) . "<br>";
    echo "📋 Liste des tables : <br>";
    foreach($tables as $table) {
        echo "- " . $table[0] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>