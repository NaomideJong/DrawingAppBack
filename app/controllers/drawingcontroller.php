<?php

namespace Controllers;
use Exception;
use Services\DrawingService;

class DrawingController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new DrawingService();
    }

    public function getAll()
    {
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $drawings = $this->service->getAll($offset, $limit);

        $this->respond($drawings);
    }

    public function getOne($id)
    {
        $drawing = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the drawing is not found in the DB
        if (!$drawing) {
            $this->respondWithError(404, "Drawing not found");
            return;
        }

        $this->respond($drawing);
    }

    public function create(){
        try {
            $drawing = $this->createObjectFromPostedJson("Models\\Drawing");
            $drawing->title = filter_var($drawing->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $drawing = $this->service->create($drawing);
            $this->respond($drawing);
        } catch (Exception $e) {
            // Log the error
            error_log('Error creating drawing: ' . $e->getMessage());

            // Respond with an error message
            $this->respondWithError(500, 'Failed to create drawing. Please try again later.');
        }
    }

    public function update($id)
    {
        try {
            $drawing = $this->createObjectFromPostedJson("Models\\Drawing");
            $drawing->title = filter_var($drawing->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $drawing = $this->service->update($drawing, $id);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($drawing);
    }

    public function getByUser($username)
    {
        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $drawings = $this->service->getByUser($username);

        $this->respond($drawings);
    }

    public function delete($id)
    {
        try {
            $drawing = $this->service->delete($id);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($drawing);
    }
}