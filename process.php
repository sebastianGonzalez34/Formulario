<?php
// Habilitar mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el archivo de base de datos existe
if (!file_exists('config/database.php')) {
    die("❌ Error: No se encuentra config/database.php");
}

require_once 'config/database.php';

// Configurar encoding UTF-8
header('Content-Type: text/html; charset=utf-8');

// Inicializar variables
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar y sanitizar datos
    $nombre = isset($_POST['nombre']) ? mb_convert_case(trim($_POST['nombre']), MB_CASE_TITLE, "UTF-8") : '';
    $apellido = isset($_POST['apellido']) ? mb_convert_case(trim($_POST['apellido']), MB_CASE_TITLE, "UTF-8") : '';
    $edad = isset($_POST['edad']) ? intval($_POST['edad']) : 0;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $pais_residencia = isset($_POST['pais_residencia']) ? $_POST['pais_residencia'] : '';
    $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : '';
    $correo = isset($_POST['correo']) ? filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL) : '';
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';
    $fecha_formulario = isset($_POST['fecha_formulario']) ? $_POST['fecha_formulario'] : '';
    $temas = isset($_POST['temas']) ? $_POST['temas'] : [];

    // Validaciones
    if (empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u", $nombre)) {
        $errors[] = "El nombre es obligatorio y solo puede contener letras, espacios y tildes.";
    }
    
    if (empty($apellido) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u", $apellido)) {
        $errors[] = "El apellido es obligatorio y solo puede contener letras, espacios y tildes.";
    }
    
    if ($edad < 1 || $edad > 120) {
        $errors[] = "La edad debe estar entre 1 y 120 años.";
    }
    
    if (!in_array($sexo, ['M', 'F', 'O'])) {
        $errors[] = "Seleccione un sexo válido.";
    }
    
    // Validar países
    $paises_validos = ['Panamá', 'Belice', 'Suiza', 'Guatemala', 'México', 'Colombia', 'Otro'];
    if (empty($pais_residencia) || !in_array($pais_residencia, $paises_validos)) {
        $errors[] = "Seleccione un país de residencia válido.";
    }
    
    $nacionalidades_validas = ['Panameña', 'Beliceña', 'Suiza', 'Guatemalteca', 'Mexicana', 'Colombiana', 'Otra'];
    if (empty($nacionalidad) || !in_array($nacionalidad, $nacionalidades_validas)) {
        $errors[] = "Seleccione una nacionalidad válida.";
    }
    
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ingrese un correo electrónico válido.";
    }
    
    // Validación MEJORADA para celular
    if (empty($celular)) {
        $errors[] = "El número de celular es obligatorio.";
    } else {
        $celular_limpio = preg_replace('/[^\d]/', '', $celular);
        if (strlen($celular_limpio) < 7) {
            $errors[] = "El número de celular debe tener al menos 7 dígitos.";
        }
    }
    
    if (empty($fecha_formulario)) {
        $errors[] = "La fecha del formulario es obligatoria.";
    }
    
    if (empty($temas)) {
        $errors[] = "Seleccione al menos un tema tecnológico de interés.";
    }

    // Si no hay errores, guardar en la base de datos
    if (empty($errors)) {
        $database = new Database();
        $connection = $database->getConnection();
        
        if (!$connection) {
            $errors[] = "No se pudo conectar a la base de datos.";
        } else {
            // Configurar encoding UTF-8 para la conexión
            $connection->exec("SET NAMES 'utf8mb4'");
            
            // Crear tablas si no existen
            if ($database->createTables()) {
                try {
                    // Insertar registro principal
                    $query = "INSERT INTO registros (nombre, apellido, edad, sexo, pais_residencia, nacionalidad, correo, celular, observaciones, fecha_formulario) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $connection->prepare($query);
                    
                    if ($stmt->execute([$nombre, $apellido, $edad, $sexo, $pais_residencia, $nacionalidad, $correo, $celular, $observaciones, $fecha_formulario])) {
                        $registro_id = $connection->lastInsertId();
                        
                        // Insertar áreas de interés seleccionadas
                        foreach($temas as $tema) {
                            $query_area = "SELECT id FROM areas_interes WHERE nombre = ?";
                            $stmt_area = $connection->prepare($query_area);
                            $stmt_area->execute([$tema]);
                            $area = $stmt_area->fetch(PDO::FETCH_ASSOC);
                            
                            if ($area) {
                                $query_rel = "INSERT INTO registro_areas (registro_id, area_id) VALUES (?, ?)";
                                $stmt_rel = $connection->prepare($query_rel);
                                $stmt_rel->execute([$registro_id, $area['id']]);
                            }
                        }
                        
                        $success = true;
                    } else {
                        $errors[] = "Error al insertar el registro principal.";
                    }
                } catch(PDOException $exception) {
                    $errors[] = "Error al guardar en la base de datos: " . $exception->getMessage();
                }
            } else {
                $errors[] = "Error al crear las tablas de la base de datos.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Formulario - iTECH</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Procesando Formulario</h1>
        </header>

        <div class="result">
            <?php if ($success): ?>
                <div class="success">
                    <h2>✅ ¡Formulario enviado exitosamente!</h2>
                    <p>Sus datos han sido registrados correctamente en nuestra base de datos.</p>
                    <div class="resumen">
                        <h3>Resumen de registro:</h3>
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre . ' ' . $apellido, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Correo:</strong> <?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Temas de interés:</strong> <?php echo htmlspecialchars(implode(', ', $temas), ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="actions">
                        <a href="index.php" class="btn btn-back">📝 Volver al Formulario</a>
                        <a href="report.php" class="btn btn-report">📊 Ver Reporte Completo</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="error">
                    <h2>❌ Error al procesar el formulario</h2>
                    <p>No se pudieron guardar los datos. Por favor, corrija los siguientes errores:</p>
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="actions">
                        <a href="index.php" class="btn btn-back">🔙 Volver al Formulario</a>
                    </div>
                </div>
            <?php endif; ?>
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