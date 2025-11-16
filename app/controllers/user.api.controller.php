<?php

require_once './app/models/user.model.php';
require_once './app/views/json.view.php';
require_once './libs/jwt.php';

class UserApiController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new JSONView();
    }

   public function getToken($req, $res)
{
    // Obtener credenciales de Basic Auth
    $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
    $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;
    
    // Si no están en PHP_AUTH, intentar con apache_request_headers
    if (!$user || !$pass) {
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $auth_header = $headers['Authorization'];
                
                if (strpos($auth_header, 'Basic ') === 0) {
                    $credentials = base64_decode(substr($auth_header, 6));
                    $credentials = explode(':', $credentials);
                    
                    if (count($credentials) == 2) {
                        $user = $credentials[0];
                        $pass = $credentials[1];
                    }
                }
            }
        }
    }
    
    // Verificar que tenemos credenciales
    if (!$user || !$pass) {
        return $this->view->response("Error en los datos ingresados", 400);
    }
    
    // Obtener usuario de la base de datos
    $userDB = $this->model->getUserByEmail($user);
    
    if (!$userDB) {
        return $this->view->response("Error en los datos ingresados", 400);
    }
    
    // Verificar contraseña
    if (!password_verify($pass, $userDB->password)) {
        return $this->view->response("Error en los datos ingresados", 400);
    }
    
    // Crear token JWT
    $token = createJWT(array(
        'sub' => $userDB->id,
        'email' => $userDB->email,
        'role' => 'admin',
        'iat' => time(),
        'exp' => time() + 600
    ));
    
    return $this->view->response($token);
}
}