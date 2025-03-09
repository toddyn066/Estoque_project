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
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Vendas</title>
</head>

<body>
    <header>
        <nav class="content container">
            <figure>
                <a href="./index.php">
                    <img src="../img/home.png" alt="Logo Home">
                </a>
            </figure>
            <figure>
                <img id="logo" src="../img/villa-garden.jpeg" alt="Logo da Empresa">
            </figure>
            <figure>
                <a href="../view/produtos.php">
                    <img src="../img/produtos.png" alt="Logo Produtos">
                </a>
            </figure>
        </nav>
        <div class="logout">
            <a href="../database/logout.php">
                <img src="../img/logout.png" alt="">
            </a>
        </div>
    </header>
    <main class="content" style="overflow: hidden;">
        <div class="container">

            <form action="" method="post" class="box">
                <section>
                    <h2>Quantidade no Estoque</h2>
                    <b>
                        <p><?php echo $quantidade ?></p>
                    </b>
                </section>
                <section>
                    <h2>Quantidade Vendida</h2>
                    <input type="text" name="vendas" placeholder="Vendas" required>
                </section>
                <section>
                    <h2>Atualizar Estoque</h2>
                    <button type="submit">Atualizar</button>
                </section>
            </form>

            <table cellspacing="8">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="qttde">Quantidade</th>
                        <th>Validade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo "<tr><td>$nome</td><td>$quantidade</td><td>$validade</td></tr>"; ?>
                </tbody>
            </table>

            <hr style="color: transparent; width: 54rem; margin-top: 5rem;">

            <?php
            if ($_POST) {
                echo '<table style="margin-top: 2rem;" cellspacing="8">
                        <thead>
                            <tr>
                                <th colspan="3">Estoque Atualizado</th>
                            </tr>
                            <tr>
                                <th>Produto</th>
                                <th class = "qttde">Quantidade</th>
                                <th>Validade</th>
                            </tr>
                        </thead>
                        <tbody>';

                $vendas = $_POST['vendas'];
                $atualizacao = $quantidade - $vendas;
                include_once '../database/conexao.php';

                $stmt = $conexao->prepare("UPDATE estoque_tbl SET est_quantidade = $atualizacao WHERE est_id = $id");
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo "<tr><td>$nome</td><td>$atualizacao</td><td>$validade</td></tr>";
                } else {
                    echo "<tr><td>$nome</td><td colspan ='2' >Erro ao atualizar estoque</td></tr>";
                }
            }
            ?>
            </tbody>
            </table>
        </div>
    </main>
    <footer>
        <div class="content">
            <h4>&copy; 2024 - Todos os direitos reservados</h4>
            <h4>Sistema feito por <b><a target="_blank"
                        href="https://www.linkedin.com/in/joão-pedro-marcondes-a15743290">João Pedro Marcondes</a></b>
            </h4>
        </div>
    </footer>
    <script>
        const ths = document.querySelectorAll('.qttde')
        ths.forEach(th => {

            if (window.innerWidth <= 480) {
                th.textContent = 'Qttde'
            }

        })
    </script>
    <script src="../js/script.js"></script>
</body>

</html>