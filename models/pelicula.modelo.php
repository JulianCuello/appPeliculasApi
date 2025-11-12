<?php
class PeliculaModel
{
    private $db;

    public function __construct()
    {
        // Conectamos a la base de datos (ajustá los valores a tu configuración)
        $this->db = new PDO('mysql:host=localhost;dbname=peliculas_db;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Obtener todas las películas (con orden, paginación y filtro)
     */
    public function getPeliculas($orderBy = null, $direccion = 'ASC', $pagina = false, $limite = false, $filtro = null, $valor = null)
    {
        $sql = "SELECT * FROM peliculas";
        $params = [];

        // Filtro: WHERE campo LIKE '%valor%'
        if ($filtro && $valor) {
            // Evitamos inyección SQL limitando los nombres de columna válidos
            $columnasValidas = ['id_pelicula', 'nombre_pelicula', 'duracion', 'genero', 'descripcion', 'fecha_estreno', 'publico', 'img', 'id_actor'];
            if (!in_array($filtro, $columnasValidas)) {
                throw new Exception("Campo de filtro inválido");
            }

            $sql .= " WHERE $filtro LIKE ?";
            $params[] = "%$valor%";
        }

        // Orden: ORDER BY columna ASC/DESC
        if ($orderBy) {
            $columnasValidas = ['id_pelicula', 'nombre_pelicula', 'duracion', 'genero', 'fecha_estreno', 'publico'];
            if (in_array($orderBy, $columnasValidas)) {
                $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';
                $sql .= " ORDER BY $orderBy $direccion";
            }
        }

        // Paginación: LIMIT offset, cantidad
        if ($pagina && $limite) {
            $offset = ($pagina - 1) * $limite;
            $sql .= " LIMIT $offset, $limite";
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Obtener una película por su ID
     */
    public function getPeliculaById($id)
    {
        $query = $this->db->prepare("SELECT * FROM peliculas WHERE id_pelicula = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Insertar una nueva película
     */
    public function insertarPelicula($nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img, $id_actor)
    {
        $query = $this->db->prepare("INSERT INTO peliculas 
            (nombre_pelicula, duracion, genero, descripcion, fecha_estreno, publico, img, id_actor)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $query->execute([$nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img, $id_actor]);

        return $this->db->lastInsertId();
    }

    /**
     * Modificar una película existente
     */
    public function modificarPelicula($id, $nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img, $id_actor)
    {
        $query = $this->db->prepare("UPDATE peliculas 
            SET nombre_pelicula = ?, duracion = ?, genero = ?, descripcion = ?, fecha_estreno = ?, publico = ?, img = ?, id_actor = ?
            WHERE id_pelicula = ?");
        $query->execute([$nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img, $id_actor, $id]);
        return $query->rowCount(); // devuelve cuántas filas fueron modificadas
    }

    /**
     * Eliminar una película
     */
    public function eliminarPelicula($id)
    {
        $query = $this->db->prepare("DELETE FROM peliculas WHERE id_pelicula = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}
