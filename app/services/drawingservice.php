<?php

namespace Services;
use Repositories\DrawingRepository;

class DrawingService
{
    private $repository;

    function __construct()
    {
        $this->repository = new DrawingRepository();
    }

    public function getAll($offset = NULL, $limit = NULL)
    {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id)
    {
        return $this->repository->getOne($id);
    }

    public function create($drawing)
    {
        return $this->repository->create($drawing);
    }

    public function update($drawing, $id)
    {
        return $this->repository->update($drawing, $id);
    }

    public function delete($drawing)
    {
        return $this->repository->delete($drawing);
    }

    public function getByUser($username)
    {
        return $this->repository->getByUser($username);
    }

}