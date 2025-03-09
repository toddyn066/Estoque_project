<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    // Usuário não está logado, redirecionar para a página de login
    header('Location: ../index.php');
    exit();
}


include_once './conexao.php';

if ($_POST) {
    $produtoId = $_POST['produtos-add'];
    $quantidadeA = $_POST['quantidade-add'];
    $validadeA = $_POST['data_validade-add'];

    $sql = $conexao->prepare("SELECT est_id, pro_id, est_quantidade, est_data_validade FROM estoque_tbl WHERE  pro_id = '$produtoId' AND est_data_validade = '$validadeA';");

    $sql->execute();

    if ($sql->rowCount() > 0) {
        $resultado = $sql->fetch(PDO::FETCH_OBJ);
        $quantidade = $resultado->est_quantidade;
        $id = $resultado->est_id;

        $atualizacao = $quantidade + $quantidadeA;

        $sqlU = $conexao->prepare("UPDATE estoque_tbl SET est_quantidade = $atualizacao WHERE est_id = $id;");
        if ($sqlU->execute()) {
            header("location: ../view/index.php");
        } else {
            echo "Erro ao atualizar estoque";
        }
    } else {

        $stmt = $conexao->prepare("INSERT INTO estoque_tbl (pro_id, est_quantidade, est_data_validade) VALUES ($produtoId, $quantidadeA, '$validadeA')");

        if ($stmt->execute()) {
            header("location: ../view/index.php");
        } else {
            echo "Erro ao cadastrar produto";
        }
    }
}
?>