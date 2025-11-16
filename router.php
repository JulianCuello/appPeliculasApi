<?php
require_once './libs/router.php';
require_once './app/controllers/pelicula.controller.php';
require_once './app/controllers/user.api.controller.php';
require_once './app/middlewares/jwt.auth.middleware.php';

$router = new Router();

// Middleware de autenticación JWT
$router->addMiddleware(new JWTAuthMiddleware());

// ===== ENDPOINTS DE PELÍCULAS =====

// GET /api/peliculas - Listar todas las películas (con filtros, orden, paginación)
$router->addRoute('api/peliculas', 'GET', 'PeliculaController', 'getPeliculas');

// GET /api/pelicula/:id - Obtener una película por ID
$router->addRoute('api/peliculas/:id', 'GET', 'PeliculaController', 'getPelicula');

// POST /api/pelicula - Crear una nueva película (requiere autenticación)
$router->addRoute('api/peliculas', 'POST', 'PeliculaController', 'createPelicula');

// PUT /api/peliculas/:id - Modificar una película (requiere autenticación)
$router->addRoute('api/peliculas/:id', 'PUT', 'PeliculaController', 'updatePelicula');

// DELETE /api/peliculas/:id - Eliminar una película (requiere autenticación)
$router->addRoute('api/peliculas/:id', 'DELETE', 'PeliculaController', 'deletePelicula');

// ===== ENDPOINT DE AUTENTICACIÓN =====

// GET /api/usuarios/token - Obtener token JWT
$router->addRoute('api/usuarios/token', 'GET', 'UserApiController', 'getToken');

// Ruta por defecto para 404
$router->setDefaultRoute('PeliculaController', 'getPeliculas');

// Ejecutar el router
$router->route($_GET['action'] ?? 'api/peliculas', $_SERVER['REQUEST_METHOD']);
