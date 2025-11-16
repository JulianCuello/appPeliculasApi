<?php
require_once './libs/jwt.php';

class JWTAuthMiddleware
{
    public function run($request, $response)
    {
        // Obtener el header de autorización
        $auth_header = null;
        
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $auth_header = $headers['Authorization'];
            }
        }

        if ($auth_header) {
            // Verificar si es Bearer Token (JWT)
            if (strpos($auth_header, 'Bearer ') === 0) {
                $auth_header_parts = explode(' ', $auth_header);
                
                if (count($auth_header_parts) == 2 && $auth_header_parts[0] == 'Bearer') {
                    $jwt = $auth_header_parts[1];
                    
                    // Eliminar comillas si existen
                    $jwt = trim($jwt, '"\'');
                    
                    $payload = validateJWT($jwt);
                    
                    if ($payload) {
                        $response->user = $payload;
                    }
                }
            }
        }
    }
}