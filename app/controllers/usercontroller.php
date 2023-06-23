<?php

namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    private $userService;

    // initialize services
    function __construct()
    {
        $this->userService = new UserService();
    }

    public function login() {

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        if(!$postedUser->username || !$postedUser->password) {
            $this->respondWithError(400, "Invalid user data");
            return;
        }

        // get user from db
        $user = $this->userService->checkUsernamePassword($postedUser->username, $postedUser->password);

        // if the method returned false, the username and/or password were incorrect
        if(!$user) {
            $this->respondWithError(401, "Invalid login");
            return;
        }

        // generate jwt
        $tokenResponse = $this->userService->generateJwt($user);

        $this->respond($tokenResponse);    
    }

    public function register(){
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $user = $this->userService->insert($user);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($user);
    }
}
