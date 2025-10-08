<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = '';

// Response array
$response = ['success' => false, 'message' => '', 'errors' => []];

try {
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }
    
    // Validate CSRF token (simple implementation)
    if (!isset($_POST['token']) || empty($_POST['token'])) {
        throw new Exception('Token de seguridad requerido');
    }
    
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Sanitize and validate input data
    $nombre = sanitizeInput($_POST['nombre'] ?? '');
    $correo = sanitizeInput($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    $fechaNacimiento = sanitizeInput($_POST['fechaNacimiento'] ?? '');
    
    // Validation array
    $errors = [];
    
    // Validate nombre
    if (empty($nombre)) {
        $errors['nombre'] = 'El nombre es requerido';
    } elseif (strlen($nombre) < 2) {
        $errors['nombre'] = 'El nombre debe tener al menos 2 caracteres';
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        $errors['nombre'] = 'El nombre solo puede contener letras y espacios';
    }
    
    // Validate correo
    if (empty($correo)) {
        $errors['correo'] = 'El correo es requerido';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = 'El correo no tiene un formato válido';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        if ($stmt->fetch()) {
            $errors['correo'] = 'Este correo ya está registrado';
        }
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'La contraseña es requerida';
    } else {
        $passwordErrors = [];
        
        if (strlen($password) < 8) {
            $passwordErrors[] = 'al menos 8 caracteres';
        }
        
        $uppercaseCount = preg_match_all('/[A-Z]/', $password);
        if ($uppercaseCount < 2) {
            $passwordErrors[] = 'mínimo 2 mayúsculas';
        }
        
        if (!preg_match('/\d/', $password)) {
            $passwordErrors[] = 'al menos 1 dígito';
        }
        
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $passwordErrors[] = 'al menos 1 carácter especial';
        }
        
        if (!empty($passwordErrors)) {
            $errors['password'] = 'La contraseña debe tener: ' . implode(', ', $passwordErrors);
        }
    }
    
    // Validate fecha de nacimiento
    if (empty($fechaNacimiento)) {
        $errors['fechaNacimiento'] = 'La fecha de nacimiento es requerida';
    } else {
        $birthDate = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        $today = new DateTime();
        
        if (!$birthDate) {
            $errors['fechaNacimiento'] = 'Formato de fecha inválido';
        } else {
            $age = $today->diff($birthDate)->y;
            
            if ($age < 17) {
                $errors['fechaNacimiento'] = 'Debes ser mayor de 17 años para registrarte';
            }
            
            if ($birthDate > $today) {
                $errors['fechaNacimiento'] = 'La fecha de nacimiento no puede ser futura';
            }
        }
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        $response['errors'] = $errors;
        $response['message'] = 'Error de validación';
        echo json_encode($response);
        exit;
    }
    
    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into database
    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nombre, correo, password_hash, fecha_nacimiento) 
        VALUES (?, ?, ?, ?)
    ");
    
    $result = $stmt->execute([$nombre, $correo, $passwordHash, $fechaNacimiento]);
    
    if ($result) {
        $userId = $pdo->lastInsertId();
        $response['success'] = true;
        $response['message'] = 'Usuario registrado exitosamente';
        $response['userId'] = $userId;
        
        // Log successful registration (optional)
        error_log("Usuario registrado: ID=$userId, Correo=$correo, Fecha=" . date('Y-m-d H:i:s'));
    } else {
        throw new Exception('Error al insertar usuario en la base de datos');
    }
    
} catch (PDOException $e) {
    error_log("Error de base de datos: " . $e->getMessage());
    
    // Check if it's a duplicate entry error
    if ($e->getCode() == 23000) {
        $response['errors']['correo'] = 'Este correo ya está registrado';
        $response['message'] = 'Error de validación';
    } else {
        $response['message'] = 'Error de conexión a la base de datos';
    }
    
} catch (Exception $e) {
    error_log("Error general: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

// Return response
echo json_encode($response);

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate CSRF token (basic implementation)
 * In production, use a more robust token system
 */
function validateToken($token) {
    // Basic validation - in production, implement proper CSRF protection
    return !empty($token) && strlen($token) >= 10;
}

/**
 * Log security events
 */
function logSecurityEvent($event, $details = []) {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event' => $event,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'details' => $details
    ];
    
    error_log("Security Event: " . json_encode($logData));
}
?>
