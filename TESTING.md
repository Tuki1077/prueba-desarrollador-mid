# Instrucciones de Prueba Local

## Opción 1: Usando XAMPP (Recomendado)

### Instalación de XAMPP
1. Descarga XAMPP desde: https://www.apachefriends.org/download.html
2. Instala XAMPP siguiendo las instrucciones del instalador
3. Inicia los servicios Apache y MySQL desde el panel de control

### Configuración del proyecto
1. Copia toda la carpeta del proyecto a: `/Applications/XAMPP/xamppfiles/htdocs/` (macOS) o `C:\xampp\htdocs\` (Windows)
2. Abre phpMyAdmin en: http://localhost/phpmyadmin
3. Ejecuta el script SQL del archivo `database_setup.sql`:
   - Crea la base de datos `landing_page_db`
   - Ejecuta el script para crear la tabla `usuarios`

### Prueba la aplicación
- Accede a: http://localhost/prueba-desarrollador-mid/landing/
- El formulario debería funcionar completamente

## Opción 2: Usando PHP integrado (Si PHP está instalado)

### Verificar PHP
```bash
php --version
```

### Si PHP está instalado:
```bash
cd /ruta/al/proyecto
php -S localhost:8000
```

### Luego acceder a:
- http://localhost:8000/landing/

## Opción 3: Solo Frontend (Para probar diseño)

### Abrir directamente en navegador
- Navega a la carpeta `landing/`
- Abre `index.html` directamente en tu navegador
- **Nota**: El formulario no funcionará sin servidor PHP, pero podrás ver:
  - Diseño responsive
  - Validaciones JavaScript del lado cliente
  - Funcionalidad de collapse de productos
  - Navegación suave

## Casos de Prueba Rápida

### 1. Validaciones Frontend (Funciona sin servidor)
- Nombre: "Juan Pérez"
- Email: "test@example.com"
- Contraseña: "MiPassword123!"
- Fecha: "2000-01-15"

### 2. Errores Frontend (Para probar validaciones)
- Email inválido: "test@"
- Contraseña débil: "123"
- Edad menor: "2010-01-01"

### 3. Funcionalidades Interactivas
- Clic en categorías de productos para expandir/colapsar
- Navegación del menú
- Resize de ventana para ver responsive design

## Estructura de Archivos Final

```
prueba-desarrollador-mid/
├── README.md                     # Documentación completa
├── IA_Prompts.md                # Documentación del proceso con IA
├── database_setup.sql           # Script de base de datos
├── TESTING.md                   # Este archivo de pruebas
├── landing/
│   ├── index.html              # Página principal con HTML semántico
│   ├── assets/
│   │   └── logo.svg            # Logo vectorial personalizado
│   └── js/
│       └── app.js              # Validaciones JavaScript completas
└── api/
    └── registro.php            # Backend PHP con seguridad
```

## Verificación de Funcionalidades

### ✅ HTML Semántico
- Header con logo y menú ✓
- Formulario de registro completo ✓
- Sección de productos en grid ✓
- Footer con redes sociales ✓

### ✅ Validaciones JavaScript
- Email válido con regex ✓
- Contraseña: 8+ chars, 2+ mayúsculas, 1+ dígito, 1+ especial ✓
- Edad 17+ años ✓
- Validación en tiempo real ✓

### ✅ Funcionalidades Interactivas
- Productos colapsables (3 categorías, 9 productos) ✓
- Navegación suave ✓
- Diseño responsive ✓

### ✅ Backend PHP (Requiere servidor)
- Sanitización de datos ✓
- Hash de contraseñas ✓
- Token CSRF básico ✓
- Conexión MySQL ✓
- Respuestas JSON ✓

## Notas Importantes

- **Sin servidor PHP**: Solo funciona el frontend (HTML/CSS/JS)
- **Con XAMPP**: Funcionalidad completa incluyendo registro en BD
- **Responsive**: Probado en móvil y desktop
- **Compatibilidad**: Navegadores modernos (Chrome, Firefox, Safari, Edge)