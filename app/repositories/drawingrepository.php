<?php

namespace Repositories;
use Models\Drawing;
use PDO;
use PDOException;
use Repositories\Repository;

class DrawingRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT * FROM drawing ORDER BY drawing.id DESC";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $drawings = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $drawing = $this->rowToDrawing($row);
                $drawings[] = $drawing;
            }

            return $drawings;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $query = "SELECT * FROM drawing WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $drawing = $this->rowToDrawing($row);

            return $drawing;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getByUser($username){
        try {
            $query = "SELECT * FROM drawing WHERE username = :username ORDER BY drawing.id DESC";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $drawings = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $drawing = $this->rowToDrawing($row);
                $drawings[] = $drawing;
            }

            return $drawings;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function rowToDrawing($row) {
        $drawing = new Drawing();
        $drawing->id = $row['id'];
        $drawing->title = $row['title'];
        $drawing->image = $row['image'];
        $drawing->username = $row['username'];
        return $drawing;
    }

    function create($drawing)
    {
        try {
            $query = "INSERT INTO drawing (title, image, username) VALUES (:title, :image, :username)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':title', $drawing->title);
            $stmt->bindParam(':image', $drawing->image);
            $stmt->bindParam(':username', $drawing->username);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function update($drawing, $id)
    {
        try {
            $query = "UPDATE drawing SET title = :title, image = :image WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $drawing->title);
            $stmt->bindParam(':image', $drawing->image);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $query = "DELETE FROM drawing WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

}