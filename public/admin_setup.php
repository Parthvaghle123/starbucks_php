<?php
// Admin setup script

// Database configuration
$host = 'localhost';
$dbname = 'codeigniter4';
$username = 'root';
$password = '';

// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>એડમિન સેટઅપ</h2>";
    echo "<p>ડેટાબેસ કનેક્શન સફળ!</p>";
    
    // Create admin table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `admin` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
    echo "<p>એડમિન ટેબલ સફળતાપૂર્વક બનાવવામાં આવી!</p>";
    
    // Check if admin user already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `admin` WHERE email = 'admin@example.com'");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Insert admin user
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO `admin` (`username`, `email`, `password`) VALUES
                ('admin', 'admin@example.com', :password)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        
        echo "<p>એડમિન યુઝર સફળતાપૂર્વક બનાવવામાં આવ્યો!</p>";
    } else {
        echo "<p>એડમિન યુઝર પહેલેથી જ અસ્તિત્વમાં છે.</p>";
    }
    
    echo "<h3>એડમિન લોગિન માહિતી:</h3>";
    echo "<p>ઈમેલ: admin@example.com</p>";
    echo "<p>પાસવર્ડ: admin123</p>";
    
    echo "<p><a href='" . rtrim(dirname($_SERVER['PHP_SELF']), '/') . "/admin/login'>એડમિન લોગિન પેજ પર જાઓ</a></p>";
    
} catch(PDOException $e) {
    echo "<h2>એરર:</h2>";
    echo "<p>ડેટાબેસ કનેક્શન નિષ્ફળ: " . $e->getMessage() . "</p>";
    echo "<p>કૃપા કરીને ખાતરી કરો કે:</p>";
    echo "<ul>";
    echo "<li>MySQL સર્વર ચાલુ છે</li>";
    echo "<li>'codeigniter4' ડેટાબેસ અસ્તિત્વમાં છે</li>";
    echo "<li>ડેટાબેસ યુઝરનેમ અને પાસવર્ડ સાચા છે</li>";
    echo "</ul>";
}
?>