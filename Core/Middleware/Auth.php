<?php

namespace Core\Middleware;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Core\JwtToken;

class Auth {
    public function handle() {
        if(isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            $secretKey = $_ENV["KEY"];

            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid or expired token']);
                die();
            }

            try {
                $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
                JwtToken::set($decoded);

            } catch(\Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid or expired token', 'message' => $e->getMessage()]);
                die();
            }
        }
    }
}