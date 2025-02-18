<!DOCTYPE html>
<html>
<head>
    <title>Teste de conexão com o banco de dados</title>
</head>
<body>
    <h1>Teste de conexão com o banco de dados</h1>
    <?php
        require_once "database.php";

        $database = new Database();
        $conn = $database->getConnection();
    
        if ($conn) {
            echo "Conexão bem-sucedida!<br>";      

            // Verificando as tabelas
            $query = "SHOW TABLES";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            echo "Tabelas no banco de dados:<br>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo implode("", $row) . "<br>";
            }
        } else {
            echo "Falha na conexão.";
        }

        //if ($conn) {
          //  echo "Conexão bem-sucedida!";
        //} e/lse {
        //    echo "Falha na conexão.";
        //}
    ?>
</body>
</html>
