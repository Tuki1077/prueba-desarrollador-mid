-- Sección 3: SQL
-- Script para insertar 100 usuarios de prueba

USE landing_page_db;

-- 1. Insertar 100 usuarios de prueba
INSERT INTO usuarios (nombre, correo, password_hash, fecha_nacimiento)
SELECT 
    CONCAT('Usuario ', n) AS nombre,
    CONCAT('usuario', n, '@ejemplo.com') AS correo,
    SHA2(CONCAT('Password!', n), 256) AS password_hash,
    DATE_ADD('1980-01-01', INTERVAL (FLOOR(1 + (RAND() * 8000))) DAY) AS fecha_nacimiento
FROM (
    SELECT @row := @row + 1 AS n
    FROM information_schema.tables t1, information_schema.tables t2, (SELECT @row:=0) init
    LIMIT 100
) x;

-- 2. Consulta: Usuarios registrados en los últimos 30 días
SELECT id, nombre, correo, fecha_registro 
FROM usuarios 
WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 30 DAY)
ORDER BY fecha_registro DESC;

-- 3. Consulta: Contar usuarios con correo @gmail.com
SELECT COUNT(*) as usuarios_gmail 
FROM usuarios 
WHERE correo LIKE '%@gmail.com';

-- 4. Consulta: Actualizar nombre de usuario con id=10
UPDATE usuarios 
SET nombre = 'Usuario Actualizado' 
WHERE id = 10;

-- 5. Consulta: Eliminar usuario con id=15
DELETE FROM usuarios 
WHERE id = 15;

-- Verificaciones adicionales
-- Mostrar todos los usuarios insertados
SELECT COUNT(*) as total_usuarios FROM usuarios;

-- Mostrar algunos usuarios de ejemplo
SELECT id, nombre, correo, fecha_nacimiento, fecha_registro 
FROM usuarios 
LIMIT 10;