<?php
// Habilitar mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurar encoding UTF-8
header('Content-Type: text/html; charset=utf-8');

// Verificar si el archivo de base de datos existe
if (!file_exists('config/database.php')) {
    die("❌ Error: No se encuentra config/database.php");
}

require_once 'config/database.php';

$database = new Database();
$connection = $database->getConnection();

if (!$connection) {
    die("❌ Error: No se pudo conectar a la base de datos");
}

// Configurar encoding UTF-8 para la conexión
$connection->exec("SET NAMES 'utf8mb4'");

// Obtener todos los registros
try {
    $query = "SELECT r.*, GROUP_CONCAT(ai.nombre SEPARATOR ', ') as temas 
              FROM registros r 
              LEFT JOIN registro_areas ra ON r.id = ra.registro_id 
              LEFT JOIN areas_interes ai ON ra.area_id = ai.id 
              GROUP BY r.id 
              ORDER BY r.fecha_registro DESC";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("❌ Error al obtener registros: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Registros - iTECH</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Reporte de Registros</h1>
            <p>Lista de todos los formularios registrados en el sistema</p>
        </header>

        <?php if (count($registros) > 0): ?>
            <div class="stats">
                <div class="stat-card">
                    <h3>📈 Total de Registros</h3>
                    <p class="stat-number"><?php echo count($registros); ?></p>
                </div>
            </div>

            <div class="table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>País Residencia</th>
                            <th>Nacionalidad</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Temas de Interés</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($registros as $registro): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($registro['apellido'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="centered"><?php echo $registro['edad']; ?></td>
                                <td class="centered">
                                    <?php 
                                    switch($registro['sexo']) {
                                        case 'M': echo '👨 Masculino'; break;
                                        case 'F': echo '👩 Femenino'; break;
                                        case 'O': echo '⚧ Otro'; break;
                                        default: echo $registro['sexo'];
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($registro['pais_residencia'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($registro['nacionalidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($registro['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($registro['celular'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="topics"><?php echo htmlspecialchars($registro['temas'] ?: 'Sin temas', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="centered"><?php echo date('d/m/Y', strtotime($registro['fecha_registro'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <h3>📭 No hay registros disponibles</h3>
                <p>No se han encontrado formularios registrados en el sistema.</p>
                <p>Puedes <a href="index.php">crear el primer registro</a>.</p>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="index.php" class="btn btn-back">📝 Volver al Formulario</a>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>iTECH</h4>
                <p>Formulario de registro para eventos tecnológicos</p>
            </div>
            <div class="footer-section">
                <h4>Contacto</h4>
                <p>📧 info@itech.com</p>
                <p>📞 +507 123-4567</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 iTECH. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>