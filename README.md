# API REST - Películas 🎬

**TPE Parte 3 - WEB 2 - 2025**

---

## 👥 Integrante

- **Cuello Julian Dario**
  - Responsable: Listado ordenado, PUT, Ordenado por cualquier campo (opcional)

- **Gimenez Jessica Soledad**
  - Responsable: Obtener película por ID, POST, Filtrado (opcional)
---

## 📝 Descripción

API REST para la gestión completa de una base de datos de películas. Permite consultar, agregar, modificar y eliminar películas.

---

## 🚀 Instalación

1. Importar el archivo `app_peliculas.sql` en phpMyAdmin
2. Verificar que `config.php` tenga las credenciales correctas de la base de datos
3. Asegurarse de que el archivo `.htaccess` esté en la raíz del proyecto
4. Acceder a la API mediante: `http://localhost/nombreDeTuCarpeta/api/peliculas`

---

## 🔗 Endpoints

### 🎬 Películas

#### **GET** `/api/peliculas`

Obtiene todas las películas con opciones de filtrado, ordenamiento y paginación.

**Query Parameters opcionales:**

| Parámetro | Descripción | Valores válidos | Ejemplo |
|-----------|-------------|-----------------|---------|
| `orderBy` | Campo por el cual ordenar | `nombre_pelicula`, `duracion`, `genero`, `fecha_estreno`, `publico` | `orderBy=duracion` |
| `direccion` | Dirección del ordenamiento | `ASC`, `DESC` | `direccion=DESC` |
| `filtro` | Campo por el cual filtrar | `nombre_pelicula`, `duracion`, `genero`, `descripcion`, `publico`, `fecha_estreno` | `filtro=genero` |
| `valor` | Valor a filtrar | Cualquier texto o número | `valor=Acción` |
| `pagina` | Número de página | Número entero positivo | `pagina=2` |
| `limite` | Cantidad de resultados por página | Número entero positivo | `limite=5` |

**Ejemplos de uso:**
```http
# Obtener todas las películas
GET /api/peliculas

# Ordenar por duración descendente
GET /api/peliculas?orderBy=duracion&direccion=DESC

# Filtrar películas por género "Acción"
GET /api/peliculas?filtro=genero&valor=Acción

# Filtrar películas con duración menor o igual a 120 minutos
GET /api/peliculas?filtro=duracion&valor=120

# Paginación: página 2, mostrando 3 películas por página
GET /api/peliculas?pagina=2&limite=3

# Combinación: filtrar por género "Drama" y ordenar por fecha de estreno
GET /api/peliculas?filtro=genero&valor=Drama&orderBy=fecha_estreno&direccion=DESC
```

**Respuesta exitosa (200 OK):**
```json
[
  {
    "id_pelicula": 1,
    "nombre_pelicula": "El Padrino",
    "duracion": 175,
    "genero": "Drama",
    "descripcion": "La historia de la familia Corleone",
    "fecha_estreno": "1972-03-24",
    "publico": "Mayores de 16",
    "img": "https://ejemplo.com/padrino.jpg"
  }
]
```

---

#### **GET** `/api/peliculas/:id`

Obtiene una película específica por su ID.

**Ejemplo:**
```http
GET /api/peliculas/1
```

**Respuesta exitosa (200 OK):**
```json
{
  "id_pelicula": 1,
  "nombre_pelicula": "El Padrino",
  "duracion": 175,
  "genero": "Drama",
  "descripcion": "La historia de la familia Corleone",
  "fecha_estreno": "1972-03-24",
  "publico": "Mayores de 16",
  "img": "https://ejemplo.com/padrino.jpg"
}
```

**Respuesta de error (404 Not Found):**
```json
"La película con el id=999 no existe"
```

---

#### **POST** `/api/peliculas` 🔒

Crea una nueva película. **Requiere autenticación** (Bearer Token).

**Headers requeridos:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "nombre_pelicula": "Matrix",
  "duracion": 136,
  "genero": "Ciencia Ficción",
  "descripcion": "Un hacker descubre la verdad sobre la realidad",
  "fecha_estreno": "1999-03-31",
  "publico": "Mayores de 13",
  "img": "https://ejemplo.com/matrix.jpg"
}
```

**Respuesta exitosa (201 Created):**
```json
{
  "id_pelicula": 6,
  "nombre_pelicula": "Matrix",
  "duracion": 136,
  "genero": "Ciencia Ficción",
  "descripcion": "Un hacker descubre la verdad sobre la realidad",
  "fecha_estreno": "1999-03-31",
  "publico": "Mayores de 13",
  "img": "https://ejemplo.com/matrix.jpg"
}
```

**Respuestas de error:**

- **400 Bad Request:** `"Faltan completar datos"`
- **401 Unauthorized:** `"No autorizado"`

---

#### **PUT** `/api/peliculas/:id` 🔒

Modifica una película existente. **Requiere autenticación** (Bearer Token).

**Headers requeridos:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Ejemplo:**
```http
PUT /api/peliculas/1
```

**Body (JSON):**
```json
{
  "nombre_pelicula": "El Padrino: Edición Especial",
  "duracion": 180,
  "genero": "Drama",
  "descripcion": "La historia de la familia Corleone - Versión extendida",
  "fecha_estreno": "1972-03-24",
  "publico": "Mayores de 16",
  "img": "https://ejemplo.com/padrino-special.jpg"
}
```

**Respuesta exitosa (200 OK):**
```json
{
  "id_pelicula": 1,
  "nombre_pelicula": "El Padrino: Edición Especial",
  "duracion": 180,
  "genero": "Drama",
  "descripcion": "La historia de la familia Corleone - Versión extendida",
  "fecha_estreno": "1972-03-24",
  "publico": "Mayores de 16",
  "img": "https://ejemplo.com/padrino-special.jpg"
}
```

**Respuestas de error:**

- **400 Bad Request:** `"Faltan completar datos"`
- **401 Unauthorized:** `"No autorizado"`
- **404 Not Found:** `"La película con el id=999 no existe"`

---

#### **DELETE** `/api/peliculas/:id` 🔒

Elimina una película. **Requiere autenticación** (Bearer Token).

**Headers requeridos:**
```
Authorization: Bearer {token}
```

**Ejemplo:**
```http
DELETE /api/peliculas/1
```

**Respuesta exitosa (200 OK):**
```json
"La película con el id=1 se eliminó con éxito"
```

**Respuestas de error:**

- **401 Unauthorized:** `"No autorizado"`
- **404 Not Found:** `"La película con el id=999 no existe"`

---

### 🔐 Autenticación

#### **GET** `/api/usuarios/token`

Obtiene un token JWT para autenticarse en los endpoints protegidos.

**Headers requeridos:**
```
Authorization: Basic {base64(usuario:contraseña)}
```

**Credenciales de prueba:**

- **Usuario:** `webadmin`
- **Contraseña:** `admin`

**Cómo generar el header en Base64:**

En la consola del navegador o en Node.js:
```javascript
btoa('webadmin:admin') // Resultado: d2ViYWRtaW46YWRtaW4=
```

**Ejemplo de header:**
```
Authorization: Basic d2ViYWRtaW46YWRtaW4=
```

**Respuesta exitosa (200 OK):**
```json
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoid2ViYWRtaW4iLCJyb2xlIjoiYWRtaW4iLCJpYXQiOjE3MzE0NTA2MDAsImV4cCI6MTczMTQ1MTIwMCwiU2FsdWRvIjoiSG9sYSJ9.8x2L_9QWvKJ3fH4nM7pR5tY6uZ1wS3dC8aB2eF4gH6k"
```

**Uso del token:**

Una vez obtenido el token, usarlo en los endpoints protegidos:
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
```

**Respuesta de error (400 Bad Request):**
```json
"Error en los datos ingresados"
```

---

## ✅ Requerimientos Cumplidos

### Obligatorios:
- ✅ **API RESTful**
- ✅ **GET colección completa** (`/api/peliculas`)
- ✅ **Ordenamiento** por al menos un campo con dirección ASC/DESC
- ✅ **GET por ID** (`/api/pelicula/:id`)
- ✅ **POST** (`/api/pelicula`)
- ✅ **PUT** (`/api/peliculas/:id`)
- ✅ **Códigos HTTP**: 200, 201, 400, 404, 401, 500

### Opcionales:
- ✅ **Paginación** (query params `pagina` y `limite`)
- ✅ **Filtrado** por campos (query params `filtro` y `valor`)
- ✅ **Ordenamiento por cualquier campo** (query param `orderBy`)
- ✅ **Autenticación con Token JWT** (Bearer Token)

---

## 🗄️ Estructura de la Base de Datos

### Tabla `pelicula`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id_pelicula` | INT (PK) | ID único de la película |
| `nombre_pelicula` | VARCHAR(200) | Nombre de la película |
| `duracion` | INT | Duración en minutos |
| `genero` | VARCHAR(200) | Género de la película |
| `descripcion` | VARCHAR(300) | Descripción breve |
| `fecha_estreno` | DATE | Fecha de estreno |
| `publico` | VARCHAR(300) | Clasificación por edades |
| `img` | VARCHAR(500) | URL de la imagen |

---

## 📂 Estructura del Proyecto
```
peliculasApi/
├── app/
│   ├── controllers/
│   │   ├── pelicula.controller.php
│   │   └── user.api.controller.php
│   ├── models/
│   │   ├── pelicula.model.php
│   │   └── user.model.php
│   ├── views/
│   │   └── json.view.php
│   └── middlewares/
│       └── jwt.auth.middleware.php
├── libs/
│   ├── jwt.php
│   ├── request.php
│   ├── response.php
│   └── router.php
├── .htaccess
├── config.php
├── router.php
├── app_peliculas.sql
└── README.md
```

---

## 📌 Notas Importantes

- El token JWT expira en **10 minutos** (600 segundos)
- Todos los endpoints que modifican datos (POST, PUT, DELETE) requieren autenticación
- La paginación comienza desde la página 1
- El filtro por duración muestra películas con duración **menor o igual** al valor especificado
- Los demás filtros usan búsqueda parcial (LIKE)
- Formato de fecha: `YYYY-MM-DD` (ej: `2010-07-16`)

---

## 🔗 Repositorio

URL del repositorio: [(https://github.com/JulianCuello/appPeliculasApi.git)]

---

**Fecha de entrega:** Viernes 21 de Noviembre de 2025