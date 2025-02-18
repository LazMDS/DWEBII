<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XPenses - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/cadastre.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
</head>
<body>
    <nav class="navbar navbar-light justify-content-end p-3">
        <img src="./assents/logo.png" alt="XPenses Logo" class="img-fluid mb-3 mx-auto">
    </nav>

    <div class="container-fluid d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="row w-100">
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                <img src="./assents/Instagram post para provedor de internet gradiente azul (1).png" alt="XPenses Logo" class="img-form">
            </div>
            <div class="col-lg-6 d-flex flex-column align-items-center">
                <div class="card shadow p-4 w-75">
                    <img src="./assents/logo.png" alt="XPenses Logo" class="img-logo mb-3 mx-auto">
                    <p class="text-center text-muted">Controle financeiro feito para estudantes, por estudantes.</p>
                    <h3 class="text-center">Cadastre-se</h3>
                    
                    <form action="../Controller/UserController.php?action=register" method="POST">
                        <div class="mb-2 input-group-sm">
                            <input type="text" class="form-control" name="name" placeholder="Nome completo" required>
                        </div>
                        <div class="mb-2 input-group-sm">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-2 input-group-sm">
                            <input type="password" class="form-control" name="password" placeholder="Senha" required>
                        </div>
                        <div class="mb-2 input-group-sm">
                            <input type="password" class="form-control" name="confirm-password" placeholder="Confirme a Senha" required>
                        </div>
                        <button type="submit" class="btn w-100">CADASTRAR-SE</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="./Conectese.php" class="text-muted">Já tem cadastro? Fazer Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3">
        <div class="container">
            <a href="#" class="text-center mx-2">Contato</a>
            <a href="#" class="text-center mx-2">Sobre nós</a>
            <a href="#" class="text-center mx-2">Ajuda</a>
            <a href="#" class="text-center mx-2">Privacidade</a>
        </div>
    </footer>
</body>
</html>
