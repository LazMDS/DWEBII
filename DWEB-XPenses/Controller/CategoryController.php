<?php
    session_start();
    require_once '../database.php';
    require_once '../Model/Category.php';

    $database = new Database();
    $db = $database->getConnection();
    $category = new Category($db);

    $action = $_GET['action'] ?? '';

    function jsonResponse($status, $message) {
        echo json_encode(["status" => $status, "message" => $message]);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $weight = $_POST['weight'] ?? '';
        $id = $_GET['id'] ?? '';
    
        if ($id) {
            // Atualiza categoria existente
            if ($category->editCategory($id, $name, $description, $weight)) {
                echo json_encode(["status" => "success", "message" => "Categoria atualizada com sucesso!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao atualizar categoria!"]);
            }
        } else {
            // Insere nova categoria
            if ($category->addCategory($name, $description, $weight)) {
                echo json_encode(["status" => "success", "message" => "Categoria adicionada com sucesso!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao adicionar categoria!"]);
            }
        }
    }    
    elseif ($action == 'delete' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Pega o ID corretamente do corpo da requisição
        $input = file_get_contents("php://input");
        parse_str($input, $data);
        $id = $data['id'] ?? '';
    
        if (!empty($id) && is_numeric($id)) {
            if ($category->deleteCategory($id)) {
                echo json_encode(["status" => "success", "message" => "Categoria excluída com sucesso!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao excluir categoria!"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID inválido!"]);
        }
    }      
    
    elseif ($action == 'get' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'] ?? '';
        $categoryData = $category->getCategory($id);
        echo json_encode($categoryData);
    }
    
    elseif ($action == 'getAll') {
        $categories = $category->getAllCategories();
        echo json_encode($categories);
    }
    else {
        jsonResponse("error", "Ação não permitida!");
    }
?>