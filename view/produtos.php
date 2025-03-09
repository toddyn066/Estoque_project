<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    // Usuário não está logado, redirecionar para a página de login
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Produtos</title>
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
    <main class="content" style="margin-bottom: 5rem;">
        <div class="container">
            <table cellspacing="8">
                <thead>
                    <tr>
                        <th>Produtos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../database/conexao.php';

                    $stmt = $conexao->prepare("SELECT * FROM produtos_tbl ORDER BY pro_nome ASC ;");
                    if ($stmt->execute()) {
                        while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>
                                    <td>{$dt->pro_nome}</td>
                                 </tr>";
                        }
                    } else {
                        echo "<tr><td>Erro ao executar a consulta</td></tr>";
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
</body>

</html>