Formulario de Registro - Sistema Web
Un sistema completo de formulario web con PHP, MySQL y diseño responsive, desarrollado para la Universidad Tecnológica de Panamá.

🚀 Características
Formulario responsive con diseño moderno

Validación completa tanto en frontend como backend

Base de datos MySQL con relaciones

Tema nocturno mejorado

Soporte para tildes y caracteres especiales

Reporte de registros en tiempo real

Estructura organizada y escalable

📋 Requisitos
Servidor web (Apache, Nginx)

PHP 7.4 o superior

MySQL 5.7 o superior

Extensiones PHP: PDO, mbstring

🛠️ Instalación
1. Clonar el repositorio
bash
git clone https://github.com/tu-usuario/formulario-utp.git
cd formulario-utp
2. Configurar la base de datos
Opción A: Ejecutar SQL manualmente
sql
-- Crear base de datos
CREATE DATABASE formulario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE formulario_db;

-- Tabla de países
CREATE TABLE paises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla de áreas de interés
CREATE TABLE areas_interes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla principal de registros
CREATE TABLE registros (
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
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tabla para relación muchos a muchos
CREATE TABLE registro_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registro_id INT,
    area_id INT,
    FOREIGN KEY (registro_id) REFERENCES registros(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas_interes(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insertar datos de países
INSERT INTO paises (nombre) VALUES 
('Panamá'),
('Belice'),
('Suiza'),
('Guatemala'),
('México'),
('Colombia'),
('Otro');

-- Insertar áreas de interés
INSERT INTO areas_interes (nombre) VALUES 
('Inteligencia Artificial'),
('Desarrollo Web'),
('Ciberseguridad'),
('Blockchain'),
('Internet de las Cosas'),
('Realidad Virtual');
Opción B: El sistema crea automáticamente las tablas
El formulario creará automáticamente las tablas al enviar el primer registro.

3. Configurar conexión
Editar config/database.php:

php
private $host = "localhost";
private $db_name = "formulario_db";
private $username = "root";
private $password = "tu_password";  // Cambiar si es necesario
4. Acceder al sistema
Abrir en el navegador: http://localhost/formulario-utp/

🗃️ Estructura de la Base de Datos
Diagrama de la Base de Datos
text
formulario_db/
├── paises
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   └── nombre (VARCHAR)
├── areas_interes
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   └── nombre (VARCHAR)
├── registros
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   ├── nombre (VARCHAR)
│   ├── apellido (VARCHAR)
│   ├── edad (INT)
│   ├── sexo (VARCHAR)
│   ├── pais_residencia (VARCHAR)
│   ├── nacionalidad (VARCHAR)
│   ├── correo (VARCHAR)
│   ├── celular (VARCHAR)
│   ├── observaciones (TEXT)
│   ├── fecha_formulario (DATE)
│   └── fecha_registro (TIMESTAMP)
└── registro_areas
    ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
    ├── registro_id (INT, FOREIGN KEY)
    └── area_id (INT, FOREIGN KEY)
Consultas SQL Útiles
Ver todos los registros
sql
SELECT r.*, GROUP_CONCAT(ai.nombre SEPARATOR ', ') as temas 
FROM registros r 
LEFT JOIN registro_areas ra ON r.id = ra.registro_id 
LEFT JOIN areas_interes ai ON ra.area_id = ai.id 
GROUP BY r.id 
ORDER BY r.fecha_registro DESC;
Estadísticas de registros
sql
-- Total de registros
SELECT COUNT(*) as total_registros FROM registros;

-- Registros por país
SELECT pais_residencia, COUNT(*) as total 
FROM registros 
GROUP BY pais_residencia 
ORDER BY total DESC;

-- Temas más populares
SELECT ai.nombre, COUNT(*) as total 
FROM registro_areas ra 
JOIN areas_interes ai ON ra.area_id = ai.id 
GROUP BY ai.nombre 
ORDER BY total DESC;
Backup de la base de datos
sql
-- Exportar estructura y datos
mysqldump -u username -p formulario_db > backup_formulario.sql

-- Importar backup
mysql -u username -p formulario_db < backup_formulario.sql
📁 Estructura del Proyecto
text
formulario-utp/
├── .gitignore
├── README.md
├── index.php                 # Formulario principal
├── process.php              # Procesamiento de datos
├── report.php               # Reporte de registros
├── config/
│   └── database.php         # Configuración de BD
├── css/
│   └── style.css            # Estilos del tema nocturno
└── js/
    └── script.js            # Validaciones JavaScript
🎨 Personalización
Colores del tema
Editar variables CSS en css/style.css:

css
:root {
    --primary-color: #3b82f6;
    --secondary-color: #06b6d4;
    --background-dark: #0f172a;
    /* ... más variables */
}
Países y nacionalidades
Modificar en config/database.php en la función insertInitialData()

📝 Funcionalidades
Formulario Principal (index.php)
✅ Campos validados con JavaScript y PHP

✅ Formato automático de nombres y apellidos

✅ Sincronización país-nacionalidad

✅ Diseño responsive

✅ Soporte para tildes y caracteres especiales

Procesamiento (process.php)
✅ Validación de datos segura

✅ Protección contra inyecciones SQL

✅ Manejo de errores detallado

✅ Soporte UTF-8 completo

Reportes (report.php)
✅ Vista tabular de todos los registros

✅ Estadísticas básicas

✅ Ordenamiento por fecha

✅ Diseño responsive para tablas

🔧 Tecnologías Utilizadas
Frontend: HTML5, CSS3, JavaScript (ES6+)

Backend: PHP 8+, MySQL

Seguridad: PDO Prepared Statements, Validación de datos

Diseño: CSS Grid, Flexbox, Variables CSS

Base de Datos: MySQL con relaciones y claves foráneas

🐛 Solución de Problemas
Error de conexión a la base de datos
Verificar que MySQL esté ejecutándose

Revisar credenciales en config/database.php

Asegurar que la base de datos exista

Problemas con tildes y caracteres especiales
La base de datos usa collation utf8mb4_unicode_ci

Todos los archivos PHP tienen encoding UTF-8

Las validaciones permiten caracteres especiales del español

El formulario no se envía
Verificar que todos los campos obligatorios estén completos

Revisar la consola del navegador para errores JavaScript

Verificar los logs de error de PHP

📞 Soporte
Si encuentras algún problema:

Revisa los logs de error de PHP

Verifica la conexión a la base de datos

Asegúrate de que todas las extensiones PHP estén habilitadas

Consulta la sección de solución de problemas arriba

📄 Licencia
Este proyecto fue desarrollado para la Universidad Tecnológica de Panamá como parte de un proyecto académico.

Desarrollado para la Universidad Tecnológica de Panamá
Facultad de Ingeniería de Sistemas Computacionales
2025
