# Tercera entrega WEB2.

---

## Integrantes:

- Cuello Julian Dario

Hago la columna de juguetes ya que la otra era la que le correspondia a mi compañera (decidio irse a otro proyecto porque no teniamos los tiempos para realizar el trabajo compatibles)


---

## Descripción

Desarrollé una API para poder ver y realizar CRUD de una jugueteria.
Es decir:es una API REST que permite la consulta, modificación, eliminación e inserción de juguetes

---

### URL de Ejemplo

`jugueteriaApi/api/toys`

---

## Endpoints

### Productos

- **GET** `jugueteriaApi/api/toys`  
  muestra los juguetes disponibles en la base de datos, permitiendo opcionalmente aplicar filtrado y ordenamiento a los resultados.

  - **Descripción**:  
    Esta endpoint permite a los usuarios recuperar una lista de juguetes disponibles, con opciones para paginar, filtrar y ordenar los resultados por diferentes campos.

  - **Query Params**:

    - **Ordenamiento**:

      - `orderBy`: Campo por el que se desea ordenar los resultados. Los campos válidos pueden incluir:

        - `Nombre`: Ordena los juguetes por nombre.
          ```http
          GET jugueteriaApi/api/toys?orderBy=nombre
          ```
        - `Precio`: Ordena los juguetes por precio.
          ```http
          GET jugueteriaApi/api/toys?orderBy=Precio
          ```
        - `Marca`: Ordena los juguetes por material.
          ```http
          GET jugueteriaApi/api/toys?orderBy=Material
          ```
          - `codigo`: Ordena los juguetes por codigo.
          ```http
          GET jugueteriaApi/api/toys?orderBy=codigo
          ```

      - `direccion`: Dirección de orden para el campo especificado en `orderBy`. Puede ser:
        - `ASC`: Orden ascendente (por defecto).
        - `DESC`: Orden descendente.

      **Ejemplo de Ordenamiento**:  
      Para obtener todos los juguetes ordenados por precio en orden descendente:

      ```http
      GET jugueteriaApi/api/toys?orderBy=Precio&direccion=DESC
      ```

    - **Filtrado**:

      - `filtro`: Campo por el que se desea filtrar los resultados. Los campos válidos pueden incluir:

        - `Nombre`: Filtra los juguetes por el destino de inicio.
        - `Precio`: Filtra los juguetes por precio y muestra los menores al valor pasado.
        - `Material`: Filtra los juguetes material.
        - `Codigo`: Filtra los juguetes por codigo.

      - `valor`: Valor que se utilizará para el filtrado. Debe ser el valor específico que se comparará con el campo filtrado.

      **Ejemplo de Filtrado**:  
      Para obtener todos los juguetes que contengan en el campo 'nombre' un texto 'pelota':

      ```http
      GET jugueteriaApi/api/toys?filtro=Nombre&valor=pelota
      ```

      **Paginacion**

      - `pagina`: Numero de pagina a mostrar.
      - `limite`: Cantidad de productos a mostrar.

      **Ejemplo de paginado**:  
      Para obtener todos los productos de la 'pagina' 2 que muestre 3 por pagina (´limite´):

      ```http
      GET jugueteriaApi/api/toys?pagina=2&limite=3
      ```

---

- **GET** `jugueteriaApi/api/toy/:ID`  
  Devuelve el juguete correspondiente al `ID` solicitado.

---

- **POST** `jugueteriaApi/api/toy`  
  Inserta un nuevo juguete con la información proporcionada en el cuerpo de la solicitud (en formato JSON).

  - **Campos requeridos**:

    - `nombreProducto`: Nombre del juguete.
    - `precio`: Precio del producto
    - `material`: material del juguete
    - `id_marca`: id del juguete (FK).
    - `codigo`: Codigo del juguete
    - `img`: Url de la imagen del producto.

    **Ejemplo de json a insertar**:

    ```json
    {
     
    "nombreProducto": "pelota handball",
    "precio": 1000,
    "material": "Plástico",
    "id_marca": 6,
    "codigo": 12345,
    "img": "https://acdn.hugojuguetes.com/stores/001/474/949/toys/sin-titulo-1101-1347hfst3tyhgeg-640-0.webp"
    }
    ```

---

- **PUT** `jugueteriaApi/api/toys/:ID`  
  Modifica el juguete correspondiente al `ID` solicitado. La información a modificar se envía en el cuerpo de la solicitud (en formato JSON).

  - **Campos modificables**:
    - `nombreProducto`
    - `precio`
    - `material`
    - `id_marca`
    - `codigo`
    - `img`

---

- **DELETE** `jugueteriaApi/api/toys/:ID`  
  Elimina el producto correspondiente al `ID` solicitado.

---

### 🔐 Autenticación

Para acceder a recursos protegidos, los usuarios deben autenticarse utilizando un **token**.

- **POST** `/usuarios/token`  
  Este endpoint permite a los usuarios obtener un token JWT. Para utilizarlo, se deben enviar las credenciales en el encabezado de la solicitud en formato Base64 (usuario:contraseña).

  - **iniciar sesión**:

    - **Nombre de usuario**: `webadmin`
    - **Contraseña**: `admin`

  - **Respuesta**:  
    Si las credenciales son válidas, se devuelve un token JWT que puede ser utilizado para autenticar futuras solicitudes a la API.

---
