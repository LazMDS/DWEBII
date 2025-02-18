<?php
    session_start();
    require_once '../database.php';
    require_once '../Model/User.php';


    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'Usuário não está logado.']);
        exit;
    }

    // Verifica se a sessão já está iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $action = $_GET['action'] ?? '';

    $userData = $user->getUserById($_SESSION['user_id']);
    

    // Cadastro de usuário
    if ($action == 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm-password'] ?? '';
        
        if ($password !== $confirmPassword) {
            echo "<script>alert('As senhas não correspondem!');window.history.back();</script>";
            exit;
        }

        if ($user->register($name, $email, $password)) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../Views/Conectese.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário!'); window.history.back();</script>";
        }
    } 
    // Login de usuário
    elseif ($action == 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $loggedUser = $user->login($email, $password);
        
        if ($loggedUser) {
            $_SESSION['user_id'] = $loggedUser['id_User'];
            $_SESSION['user_name'] = $loggedUser['name'];
            header('Location: ../Views/menuInicial.php');
            exit;
        } else {
            echo "<script>alert('Email ou senha inválidos!'); window.history.back();</script>";
        }
    } 
    // Buscar dados do usuário logado
    elseif ($action == 'getUser') {
        // Certifica-se de que a resposta será JSON
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Usuário não está logado.']);
            exit;
        }

        $userId = $_SESSION['user_id'];
        $userData = $user->getUserById($userId);

        if ($userData) {
            echo json_encode($userData);
        } else {
            echo json_encode(['error' => 'Usuário não encontrado.']);
        }
        exit;
    }

    elseif ($action == 'uploadProfilePicture' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
        if (!isset($_FILES['profile_picture'])) {
            echo json_encode(['error' => 'Nenhuma imagem enviada.']);
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $targetDir = "../uploads/";
    
        // Cria a pasta uploads se não existir
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        // Define o nome do arquivo (exemplo: profile5.png)
        $fileName = "profile" . $userId . ".png";
        $targetFilePath = $targetDir . $fileName;
    
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
            $user = new User($db);
            if ($user->updateProfilePicture($userId, $fileName)) {
                echo json_encode(['profile_picture' => $fileName]);
            } else {
                echo json_encode(['error' => 'Erro ao atualizar banco de dados.']);
            }
        } else {
            echo json_encode(['error' => 'Erro ao fazer upload da imagem.']);
        }
        exit;
    }
    elseif ($action == 'updatePassword' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');

        try {
                // Limpa qualquer saída anterior que possa quebrar o JSON
            ob_clean();

            $input = json_decode(file_get_contents("php://input"), true);
    
            if (!$input) {
                echo json_encode(['error' => 'Dados inválidos recebidos.']);
                exit;
            }
    
            $senhaAtual = $input['senhaAtual'] ?? '';
            $novaSenha = $input['novaSenha'] ?? '';
            $userId = $_SESSION['user_id'] ?? null;
    
            if (!$userId) {
                echo json_encode(['error' => 'Usuário não autenticado.']);
                exit;
            }
    
            if (!$senhaAtual || !$novaSenha) {
                echo json_encode(['error' => 'Preencha todos os campos.']);
                exit;
            }
    
            $user = new User($db);
            $userData = $user->getPass($userId);
    
            if (!$userData || !password_verify($senhaAtual, $userData['password'])) {
                echo json_encode(['error' => 'Senha atual incorreta.']);
                exit;
            }
    
            if ($user->updatePassword($userId, $novaSenha)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Erro ao atualizar a senha.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro inesperado: ' . $e->getMessage()]);
        }
    
        exit;
    }
    elseif ($action == 'updateUserData' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
    
        try {
            ob_clean();
    
            $input = json_decode(file_get_contents("php://input"), true);
            if (!$input) {
                echo json_encode(['error' => 'Dados inválidos recebidos.']);
                exit;
            }
    
            $field = $input['field'] ?? '';
            $value = $input['value'] ?? '';
            $userId = $_SESSION['user_id'] ?? null;
    
            if (!$userId) {
                echo json_encode(['error' => 'Usuário não autenticado.']);
                exit;
            }
    
            if (!$field || !$value) {
                echo json_encode(['error' => 'Campo inválido.']);
                exit;
            }
    
            // Mapeamento de campo válido
            $allowedFields = ['name', 'email'];
            if (!in_array($field, $allowedFields)) {
                echo json_encode(['error' => 'Campo inválido para atualização.']);
                exit;
            }
    
            $user = new User($db);
            if ($user->updateUserData($userId, $field, $value)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Erro ao atualizar os dados.']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro inesperado: ' . $e->getMessage()]);
        }
    
        exit;
    }

    exit;
    
?>