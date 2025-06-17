<?php
/**
 * Debug file to check environment and database connection
 */

echo "<h1>WordPress Debug Information</h1>";

echo "<h2>Environment Variables:</h2>";
echo "DB_HOST: " . (getenv('WORDPRESS_DB_HOST') ?: 'NOT SET') . "<br>";
echo "DB_PORT: " . (getenv('WORDPRESS_DB_PORT') ?: 'NOT SET') . "<br>";
echo "DB_NAME: " . (getenv('WORDPRESS_DB_NAME') ?: 'NOT SET') . "<br>";
echo "DB_USER: " . (getenv('WORDPRESS_DB_USER') ?: 'NOT SET') . "<br>";
echo "DB_PASSWORD: " . (getenv('WORDPRESS_DB_PASSWORD') ? 'SET' : 'NOT SET') . "<br>";

echo "<h2>PHP Extensions:</h2>";
echo "PDO: " . (extension_loaded('pdo') ? 'Yes' : 'No') . "<br>";
echo "PDO PostgreSQL: " . (extension_loaded('pdo_pgsql') ? 'Yes' : 'No') . "<br>";

echo "<h2>Database Connection Test:</h2>";
$db_host = getenv('WORDPRESS_DB_HOST');
$db_port = getenv('WORDPRESS_DB_PORT') ?: '5432';
$db_name = getenv('WORDPRESS_DB_NAME');
$db_user = getenv('WORDPRESS_DB_USER');
$db_password = getenv('WORDPRESS_DB_PASSWORD');

if ($db_host && $db_name && $db_user && $db_password) {
    try {
        $pdo = new PDO("pgsql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_password);
        echo "✅ Database connection successful!<br>";
        
        $stmt = $pdo->query("SELECT version()");
        $version = $stmt->fetchColumn();
        echo "PostgreSQL Version: " . $version . "<br>";
        
    } catch (PDOException $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Missing database environment variables<br>";
}
?>
