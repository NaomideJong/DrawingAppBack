<?php
namespace Services;

use Firebase\JWT\JWT;
use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function checkUsernamePassword($username, $password) {
        return $this->repository->checkUsernamePassword($username, $password);
    }

    public function insert($user) {
        return $this->repository->insert($user);
    }
    public function generateJwt($user) {
        $secret_key = "eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTY4NzUzODQxNywiaWF0IjoxNjg3NTM4NDE3fQ.xsXPgiYupAa2bBL-seaxFPk6gPV-cUk-WXW0W1eVvhE";

        $issuer = "Drawing App Issuer";
        $audience = "Drawing App Audience";

        $issuedAt = time();
        $notbefore = $issuedAt;
        $expire = $issuedAt + 1800;

        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username
            ));

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "username" => $user->username,
                "expireAt" => $expire
            );
    }
}
