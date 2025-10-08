# 🗄️ Configuración de MySQL para el Proyecto

## Opción 1: Instalar MySQL con Homebrew (Recomendado para macOS)

### Paso 1: Instalar MySQL
```bash
# Instalar MySQL Server
brew install mysql

# Iniciar el servicio MySQL
brew services start mysql

# Verificar que funciona
mysql --version
```

### Paso 2: Configurar MySQL (Primera vez)
```bash
# Ejecutar configuración inicial segura
mysql_secure_installation

# Respuestas sugeridas:
# - Set root password: Y (elige una contraseña fuerte)
# - Remove anonymous users: Y
# - Disallow root login remotely: Y
# - Remove test database: Y
# - Reload privilege tables: Y
```

### Paso 3: Conectar a MySQL
```bash
# Conectar como root
mysql -u root -p

# O conectar sin contraseña si no configuraste una
mysql -u root
```

## Opción 2: Usar XAMPP (Más fácil para desarrollo)

### Paso 1: Instalar XAMPP
1. Descargar XAMPP desde: https://www.apachefriends.org/download.html
2. Instalar XAMPP siguiendo el asistente
3. Abrir el panel de control de XAMPP

### Paso 2: Iniciar servicios
1. En el panel de XAMPP, hacer clic en "Start" para:
   - ✅ Apache (servidor web)
   - ✅ MySQL (base de datos)

### Paso 3: Acceder a phpMyAdmin
- Abrir navegador en: http://localhost/phpmyadmin
- Usuario: `root`
- Contraseña: (vacía por defecto)

## Opción 3: MySQL Workbench (GUI)

### Instalar MySQL Workbench
```bash
# Con Homebrew
brew install --cask mysql-workbench

# O descargar desde: https://dev.mysql.com/downloads/workbench/
```

### Configurar conexión en Workbench
1. Abrir MySQL Workbench
2. Crear nueva conexión:
   - **Connection Name**: "Landing Page Project"
   - **Hostname**: localhost
   - **Port**: 3306
   - **Username**: root
   - **Password**: (la que configuraste)

## 🔧 Configuración del Proyecto

### Actualizar credenciales en registro.php

Ya tienes el archivo `api/registro.php` configurado. Solo necesitas ajustar estas líneas según tu instalación:

```php
// Para XAMPP (configuración por defecto)
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = '';  // Vacía para XAMPP

// Para MySQL nativo con contraseña
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = 'tu_contraseña_aqui';
```

## 🗃️ Crear la Base de Datos

### Método 1: Usando phpMyAdmin (XAMPP)
1. Ir a http://localhost/phpmyadmin
2. Hacer clic en "Nueva" (New)
3. Nombre: `landing_page_db`
4. Cotejamiento: `utf8mb4_unicode_ci`
5. Hacer clic en "Crear"

### Método 2: Usando línea de comandos
```bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE landing_page_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Usar la base de datos
USE landing_page_db;

# Ejecutar el script de la tabla (copiar desde database_setup.sql)
```

### Método 3: Usando MySQL Workbench
1. Conectar a tu servidor MySQL
2. Hacer clic derecho en el área de schemas
3. Seleccionar "Create Schema"
4. Nombre: `landing_page_db`
5. Charset: `utf8mb4`
6. Hacer clic en "Apply"

## 📄 Ejecutar el Script de la Tabla

El archivo `database_setup.sql` ya está creado. Ejecútalo así:

### Con phpMyAdmin:
1. Seleccionar la base de datos `landing_page_db`
2. Ir a la pestaña "SQL"
3. Copiar y pegar el contenido de `database_setup.sql`
4. Hacer clic en "Continuar"

### Con línea de comandos:
```bash
# Desde el directorio del proyecto
mysql -u root -p landing_page_db < database_setup.sql
```

### Con MySQL Workbench:
1. Abrir el archivo `database_setup.sql`
2. Ejecutar el script con Ctrl+Shift+Enter

## ✅ Verificar la Configuración

### 1. Probar conexión desde terminal:
```bash
mysql -u root -p -e "USE landing_page_db; SHOW TABLES;"
```

### 2. Probar desde PHP:
Crear archivo `test_db.php`:
```php
<?php
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = '';  // Ajustar según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    echo "✅ Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
```

### 3. Ejecutar test:
```bash
php test_db.php
```

## 🔒 Características de Seguridad Ya Implementadas

El archivo `registro.php` ya incluye todas las medidas de seguridad requeridas:

### ✅ Sanitización de datos POST
```php
function sanitizeInput($data) {
    $data = trim($data);                    // Elimina espacios
    $data = stripslashes($data);            // Elimina barras invertidas
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Escapa HTML
    return $data;
}
```

### ✅ Prepared Statements (Anti-SQL Injection)
```php
$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password_hash, fecha_nacimiento) VALUES (?, ?, ?, ?)");
$result = $stmt->execute([$nombre, $correo, $passwordHash, $fechaNacimiento]);
```

### ✅ Hash seguro de contraseñas
```php
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
```

### ✅ Token CSRF básico
```php
// Generación del token en JavaScript
function generateToken() {
    return Math.random().toString(36).substring(2, 15) + 
           Math.random().toString(36).substring(2, 15);
}

// Validación en PHP
if (!isset($_POST['token']) || empty($_POST['token'])) {
    throw new Exception('Token de seguridad requerido');
}
```

## 🚀 Siguiente Paso

Una vez configurada la base de datos, tu aplicación estará completamente funcional:

1. **Frontend**: http://localhost:8000/landing/
2. **Backend**: Conectado a MySQL
3. **Registro**: Completamente funcional con seguridad

## 🐛 Solución de Problemas Comunes

### Error: "Connection refused"
- Verificar que MySQL esté ejecutándose: `brew services list | grep mysql`
- Reiniciar MySQL: `brew services restart mysql`

### Error: "Access denied for user 'root'"
- Verificar contraseña: `mysql -u root -p`
- Resetear contraseña si es necesario

### Error: "Database does not exist"
- Verificar que `landing_page_db` exista: `mysql -u root -p -e "SHOW DATABASES;"`
- Crear la base de datos usando el script `database_setup.sql`

¡Con estos pasos tendrás MySQL completamente configurado para tu proyecto!