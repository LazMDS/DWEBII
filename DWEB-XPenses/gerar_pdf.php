<?php
session_start(); 

require_once('Vendor/TCPDF-main/tcpdf.php'); 

$host = "localhost";
$dbname = "xpenses_offc_15549";
$usuario = "root";
$senha = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

if (isset($_SESSION['user_id'])) {
    $id_User = $_SESSION['user_id'];;
} else {
    die("Erro: Usuário não está logado.");
}

$sqlUser = "SELECT name, email FROM user WHERE id_User = :id_User";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bindParam(":id_User", $id_User, PDO::PARAM_INT);
$stmtUser->execute();
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

$sqlDespesas = "SELECT id_Expense, description, category_id, amount, date FROM expense WHERE user_id = :id_User";
$stmtDespesas = $conn->prepare($sqlDespesas);
$stmtDespesas->bindParam(":id_User", $id_User, PDO::PARAM_INT);
$stmtDespesas->execute();
$despesas = $stmtDespesas->fetchAll(PDO::FETCH_ASSOC);

$sqlLimites = "SELECT id_Limit, month, amount, category_id FROM limits WHERE user_id = :id_User";
$stmtLimites = $conn->prepare($sqlLimites);
$stmtLimites->bindParam(":id_User", $id_User, PDO::PARAM_INT);
$stmtLimites->execute();
$limites = $stmtLimites->fetchAll(PDO::FETCH_ASSOC);

if ($stmtUser->rowCount() > 0) {

    // Criar novo PDF
    $pdf = new TCPDF();
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    $html = "
    <h1 style='text-align: center;'>Relatório do Usuário</h1>
    <div style='margin-bottom: 20px;'>
        <p><strong>Nome:</strong> {$usuario['name']}</p>
        <p><strong>Email:</strong> {$usuario['email']}</p>
    </div>
    <hr>
    
    <h2 style='margin-top: 20px;'>Despesas</h2>
    
    <!-- Tabela de Despesas -->
    <table border='1' cellpadding='5' style='width: 100%; margin-bottom: 20px;'>
        <thead>
            <tr>
                <th style='text-align: center;'>ID</th>
                <th style='text-align: center;'>Descrição</th>
                <th style='text-align: center;'>ID da Categoria</th>
                <th style='text-align: center;'>Valor</th>
                <th style='text-align: center;'>Data</th>
            </tr>
        </thead>
        <tbody>";

foreach ($despesas as $despesa) {
    $html .= "
        <tr>
            <td style='text-align: center;'>{$despesa['id_Expense']}</td>
            <td>{$despesa['description']}</td>
            <td style='text-align: center;'>{$despesa['category_id']}</td>
            <td style='text-align: right;'>R$ " . number_format($despesa['amount'], 2, ',', '.') . "</td>
            <td style='text-align: center;'>{$despesa['date']}</td>
        </tr>";
}

$html .= "
        </tbody>
    </table>
    
    
    <hr style='border-top: 2px solid #000; margin: 20px 0;'> 

    <h2 style='margin-top: 20px;'>Limites</h2>

    <!-- Tabela de Limites -->
    <table border='1' cellpadding='5' style='width: 100%;'>
        <thead>
            <tr>
                <th style='text-align: center;'>ID</th>
                <th style='text-align: center;'>Mês</th>
                <th style='text-align: center;'>Valor</th>
                <th style='text-align: center;'>ID da Categoria</th>
            </tr>
        </thead>
        <tbody>";

foreach ($limites as $limit) {
    $html .= "
        <tr>
            <td style='text-align: center;'>{$limit['id_Limit']}</td>
            <td style='text-align: center;'>{$limit['month']}</td>
            <td style='text-align: right;'>R$ " . number_format($limit['amount'], 2, ',', '.') . "</td>
            <td style='text-align: center;'>{$limit['category_id']}</td>
        </tr>";
}

$html .= "
        </tbody>
    </table>";

$pdf->writeHTML($html);
$pdf->Output("usuario_{$id_User}.pdf", "D");


} else {
    echo "Usuário não encontrado!";
}

?>