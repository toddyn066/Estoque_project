<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    // Usuário não está logado, redirecionar para a página de login
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['cod'])) {
    $id = (isset($_GET["cod"]) && $_GET["cod"] != null) ? $_GET["cod"] : "";
    include '../database/conexao.php';

    try {
        $sql = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM estoque_tbl INNER JOIN produtos_tbl USING (pro_id) WHERE est_id = $id");

        if ($sql->execute()) {
            $result = $sql->fetch(PDO::FETCH_OBJ);
            $id = $result->est_id;
            $nome = $result->pro_nome;
            $quantidade = $result->est_quantidade;
            $validade = $result->est_data_validade;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }

    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Deletar</title>
</head>

<body style="height: 100vh;">
    <main class="content container" style="width: min(100% - 3rem, 120rem);">
        <div class="card">
            <article>
                <h2 style="margin-bottom: 5rem;">Deseja realmente excluir esses produtos do estoque?</h2>
                <form action="" method="post" style="display:flex; justify-content: space-evenly; flex-wrap: wrap ">
                    <button class="btn-action" type="button" onclick="voltar()">Voltar</button>
                    <button class="btn-action" type="submit">Excluir</button>
                    <input type="hidden" name="estId" value="<?php $id ?>">
                </form>
            </article>

            <section>
                <table cellspacing="8"
                    style="background-color: #eee; border-radius: 2rem; filter: drop-shadow(5px 5px 2px #bcb);">
                    <thead>
                        <tr style="border-top: none;">
                            <th>Produto</th>
                            <th class="qttde">Quantidade</th>
                            <th>Validade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo "<tr><td>$nome</td><td>$quantidade</td><td>$validade</td></tr>"; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>

<script>
    function voltar() {
        window.location.href = "./index.php";
    }

    const ths = document.querySelectorAll('.qttde')
    ths.forEach(th => {

        if (window.innerWidth <= 480) {
            th.textContent = 'Qttde'
        }

    })
</script>

<?php
if ($_POST) {
    $stmt = $conexao->prepare("DELETE FROM estoque_tbl WHERE est_id = $id");

    if ($stmt->execute()) {
        header("location: ./index.php");
    } else {
        echo "Erro ao deletar o produto do estoque.";
    }
}
?>

</html>