<?php
require_once './app/models/pelicula.model.php';
require_once './app/views/json.view.php';

class PeliculaController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new PeliculaModel();
        $this->view = new JSONView();
    }

    public function getPeliculas($req, $res)
    {
        $orderBy = false;
        $direccion = 'ASC';
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
            if (isset($req->query->direccion)) {
                $direccion = $req->query->direccion;
            }
        }

        $pagina = false;
        $limite = false;
        if (isset($req->query->pagina) && is_numeric($req->query->pagina) && 
            isset($req->query->limite) && is_numeric($req->query->limite)) {
            $pagina = $req->query->pagina;
            $limite = $req->query->limite;
        }

        $filtro = false;
        $valor = false;
        if (isset($req->query->filtro) && isset($req->query->valor)) {
            $filtro = $req->query->filtro;
            $valor = $req->query->valor;
        }

        try {
            $peliculas = $this->model->getPeliculas($orderBy, $direccion, $pagina, $limite, $filtro, $valor);
            return $this->view->response($peliculas, 200);
        } catch (Exception $e) {
            return $this->view->response(['error' => $e->getMessage()], 400);
        }
    }

    public function getPelicula($req, $res)
    {
        $id = $req->params->id;
        $pelicula = $this->model->getPelicula($id);
        
        if (!$pelicula) {
            return $this->view->response("La película con el id=$id no existe", 404);
        }
        
        return $this->view->response($pelicula, 200);
    }

    public function createPelicula($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        if (empty($req->body->nombre_pelicula) || 
            empty($req->body->duracion) || 
            empty($req->body->genero) || 
            empty($req->body->descripcion) || 
            empty($req->body->fecha_estreno) || 
            empty($req->body->publico) || 
            empty($req->body->img)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $nombre = $req->body->nombre_pelicula;
        $duracion = $req->body->duracion;
        $genero = $req->body->genero;
        $descripcion = $req->body->descripcion;
        $fecha = $req->body->fecha_estreno;
        $publico = $req->body->publico;
        $img = $req->body->img;

        try {
            $id = $this->model->insertarPelicula($nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img);
            
            if (!$id) {
                return $this->view->response("Error al insertar película", 500);
            }

            $pelicula = $this->model->getPelicula($id);
            return $this->view->response($pelicula, 201);
        } catch (Exception $e) {
            return $this->view->response(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePelicula($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = $req->params->id;
        $pelicula = $this->model->getPelicula($id);

        if (!$pelicula) {
            return $this->view->response("La película con el id=$id no existe", 404);
        }

        if (empty($req->body->nombre_pelicula) || 
            empty($req->body->duracion) || 
            empty($req->body->genero) || 
            empty($req->body->descripcion) || 
            empty($req->body->fecha_estreno) || 
            empty($req->body->publico) || 
            empty($req->body->img)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $nombre = $req->body->nombre_pelicula;
        $duracion = $req->body->duracion;
        $genero = $req->body->genero;
        $descripcion = $req->body->descripcion;
        $fecha = $req->body->fecha_estreno;
        $publico = $req->body->publico;
        $img = $req->body->img;

        try {
            $this->model->modificarPelicula($id, $nombre, $duracion, $genero, $descripcion, $fecha, $publico, $img);
            $pelicula = $this->model->getPelicula($id);
            return $this->view->response($pelicula, 200);
        } catch (Exception $e) {
            return $this->view->response(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePelicula($req, $res)
    {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }

        $id = $req->params->id;
        $pelicula = $this->model->getPelicula($id);
        
        if (!$pelicula) {
            return $this->view->response("La película con el id=$id no existe", 404);
        }

        try {
            $this->model->eliminarPelicula($id);
            return $this->view->response("La película con el id=$id se eliminó con éxito", 200);
        } catch (Exception $e) {
            return $this->view->response(['error' => $e->getMessage()], 500);
        }
    }
}