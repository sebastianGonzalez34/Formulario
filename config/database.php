<?php
class Database {
    private $host = "localhost";
    private $db_name = "formulario_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", 
                $this->username, 
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            return $this->conn;
            
        } catch(PDOException $exception) {
            // Intentar crear la base de datos si no existe
            if ($exception->getCode() == 1049) {
                $this->createDatabase();
                return $this->getConnection();
            }
            
            return null;
        }
    }

    private function createDatabase() {
        try {
            $temp_conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $temp_conn->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch(PDOException $e) {
            // Silenciar error en producción
        }
    }

    public function createTables() {
        $connection = $this->getConnection();
        
        if (!$connection) {
            return false;
        }

        try {
            // Tabla de países
            $query = "CREATE TABLE IF NOT EXISTS paises (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $connection->exec($query);

            // Tabla de áreas de interés
            $query = "CREATE TABLE IF NOT EXISTS areas_interes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $connection->exec($query);

            // Tabla principal de registros
            $query = "CREATE TABLE IF NOT EXISTS registros (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                apellido VARCHAR(100) NOT NULL,
                edad INT NOT NULL,
                sexo VARCHAR(1) NOT NULL,
                pais_residencia VARCHAR(100) NOT NULL,
                nacionalidad VARCHAR(100) NOT NULL,
                correo VARCHAR(150) NOT NULL,
                celular VARCHAR(20) NOT NULL,
                observaciones TEXT,
                fecha_formulario DATE NOT NULL,
                fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $connection->exec($query);

            // Tabla de relación
            $query = "CREATE TABLE IF NOT EXISTS registro_areas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                registro_id INT,
                area_id INT,
                FOREIGN KEY (registro_id) REFERENCES registros(id) ON DELETE CASCADE,
                FOREIGN KEY (area_id) REFERENCES areas_interes(id) ON DELETE CASCADE
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $connection->exec($query);

            // Insertar datos iniciales
            $this->insertInitialData();
            
            return true;

        } catch(PDOException $exception) {
            return false;
        }
    }
    
    private function insertInitialData() {
        $connection = $this->getConnection();
        
        if (!$connection) return;

        // Países
        $paises = ['Panamá', 'Belice', 'Suiza', 'Guatemala', 'México', 'Colombia', 'Otro'];
        foreach($paises as $pais) {
            $query = "INSERT IGNORE INTO paises (nombre) VALUES (?)";
            $stmt = $connection->prepare($query);
            $stmt->execute([$pais]);
        }

        // Áreas de interés
        $areas = [
            'Inteligencia Artificial', 
            'Desarrollo Web', 
            'Ciberseguridad', 
            'Blockchain', 
            'Internet de las Cosas', 
            'Realidad Virtual'
        ];
        foreach($areas as $area) {
            $query = "INSERT IGNORE INTO areas_interes (nombre) VALUES (?)";
            $stmt = $connection->prepare($query);
            $stmt->execute([$area]);
        }
    }
}
?>