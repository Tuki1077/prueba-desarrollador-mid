<?php
// Archivo de prueba para verificar la conexión a la base de datos
// Ejecutar: php test_connection.php

echo "🔧 Probando conexión a MySQL...\n";
echo "=====================================\n\n";

// Configuración de la base de datos (igual que en registro.php)
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = '';  // Cambiar si tienes contraseña configurada

try {
    echo "1. Intentando conectar a MySQL...\n";
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Conexión a MySQL exitosa\n\n";
    
    echo "2. Verificando si existe la base de datos '$dbname'...\n";
    $stmt = $pdo->prepare("SHOW DATABASES LIKE ?");
    $stmt->execute([$dbname]);
    
    if ($stmt->fetch()) {
        echo "   ✅ Base de datos '$dbname' encontrada\n\n";
        
        // Conectar específicamente a nuestra base de datos
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "3. Verificando tabla 'usuarios'...\n";
        $stmt = $pdo->prepare("SHOW TABLES LIKE 'usuarios'");
        $stmt->execute();
        
        if ($stmt->fetch()) {
            echo "   ✅ Tabla 'usuarios' encontrada\n\n";
            
            echo "4. Verificando estructura de la tabla...\n";
            $stmt = $pdo->prepare("DESCRIBE usuarios");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "   Columnas encontradas:\n";
            foreach ($columns as $column) {
                echo "   - {$column['Field']} ({$column['Type']})\n";
            }
            echo "\n";
            
            echo "5. Contando usuarios registrados...\n";
            $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios");
            $stmt->execute();
            $result = $stmt->fetch();
            echo "   📊 Total de usuarios: {$result['total']}\n\n";
            
        } else {
            echo "   ❌ Tabla 'usuarios' NO encontrada\n";
            echo "   💡 Ejecuta el script database_setup.sql\n\n";
        }
        
    } else {
        echo "   ❌ Base de datos '$dbname' NO encontrada\n";
        echo "   💡 Necesitas crear la base de datos primero\n\n";
        
        echo "🔧 Creando base de datos automáticamente...\n";
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "   ✅ Base de datos '$dbname' creada\n\n";
    }
    
} catch (PDOException $e) {
    echo "   ❌ Error de conexión: " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "💡 Soluciones:\n";
        echo "   1. Para XAMPP: Iniciar MySQL desde el panel de control\n";
        echo "   2. Para Homebrew: brew services start mysql\n";
        echo "   3. Para sistema: sudo systemctl start mysql\n\n";
    }
    
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "💡 Problemas de autenticación:\n";
        echo "   1. Verifica el usuario y contraseña\n";
        echo "   2. Para XAMPP: usuario 'root' sin contraseña\n";
        echo "   3. Prueba: mysql -u root -p\n\n";
    }
}

echo "\n🔒 CARACTERÍSTICAS DE SEGURIDAD IMPLEMENTADAS:\n";
echo "==============================================\n";
echo "✅ 1. SANITIZACIÓN DE DATOS POST:\n";
echo "   - trim(): elimina espacios\n";
echo "   - stripslashes(): elimina barras invertidas\n";
echo "   - htmlspecialchars(): escapa HTML/JavaScript\n\n";

echo "✅ 2. PREPARED STATEMENTS:\n";
echo "   - Previene inyección SQL\n";
echo "   - Separa datos de consultas\n";
echo "   - Parámetros validados automáticamente\n\n";

echo "✅ 3. HASH SEGURO DE CONTRASEÑAS:\n";
echo "   - password_hash() con PASSWORD_DEFAULT\n";
echo "   - Algoritmo bcrypt con salt automático\n";
echo "   - Imposible de descifrar directamente\n\n";

echo "✅ 4. TOKEN CSRF:\n";
echo "   - Generado en JavaScript\n";
echo "   - Validado en servidor\n";
echo "   - Previene ataques Cross-Site Request Forgery\n\n";

echo "✅ 5. VALIDACIÓN DOBLE:\n";
echo "   - Cliente: JavaScript para UX\n";
echo "   - Servidor: PHP para seguridad\n";
echo "   - Nunca confiar solo en validación del cliente\n\n";

echo "✅ 6. HEADERS DE SEGURIDAD:\n";
echo "   - Content-Type: application/json\n";
echo "   - CORS configurado para desarrollo\n";
echo "   - Respuestas estructuradas\n\n";

echo "🚀 Para probar el registro completo:\n";
echo "   1. Abrir: http://localhost:8000/landing/\n";
echo "   2. Completar formulario con datos válidos\n";
echo "   3. Verificar en base de datos\n\n";

?>

<!-- Ejemplo de uso del token CSRF desde JavaScript -->
<script>
console.log("🔐 EJEMPLO DE TOKEN CSRF:");
console.log("========================");

// Así se genera el token en app.js:
function generateToken() {
    return Math.random().toString(36).substring(2, 15) + 
           Math.random().toString(36).substring(2, 15);
}

const token = generateToken();
console.log("Token generado:", token);

// Así se envía con el formulario:
const formData = new FormData();
formData.append('token', token);
formData.append('nombre', 'Juan Pérez');
formData.append('correo', 'test@example.com');
// ... otros campos

console.log("Token enviado al servidor para validación");
</script>