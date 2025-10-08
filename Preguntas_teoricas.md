# Sección 1: HTML, CSS Y JS

## 1. ¿Cuál es la diferencia entre etiquetas semánticas y no semánticas en HTML?

###
- **Etiquetas Semánticas**: Estas etiquetas tienen un significado propio para el navegador y para el Dev. Describen el contenido que encierran. 

**Ejemplo**: 
```HTML
<header></header>
<nav></nav>
<footer></footer>
```

- **Etiquetas No Semánticas**: Estas etiquetas no tienen un significado como tal, solor sirven para ordenar o para estilos visuales. 

**Ejemplo**: 
```HTML
<div></div>
<span></span>
```

## 2. ¿Qué ventajas tiene usar Flexbox o Grid en CSS?

###
- ***Diferencias**: Ambos sirven para diseñar layouts. Flexbox se usa para diseños que son en una sola dimensión ya sea para fila o columna. Mientras que Grid se usa cuando estamos trabsjando con diseños en dos dimensiones (filas y columnas).

## 3. Diferencia entre usar == y === en JS

###
- ***Diferencias**: == compara solo valores y hace conversiones de tipo automaticamente. Mientras que === compara valor y tipo de dato al mismo tiempo. 
- **Ejemplo**: Este enunciado es True dado que esta comparando si 5 es igual a 5 sin importar que uno sea string y el otro sea int.
```JS
"5" == 5 
```

- **Ejemplo**: Este enunciado es falso dado que aunque 5 = 5, uno es string y el otro es int, por lo tanto es falso. 
```JS
"5" === 5 
```


## 4. Que es el DOM y como lo manipularía con JS:

###
- **¿Que es?**: DOM es una representación del contenido HTML de una página. Cada etiquea de HTML se convierte en un elemento que luego le da acceso a JS para manipularlo. 

```HTML
<body>
    <h1 id = "titulo-pagina">Hola mundo</h1>
</body>
```

**Como manipularlo con JS:**
```JS
const titulo = document.getElementById("titulo-pagina");
//Cambiar el texto
titulo.textconect = "Hola Usuario";

//cambiar estilo
titulo.style.color = "white";

//crear neuvos elementos
const nuevoParrafor = document.createElement("p");
nuevoParrado.textContent = "Cambios en JS";
document.body.appendChild(nuevoParrafo)
```


# Sección 2: PHP - backend

## 1. Diferencia entre $_GET y $_POST en php


### 
- **GET**: Utilizamos GET para obtener información. El uso típico es para hacer consultas o búsquedad sin cambiar datos. 
- **Características**:
  - **Forma de envío**: Los datos se envían en la URL.
  - **Ejemplo**: pagina.php?nombre= Juan&edad=24

- **POST**: Utilizamos POST para enviar o guardar información. Su uso típico son para modificar datos como un login, registros, etc...

- **Características**:
  - **Forma de envío**:  En el cuerpo de la solicitud HTTP.
  - **Ejemplo**: Al ser ocultos no muestra nada en la URL. Se ve de la siguiente manera:

```php
Nombre: Juan Luis
Correo: juan@ejemplo.com
Edad: 24
```

## 2. ¿Por qué es importante usar password_hash()?

###

- **¿Por qué?**: sirve para proteger contraseñas de usuario antes de guardarla en base de datos. Es importante ya que podemos encriptar contraseñas para nos guardarlas como tal en base de datos y asi protegemos credenciales. 

**Ejemplo:**
```PHP
$clave = $_POST['clave'];
$clave_segura = password_hash($clave, PASSWORD_DEFAULT);

mysqli_query($conn, "INSERT INTO usuarios (usuario, clave) VALUES ('$usuario', '$clave_segura')");
```

- **Resultado**: Sería una cadena irreconocible de letras, simbolos y números. 



# Sección 3: SQL - Preguntas Teóricas

## 1. Diferencia entre INNER JOIN y LEFT JOIN

### INNER JOIN
- **Definición**: En llamabas a base de datos solo muestra las filas que coinciden en ambas tablas. Es decir, si hago un INNER JOIN entre una tabla de clientes y pedidos, solo se muestran los clientes que tienen pedidos registrados.
- **Comportamiento**: Si no hay coincidencia, la fila no aparece en el resultado.

**Ejemplo:**
```sql
SELECT u.nombre, p.NumeroPedido 
FROM Clientes c 
INNER JOIN Pedidos p ON c.IdCliente = p.IdCliente;
```
*Solo muestra clientes que tienen pedidos.*

### LEFT JOIN (LEFT OUTER JOIN)
- **Definición**: Muestra todas las filas de la izquierda, aunque no hayan coincidencia en la tabla de la derecha. 
- **Comportamiento**: Si no hay coincidencia, muestra NULL para las columnas de la tabla derecha.

**Ejemplo:**
```sql
SELECT u.nombre, p.NumeroPedido 
FROM Clientes c 
LEFT JOIN Pedidos p ON c.IdCliente = p.IdCliente;
```
*Muestra todos los clientes, y si alguno no tiene pedidos, se vera NULL en la columna de pedidos.*

## 2. Clave Primaria y Clave Foránea

### Clave Primaria (Primary Key)
- **Definición**: Es la columna en base de datos que identifica de forma única cada fila en una tabla. 
- **Características**:
  - **Único**: No puede repetirse ni ser NULL
  - **Inmutable**: No debería cambiar una vez asignado
  - **Una por tabla**: Solo puede existir una clave primaria por tabla

**Ejemplo:**
```sql
CREATE TABLE usuarios (
    IdUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE
);
```

### Clave Foránea (Foreign Key)
- **Definición**: Es una columna que conecta una tabla con otra. Sirve para establecer una relación entre datos y este indica que un vaor en una tabla viene o depende de otra tabla. 
- **Características**:
  - **Puede ser nula**: A menos que se especifique lo contrario
  - **Múltiples por tabla**: Una tabla puede tener varias claves foráneas
  - **Restricciones**: Previene acciones que destruirían vínculos entre tablas

**Ejemplo:**
```sql
CREATE TABLE Pedidos (
    IdPedido INT PRIMARY KEY AUTO_INCREMENT,
    Fecha VARCHAR(200),
    IdCliente INT,
    FOREIGN KEY (IdCliente) REFERENCES Clientes(IdCliente)
);
```

# Sección 4: Python - Preguntas Teóricas

## 1. ¿Qué ventajas tiene Python para análisis de datos?

### Sintaxis Simple y Legible
- **Fácil aprendizaje**: Sintaxis clara e intuitiva, ideal para científicos y analistas sin formación profunda en programación
- **Código limpio**: Menos líneas de código para realizar tareas complejas comparado con otros lenguajes
- **Mantenibilidad**: El código es fácil de leer, entender y modificar

### Ecosistema Rico en Librerías Especializadas
- **NumPy**: Cálculos numéricos y matrices
- **Pandas**: Manejo de datos tipo tabla. 
- **Matplotlib/Seaborn**: Visualización de gráficas de datos. 
- **Scikit-learn**: Machine Learning.

### Datos
- **Automatización**: Se puede usar python para limpiar, procesar, analizar y visualizar datos. 
-**Integración**: Se conecta fácilmente con SQL, Excel, JSON, APIs y otras tecnologías. 


## 2. Diferencia entre Lista y Diccionario

### Lista (List)
- **Definición**: Colección ordenada y mutable de elementos que permite duplicados
- **Características**:
  - **Indexación numérica**: Se accede por índices (0, 1, 2, ...)
  - **Ordenada**: Mantiene el orden de inserción
  - **Mutable**: Se pueden modificar elementos después de la creación
  - **Duplicados permitidos**: Puede contener elementos repetidos

**Ejemplo:**
```python
# Creación y uso de listas
frutas = ['manzana', 'banana', 'manzana', 'naranja']
print(frutas[0])        # 'manzana' - acceso por índice
frutas.append('pera')   # Agregar elemento
frutas[1] = 'kiwi'      # Modificar elemento
print(len(frutas))      # 5 - longitud de la lista
```

### Diccionario (Dictionary)
- **Definición**: Colección no ordenada y mutable de pares clave-valor únicos
- **Características**:
  - **Claves únicas**: No puede haber claves duplicadas
  - **Acceso por clave**: Se accede usando claves en lugar de índices
  - **Mutable**: Se pueden agregar, modificar y eliminar elementos
  - **Optimizado**: Búsqueda muy eficiente O(1) promedio

**Ejemplo:**
```python
# Creación y uso de diccionarios
persona = {
    'nombre': 'Juan',
    'edad': 30,
    'ciudad': 'Madrid',
    'activo': True
}

print(persona['nombre'])     # 'Juan' - acceso por clave
persona['telefono'] = '123'  # Agregar nuevo elemento
persona['edad'] = 31         # Modificar elemento existente
print(persona.keys())        # Obtener todas las claves
```
