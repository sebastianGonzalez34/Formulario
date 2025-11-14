<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro - iTECH</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Formulario de Registro</h1>
            <p>Complete todos los campos para registrarse en el evento tecnológico</p>
        </header>

        <form action="process.php" method="POST" id="registrationForm">
            <div class="form-grid">
                <!-- Información Personal -->
                <div class="form-section">
                    <h3>📝 Información Personal</h3>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" required 
                               placeholder="Ej: Juan Carlos">
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido *</label>
                        <input type="text" id="apellido" name="apellido" required
                               placeholder="Ej: Pérez González">
                    </div>

                    <div class="form-group">
                        <label for="edad">Edad *</label>
                        <input type="number" id="edad" name="edad" min="1" max="120" required
                               placeholder="Ej: 25">
                    </div>

                    <div class="form-group">
                        <label for="sexo">Sexo *</label>
                        <select id="sexo" name="sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>
                </div>

                <!-- Información de Ubicación -->
                <div class="form-section">
                    <h3>🌍 Información de Ubicación</h3>

                    <div class="form-group">
                        <label for="pais_residencia">País de Residencia *</label>
                        <select id="pais_residencia" name="pais_residencia" required>
                            <option value="">Seleccione...</option>
                            <option value="Panamá">Panamá</option>
                            <option value="Belice">Belice</option>
                            <option value="Suiza">Suiza</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="México">México</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nacionalidad">Nacionalidad *</label>
                        <select id="nacionalidad" name="nacionalidad" required>
                            <option value="">Seleccione...</option>
                            <option value="Panameña">Panameña</option>
                            <option value="Beliceña">Beliceña</option>
                            <option value="Suiza">Suiza</option>
                            <option value="Guatemalteca">Guatemalteca</option>
                            <option value="Mexicana">Mexicana</option>
                            <option value="Colombiana">Colombiana</option>
                            <option value="Otra">Otra</option>
                        </select>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="form-section">
                    <h3>📧 Información de Contacto</h3>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico *</label>
                        <input type="email" id="correo" name="correo" required
                               placeholder="ejemplo@correo.com">
                    </div>

                    <div class="form-group">
                        <label for="celular">Celular *</label>
                        <input type="tel" id="celular" name="celular" required
                               placeholder="Ej: 64606415 o +507 6460-6415">
                    </div>
                </div>

                <!-- Temas de Interés -->
                <div class="form-section checkbox-section">
                    <h3>🚀 Temas Tecnológicos de Interés *</h3>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Inteligencia Artificial" id="ia">
                            <label for="ia">Inteligencia Artificial</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Desarrollo Web" id="web">
                            <label for="web">Desarrollo Web</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Ciberseguridad" id="cyber">
                            <label for="cyber">Ciberseguridad</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Blockchain" id="blockchain">
                            <label for="blockchain">Blockchain</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Internet de las Cosas" id="iot">
                            <label for="iot">Internet de las Cosas</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="temas[]" value="Realidad Virtual" id="vr">
                            <label for="vr">Realidad Virtual</label>
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="form-section">
                    <h3>📋 Información Adicional</h3>

                    <div class="form-group">
                        <label for="observaciones">Observaciones o Consulta sobre el evento</label>
                        <textarea id="observaciones" name="observaciones" rows="4"
                                  placeholder="Escribe tus comentarios o preguntas aquí..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_formulario">Fecha del Formulario *</label>
                        <input type="date" id="fecha_formulario" name="fecha_formulario" required>
                    </div>
                </div>
            </div>

            <!-- Botón de Envío -->
            <div class="action-section">
                <button type="submit" class="btn btn-submit">
                    📨 Enviar Formulario
                </button>
            </div>
        </form>

        <div class="report-link">
            <a href="report.php">📊 Ver Reporte de Registros</a>
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

    <script src="js/script.js"></script>
</body>
</html>