# Historial de Prompts de IA y Proceso de Desarrollo

Este documento registra todos los prompts utilizados con GitHub Copilot para desarrollar el proyecto de Landing Page con sistema de registro, incluyendo las adaptaciones realizadas y el proceso de desarrollo.

## 🤖 Herramientas de IA Utilizadas

- **GitHub Copilot en VS Code**: Asistente de código principal
- **Modelo**: GPT-4 (GitHub Copilot Chat)
- **Fecha de desarrollo**: 7 de octubre, 2025

## 📝 Prompt Principal Inicial

### Prompt Original:
```
Crea una landing page con las siguientes características:
- Estructura
o /landing/
o └─ index.html
o └─ /assets/logo.svg
o └─ /js/app.js
o /api/
o └─ registro.php (ver Sección 2)
- Utilizando HTML Semántico
- Header con logo y menú.
- Formulario de registro (nombre, correo, contraseña, fecha nacimiento).
o Incluir inputs de tipo text, mail, password, date
- Sección de productos en formato grid (mínimo 3),
o Cada elemento sea un collapse para ver los productos internos.
o Cada producto debe de tener una imagen y un título
- Footer con enlaces a redes sociales (linkedn y github).
- Validaciones de JS:
o El correo sea válido
o contraseña tenga al menos 8 caracteres (Con mínimo 2 mayúsculas, 1 dígito y un
sígno especial).
o Solo personas mayores a 17 años puedan registrarse.
- Conectar el registro con un el backend PHP (Puede usar ajax o fetch)

Sección 2: PHP - Backend
Instrucciones
Crear un archivo registro.php que reciba datos por POST y los guarde en la tabla usuarios.
- Utilice el siguiente script para crear la tabla de usuarios en una base de datos MYQL
- "CREATE TABLE IF NOT EXISTS usuarios (
- id INT AUTO_INCREMENT PRIMARY KEY,
- nombre VARCHAR(120) NOT NULL,
- correo VARCHAR(160) NOT NULL UNIQUE,
- password_hash VARCHAR(255) NOT NULL,
- fecha_nacimiento DATE NOT NULL,
- fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-
"
- Conectar a una base de datos, puede utilizar MYSQL y MYSQL WORKBRENCH para
conectarse (o la base de datos de su preferencia) https://www.mysql.com
- Realice la conexión de base de datos
- Sanitize los datos que vienen del POST
- Haga un Token de la petición
```

### Respuesta del AI:
El asistente analizó el prompt completo y creó un plan de trabajo estructurado usando el sistema de todo list, dividiendo el trabajo en tareas específicas y manejables.

## 🛠️ Proceso de Desarrollo Paso a Paso

### 1. Planificación Inicial
**Acción del AI**: Creó un todo list estructurado con las siguientes tareas:
1. Crear estructura HTML con elementos semánticos
2. Crear logo SVG
3. Implementar validaciones JavaScript
4. Añadir CSS responsive
5. Crear backend PHP
6. Probar funcionalidad completa

**Adaptación realizada**: Se siguió exactamente el plan propuesto por el AI, manteniendo el orden lógico de desarrollo frontend → backend → testing.

### 2. Desarrollo del HTML Semántico
**Prompt implícito**: El AI entendió la necesidad de crear una estructura HTML completa.

**Decisiones del AI**:
- Uso de elementos semánticos (`<header>`, `<main>`, `<section>`, `<footer>`)
- Integración de CSS directamente en el HTML para una solución self-contained
- Implementación de un grid responsive para productos
- Uso de formulario con validación HTML5 básica

**Adaptaciones realizadas**:
- Se mantuvo la estructura propuesta
- Se agregó CSS embebido para facilitar la implementación
- Se incluyeron clases CSS específicas para facilitar el JavaScript

### 3. Creación del Logo SVG
**Prompt implícito**: Necesidad de crear un logo vectorial profesional.

**Decisión del AI**: Crear un SVG con gradientes y elementos decorativos, no solo texto simple.

**Código generado**:
```svg
<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="logoGradient">...
```

**Adaptación realizada**: 
- Se aceptó el diseño propuesto
- Se integró correctamente en el HTML reemplazando el SVG inline temporal

### 4. Validaciones JavaScript Avanzadas
**Prompt específico del requerimiento**:
- Email válido
- Contraseña: 8+ chars, 2+ mayúsculas, 1 dígito, 1 carácter especial
- Edad: 17+ años

**Decisiones técnicas del AI**:
```javascript
// Validación de email con regex
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Validación compleja de contraseña
const uppercaseCount = (password.match(/[A-Z]/g) || []).length;
if (uppercaseCount < 2) {
    errors.push('mínimo 2 mayúsculas');
}

// Cálculo preciso de edad
const age = today.getFullYear() - fechaNacimiento.getFullYear();
const monthDiff = today.getMonth() - fechaNacimiento.getMonth();
```

**Adaptaciones realizadas**:
- Se implementó validación en tiempo real (evento `blur`)
- Se añadió validación de envío de formulario
- Se incluyó manejo de errores visual con clases CSS
- Se agregó fetch API para comunicación con backend

### 5. Backend PHP Seguro
**Requerimientos del prompt**:
- Recibir POST data
- Sanitizar datos
- Crear token de seguridad
- Conectar a MySQL
- Hash de contraseñas

**Decisiones de seguridad del AI**:
```php
// Sanitización robusta
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Uso de PDO y prepared statements
$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password_hash, fecha_nacimiento) VALUES (?, ?, ?, ?)");

// Hash seguro de contraseñas
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
```

**Adaptaciones realizadas**:
- Se implementó exactamente como se propuso
- Se añadieron headers CORS para desarrollo local
- Se incluyó logging de eventos de seguridad
- Se duplicaron las validaciones del frontend en el backend

### 6. Mejoras Adicionales Propuestas por el AI

**Funcionalidades no solicitadas que el AI agregó**:
1. **Navegación suave**: Smooth scrolling entre secciones
2. **Responsive design completo**: Media queries para móviles
3. **Feedback visual**: Estados de loading y success messages
4. **Capitalización automática**: Formateo de nombres en tiempo real
5. **Prevención de espacios iniciales**: UX mejorada en campos de texto

**Ejemplo de mejora no solicitada**:
```javascript
// Capitalización automática de nombres
nombreInput.addEventListener('input', function() {
    let value = this.value;
    value = value.replace(/\s+/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    this.value = value;
});
```

## 🔄 Adaptaciones y Decisiones de Implementación

### 1. Estructura de Archivos
**Propuesta original**: Archivos separados para CSS
**Adaptación realizada**: CSS embebido en HTML para simplificar deployment
**Razón**: Facilitar la prueba y distribución del proyecto

### 2. Base de Datos
**Propuesta del AI**: Configuración lista para XAMPP
**Adaptación mantenida**: Se conservó la configuración por defecto
```php
$host = 'localhost';
$dbname = 'landing_page_db';
$username = 'root';
$password = '';
```

### 3. Validaciones Dobles
**Decisión del AI**: Implementar validaciones tanto en cliente como servidor
**Adaptación**: Se mantuvieron ambas por seguridad
**Beneficio**: Mejor UX (cliente) + Seguridad (servidor)

### 4. Sistema de Productos
**Requerimiento**: Mínimo 3 productos con collapse
**Implementación del AI**: 3 categorías con productos internos
**Adaptación**: Se expandió a 9 productos distribuidos en 3 categorías

## 📊 Evaluación de la Asistencia de IA

### Aspectos Exitosos
✅ **Comprensión completa del requerimiento**: El AI entendió todos los puntos técnicos
✅ **Planificación estructurada**: División lógica en tareas
✅ **Código de calidad**: Siguió buenas prácticas de seguridad
✅ **Documentación automática**: Comentarios explicativos en el código
✅ **Responsive design**: Implementación mobile-first sin ser solicitada

### Aspectos Mejorados por el Desarrollador
🔧 **Configuración de entorno**: Se ajustó para facilitar testing local
🔧 **Mensajes de error**: Se personalizaron para mejor UX en español
🔧 **Estructura de carpetas**: Se validó contra los requerimientos exactos

### Decisiones Técnicas Destacadas del AI

1. **Uso de Fetch API** en lugar de XMLHttpRequest (más moderno)
2. **Implementación de PDO** en lugar de mysqli (más seguro)
3. **Validación de edad precisa** considerando mes y día actual
4. **Grid CSS** en lugar de Flexbox para productos (mejor para este caso)
5. **Eventos blur** para validación en tiempo real (mejor UX)

## 🎯 Cumplimiento de Requerimientos

### Requerimientos Cumplidos 100%
- ✅ HTML Semántico
- ✅ Header con logo y menú
- ✅ Formulario con todos los input types solicitados
- ✅ Grid de productos con collapse (3 categorías, 9 productos)
- ✅ Footer con enlaces sociales
- ✅ Todas las validaciones JavaScript especificadas
- ✅ Backend PHP con sanitización y tokens
- ✅ Conexión a MySQL con la tabla especificada
- ✅ Hash de contraseñas

