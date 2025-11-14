document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado correctamente');
    
    const form = document.getElementById('registrationForm');
    const fechaInput = document.getElementById('fecha_formulario');
    
    if (!form) {
        console.error('No se encontró el formulario con ID registrationForm');
        return;
    }
    
    if (!fechaInput) {
        console.error('No se encontró el campo fecha_formulario');
        return;
    }
    
    // Establecer fecha actual como valor por defecto
    const today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    console.log('Fecha establecida:', today);
    
    // Validación personalizada para nombres y apellidos
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    
    function formatName(input) {
        if (input && input.value) {
            // Convertir a minúsculas primero
            let formatted = input.value.toLowerCase();
            
            // Capitalizar primera letra de cada palabra (respetando tildes)
            formatted = formatted.replace(/(?:^|\s)\S/g, function(a) { 
                return a.toUpperCase(); 
            });
            
            // Permitir solo letras, espacios y caracteres especiales del español
            formatted = formatted.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
            
            input.value = formatted;
            console.log('Nombre formateado:', input.value);
        }
    }
    
    if (nombreInput) {
        nombreInput.addEventListener('blur', function() {
            formatName(this);
        });
        
        // Permitir tildes mientras se escribe
        nombreInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
        });
    }
    
    if (apellidoInput) {
        apellidoInput.addEventListener('blur', function() {
            formatName(this);
        });
        
        // Permitir tildes mientras se escribe
        apellidoInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
        });
    }
    
    // Mapeo de países a nacionalidades
    const paisNacionalidadMap = {
        'Panamá': 'Panameña',
        'Belice': 'Beliceña',
        'Suiza': 'Suiza',
        'Guatemala': 'Guatemalteca',
        'México': 'Mexicana',
        'Colombia': 'Colombiana',
        'Otro': 'Otra'
    };
    
    // Sincronizar selección de país con nacionalidad
    const paisSelect = document.getElementById('pais_residencia');
    const nacionalidadSelect = document.getElementById('nacionalidad');
    
    if (paisSelect && nacionalidadSelect) {
        paisSelect.addEventListener('change', function() {
            const paisSeleccionado = this.value;
            console.log('País seleccionado:', paisSeleccionado);
            if (paisSeleccionado && paisNacionalidadMap[paisSeleccionado]) {
                nacionalidadSelect.value = paisNacionalidadMap[paisSeleccionado];
                console.log('Nacionalidad actualizada:', nacionalidadSelect.value);
            }
        });
    }
    
    // Validación de celular mejorada
    const celularInput = document.getElementById('celular');
    if (celularInput) {
        celularInput.addEventListener('input', function() {
            // Permitir solo números, espacios, guiones, paréntesis y +
            this.value = this.value.replace(/[^\d+\-\s()]/g, '');
        });
    }
    
    // Validación de formulario antes de enviar
    form.addEventListener('submit', function(e) {
        console.log('Formulario enviándose...');
        let isValid = true;
        const temas = document.querySelectorAll('input[name="temas[]"]:checked');
        const errorMessages = [];
        
        // Validar que se haya seleccionado al menos un tema
        if (temas.length === 0) {
            errorMessages.push('❌ Por favor, seleccione al menos un tema tecnológico de interés.');
            isValid = false;
        }
        
        // Validar fecha futura
        const fechaFormulario = new Date(fechaInput.value);
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        
        if (fechaFormulario > hoy) {
            errorMessages.push('❌ La fecha del formulario no puede ser futura.');
            isValid = false;
        }
        
        // Validar edad
        const edadInput = document.getElementById('edad');
        if (edadInput && (edadInput.value < 1 || edadInput.value > 120)) {
            errorMessages.push('❌ La edad debe estar entre 1 y 120 años.');
            isValid = false;
        }
        
        // Validar celular
        if (celularInput) {
            const celularLimpio = celularInput.value.replace(/[^\d]/g, '');
            if (celularLimpio.length < 7) {
                errorMessages.push('❌ El número de celular debe tener al menos 7 dígitos.');
                isValid = false;
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('⚠️ Por favor, corrija los siguientes errores:\n\n' + errorMessages.join('\n'));
            console.log('Errores de validación:', errorMessages);
        } else {
            console.log('Formulario válido, enviando...');
        }
    });
    
    console.log('Todas las funciones JavaScript cargadas correctamente');
});