<?php

namespace App\Model;

class ItemManager extends AbstractManager
{
    public const TABLE = 'todo';

    /**
     * Insert new item in database
     */
    public function insert(array $todo): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `create_date`) VALUES (:name, NOW())");
        $statement->bindValue(':name', $todo['name'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
        header('location: /todo/browse');
    }

    /**
     * Update item in database
     */
    public function update(array $todo)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name WHERE `id` =:id");
        $statement->bindValue(':id', $_GET['id'], \PDO::PARAM_INT);
        $statement->bindValue(':name', $todo['name'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
