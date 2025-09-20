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
    
    echo "<h2>Admin Setup</h2>";
    echo "<p>Database connection successful!</p>";
    
    // Create admin table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `admin` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
    echo "<p>Admin table created successfully!</p>";
    
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
        
        echo "<p>Admin user created successfully!</p>";
    } else {
        echo "<p>Admin user already exists.</p>";
    }
    
    echo "<h3>Admin Login Information:</h3>";
    echo "<p>Email: admin@example.com</p>";
    echo "<p>Password: admin123</p>";
    
    echo "<p><a href='" . rtrim(dirname($_SERVER['PHP_SELF']), '/') . "/admin/login'>Go to Admin Login Page</a></p>";
    
} catch(PDOException $e) {
    echo "<h2>Error:</h2>";
    echo "<p>Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please make sure that:</p>";
    echo "<ul>";
    echo "<li>MySQL server is running</li>";
    echo "<li>'codeigniter4' database exists</li>";
    echo "<li>Database username and password are correct</li>";
    echo "</ul>";
}
?>
