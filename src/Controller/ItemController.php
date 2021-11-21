<?php

namespace App\Controller;

use App\Model\ItemManager;

class ItemController extends AbstractController
{
    /**
     * List items
     */
    public function browse(): string
    {
        $itemManager = new ItemManager();
        $todos = $itemManager->selectAll('name');

        return $this->twig->render('todo/browse.html.twig', ['todos' => $todos]);
    }


    /**
     * Show informations for a specific item
     */
    public function show(int $id): string
    {
        $itemManager = new ItemManager();
        $todo = $itemManager->selectOneById($id);

        return $this->twig->render('todo/show.html.twig', ['todo' => $todo]);
    }


    /**
     * Edit a specific item
     */
    public function edit(int $id): string
    {
        $itemManager = new ItemManager();
        $todo = $itemManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $todo = array_map('trim', $_POST);

            //var_dump($_GET);
            //die();

            $itemManager->update($todo);
            header('Location: /todo/show?id=' . $id);
        }

        return $this->twig->render('todo/edit.html.twig', [
            'todo' => $todo,
        ]);
    }


    /**
     * Add a new item
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $todo = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $itemManager = new ItemManager();
            $id = $itemManager->insert($todo);
            header('location: /todo/browse');
        }

        return $this->twig->render('todo/add.html.twig');
        
    }


    /**
     * Delete a specific item
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $itemManager = new ItemManager();
            $itemManager->delete((int)$id);
            header('Location:/todo/browse');
        }
    }
}
