# Formulario de Registro - Sistema Web

Un sistema completo de formulario web con PHP, MySQL y diseño responsive.

## 🚀 Características

- Formulario responsive con diseño moderno
- Validación completa frontend y backend  
- Base de datos MySQL con relaciones
- Tema nocturno mejorado
- Soporte para tildes y caracteres especiales
- Reporte de registros en tiempo real

## 📋 Requisitos

- Servidor web (Apache, Nginx)
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Extensiones PHP: PDO, mbstring

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/formulario.git
cd formulario
📄 Licencia
Este proyecto fue desarrollado para la Universidad Tecnológica de Panamá como parte de un proyecto académico.

Desarrollado para la Universidad Tecnológica de Panamá
Facultad de Ingeniería de Sistemas Computacionales


Ejecutar este SQL en phpMyAdmin:
sql
CREATE DATABASE formulario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE formulario_db;

CREATE TABLE paises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE areas_interes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

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

CREATE TABLE registro_areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registro_id INT,
    area_id INT,
    FOREIGN KEY (registro_id) REFERENCES registros(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas_interes(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO paises (nombre) VALUES 
('Panamá'),
('Belice'),
('Suiza'),
('Guatemala'),
('México'),
('Colombia'),
('Otro');

INSERT INTO areas_interes (nombre) VALUES 
('Inteligencia Artificial'),
('Desarrollo Web'),
('Ciberseguridad'),
('Blockchain'),
('Internet de las Cosas'),
('Realidad Virtual');
3. Configurar conexión
Editar config/database.php:

php
private $host = "localhost";
private $db_name = "formulario_db";
private $username = "root";
private $password = "";  // Cambiar si tiene contraseña
4. Acceder al sistema
Abrir en el navegador: http://localhost/formulario/

📁 Estructura del Proyecto
text
formulario/
├── index.php          # Formulario principal
├── process.php        # Procesamiento de datos
├── report.php         # Reporte de registros
├── config/
│   └── database.php   # Configuración de BD
├── css/
│   └── style.css      # Estilos
└── js/
    └── script.js      # Validaciones
🗃️ Estructura de Base de Datos
text
formulario_db/
├── paises             # Lista de países
├── areas_interes      # Temas tecnológicos  
├── registros          # Datos principales
└── registro_areas     # Relación muchos a muchos
📝 Campos del Formulario
Nombre * (Texto)

Apellido * (Texto)

Edad * (Número)

Sexo * (Selector)

País de Residencia * (Selector)

Nacionalidad * (Selector)

Correo Electrónico * (Email)

Celular * (Teléfono)

Temas Tecnológicos * (Checkboxes)

Observaciones (Textarea)

Fecha del Formulario * (Date)

🔧 Validaciones
Nombres y apellidos aceptan tildes

Celular mínimo 7 dígitos

Email válido

Edad entre 1-120 años

Al menos un tema seleccionado

Fecha no puede ser futura

🎨 Tema
Diseño nocturno moderno

Responsive para móviles

Animaciones suaves

Iconos y emojis

📊 Reportes
Tabla con todos los registros

Ordenamiento por fecha

Vista responsive

Estadísticas básicas

🐛 Solución de Problemas
Error de conexión a BD:

Verificar que MySQL esté ejecutándose

Revisar credenciales en config/database.php

No se envían formularios:

Revisar consola del navegador

Verificar logs de PHP

Problemas con tildes:

La BD usa UTF-8

Validaciones permiten caracteres especiales
2025
