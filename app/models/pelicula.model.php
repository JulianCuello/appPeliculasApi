<?php
require_once './config.php';

class PeliculaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8',
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Obtener todas las películas con filtros, ordenamiento y paginación
     */
    public function getPeliculas($orderBy = false, $direccion = 'ASC', $pagina = false, $limite = false, $filtro = false, $valor = false)
    {
        $sql = "SELECT * FROM pelicula";
        $params = [];

        // FILTRADO
        if ($filtro && $valor) {
            $columnasValidas = ['nombre_pelicula', 'duracion', 'genero', 'descripcion', 'publico', 'fecha_estreno'];
            
            if (!in_array($filtro, $columnasValidas)) {
                throw new Exception("Campo de filtro inválido");
            }

            // Para duración: filtrar menores o iguales
            if ($filtro === 'duracion') {
                $sql .= " WHERE duracion <= ?";
                $params[] = $valor;
            } 
            // Para otros campos: búsqueda con LIKE
            else {
                $sql .= " WHERE $filtro LIKE ?";
                $params[] = "%$valor%";
            }
        }

        // ORDENAMIENTO
        if ($orderBy) {
            $columnasValidas = ['nombre_pelicula', 'duracion', 'genero', 'fecha_estreno', 'publico', 'id_pelicula'];
            
            if (in_array($orderBy, $columnasValidas)) {
                $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';
                $sql .= " ORDER BY $orderBy $direccion";
            }
        }

        // PAGINACIÓN
        if ($pagina && $limite) {
            $offset = ($pagina - 1) * $limite;
            $sql .= " LIMIT $offset, $limite";
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Obtener una película por ID
     */
    public function getPelicula($id)
    {
        $query = $this->db->prepare("SELECT * FROM pelicula WHERE id_pelicula = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Agregar una nueva película
     */
    public function insertarPelicula($nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img)
    {
        $query = $this->db->prepare("INSERT INTO pelicula 
            (nombre_pelicula, duracion, genero, descripcion, fecha_estreno, publico, img)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        $query->execute([$nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img]);

        return $this->db->lastInsertId();
    }

    /**
     * Editar una película existente
     */
    public function modificarPelicula($id, $nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img)
    {
        $query = $this->db->prepare("UPDATE pelicula 
            SET nombre_pelicula = ?, duracion = ?, genero = ?, descripcion = ?, fecha_estreno = ?, publico = ?, img = ?
            WHERE id_pelicula = ?");
        
        $query->execute([$nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img, $id]);
        
        return $query->rowCount();
    }

    /**
     * Eliminar una película
     */
    public function eliminarPelicula($id)
    {
        $query = $this->db->prepare("DELETE FROM pelicula WHERE id_pelicula = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}