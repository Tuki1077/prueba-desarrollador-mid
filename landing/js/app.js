// Form validation and submission handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const successMessage = document.getElementById('successMessage');
    
    // Form elements
    const nombreInput = document.getElementById('nombre');
    const correoInput = document.getElementById('correo');
    const passwordInput = document.getElementById('password');
    const fechaNacimientoInput = document.getElementById('fechaNacimiento');
    
    // Error message elements
    const nombreError = document.getElementById('nombreError');
    const correoError = document.getElementById('correoError');
    const passwordError = document.getElementById('passwordError');
    const fechaNacimientoError = document.getElementById('fechaNacimientoError');
    
    // Real-time validation
    nombreInput.addEventListener('blur', validateNombre);
    correoInput.addEventListener('blur', validateCorreo);
    passwordInput.addEventListener('blur', validatePassword);
    fechaNacimientoInput.addEventListener('blur', validateFechaNacimiento);
    
    // Form submission
    form.addEventListener('submit', handleFormSubmit);
    
    /**
     * Validate nombre field
     */
    function validateNombre() {
        const nombre = nombreInput.value.trim();
        
        if (nombre.length < 2) {
            showError(nombreInput, nombreError, 'El nombre debe tener al menos 2 caracteres');
            return false;
        }
        
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombre)) {
            showError(nombreInput, nombreError, 'El nombre solo puede contener letras y espacios');
            return false;
        }
        
        hideError(nombreInput, nombreError);
        return true;
    }
    
    /**
     * Validate correo field
     */
    function validateCorreo() {
        const correo = correoInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!emailRegex.test(correo)) {
            showError(correoInput, correoError, 'Por favor ingresa un correo electrónico válido');
            return false;
        }
        
        hideError(correoInput, correoError);
        return true;
    }
    
    /**
     * Validate password field
     * Requirements: 8+ characters, 2+ uppercase, 1+ digit, 1+ special character
     */
    function validatePassword() {
        const password = passwordInput.value;
        const errors = [];
        
        if (password.length < 8) {
            errors.push('al menos 8 caracteres');
        }
        
        const uppercaseCount = (password.match(/[A-Z]/g) || []).length;
        if (uppercaseCount < 2) {
            errors.push('mínimo 2 mayúsculas');
        }
        
        if (!/\d/.test(password)) {
            errors.push('al menos 1 dígito');
        }
        
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            errors.push('al menos 1 carácter especial');
        }
        
        if (errors.length > 0) {
            showError(passwordInput, passwordError, `La contraseña debe tener: ${errors.join(', ')}`);
            return false;
        }
        
        hideError(passwordInput, passwordError);
        return true;
    }
    
    /**
     * Validate fecha de nacimiento field
     * Must be 17+ years old
     */
    function validateFechaNacimiento() {
        const fechaNacimiento = new Date(fechaNacimientoInput.value);
        const today = new Date();
        const age = today.getFullYear() - fechaNacimiento.getFullYear();
        const monthDiff = today.getMonth() - fechaNacimiento.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < fechaNacimiento.getDate())) {
            age--;
        }
        
        if (isNaN(fechaNacimiento.getTime())) {
            showError(fechaNacimientoInput, fechaNacimientoError, 'Por favor selecciona una fecha válida');
            return false;
        }
        
        if (age < 17) {
            showError(fechaNacimientoInput, fechaNacimientoError, 'Debes ser mayor de 17 años para registrarte');
            return false;
        }
        
        if (fechaNacimiento > today) {
            showError(fechaNacimientoInput, fechaNacimientoError, 'La fecha de nacimiento no puede ser futura');
            return false;
        }
        
        hideError(fechaNacimientoInput, fechaNacimientoError);
        return true;
    }
    
    /**
     * Show error message and style
     */
    function showError(input, errorElement, message) {
        input.classList.add('error');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    /**
     * Hide error message and style
     */
    function hideError(input, errorElement) {
        input.classList.remove('error');
        errorElement.style.display = 'none';
    }
    
    /**
     * Handle form submission
     */
    async function handleFormSubmit(event) {
        event.preventDefault();
        
        // Validate all fields
        const isNombreValid = validateNombre();
        const isCorreoValid = validateCorreo();
        const isPasswordValid = validatePassword();
        const isFechaNacimientoValid = validateFechaNacimiento();
        
        if (!isNombreValid || !isCorreoValid || !isPasswordValid || !isFechaNacimientoValid) {
            return;
        }
        
        // Prepare form data
        const formData = new FormData();
        formData.append('nombre', nombreInput.value.trim());
        formData.append('correo', correoInput.value.trim());
        formData.append('password', passwordInput.value);
        formData.append('fechaNacimiento', fechaNacimientoInput.value);
        
        // Generate CSRF token (simple implementation)
        const token = generateToken();
        formData.append('token', token);
        
        try {
            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Registrando...';
            
            // Send data to PHP backend
            const response = await fetch('../api/registro.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Show success message
                successMessage.style.display = 'block';
                form.reset();
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth' });
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            } else {
                // Handle server errors
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const errorElement = document.getElementById(field + 'Error');
                        const inputElement = document.getElementById(field);
                        if (errorElement && inputElement) {
                            showError(inputElement, errorElement, result.errors[field]);
                        }
                    });
                } else {
                    alert('Error en el registro: ' + (result.message || 'Error desconocido'));
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión. Por favor intenta nuevamente.');
        } finally {
            // Re-enable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Registrarse';
        }
    }
    
    /**
     * Generate simple CSRF token
     */
    function generateToken() {
        return Math.random().toString(36).substring(2, 15) + 
               Math.random().toString(36).substring(2, 15);
    }
});

/**
 * Toggle product category collapse/expand
 */
function toggleCategory(header) {
    const icon = header.querySelector('.collapse-icon');
    const productsList = header.nextElementSibling;
    
    if (productsList.classList.contains('expanded')) {
        productsList.classList.remove('expanded');
        icon.classList.remove('rotated');
        icon.textContent = '▼';
    } else {
        productsList.classList.add('expanded');
        icon.classList.add('rotated');
        icon.textContent = '▲';
    }
}

/**
 * Smooth scroll for navigation links
 */
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('nav a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

/**
 * Form field formatting
 */
document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    
    // Capitalize first letter of each word in nombre
    nombreInput.addEventListener('input', function() {
        let value = this.value;
        // Remove extra spaces and capitalize first letter of each word
        value = value.replace(/\s+/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        this.value = value;
    });
    
    // Prevent spaces at the beginning
    nombreInput.addEventListener('keydown', function(e) {
        if (e.key === ' ' && this.value.length === 0) {
            e.preventDefault();
        }
    });
});
