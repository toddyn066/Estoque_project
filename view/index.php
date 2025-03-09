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
    <title>Estoque</title>
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
                <a href="./produtos.php">
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
    <main class="content">
        <div class="container">
            <form class="search-form" id="search-form" action="index.php" method="post">

                <section style="padding: 0;">
                    <div class="search">
                        <label for="Produto">Produto</label>
                        <input id="text-input" type="search" name="Produto" placeholder="Nome do Produto"
                            autocomplete="off">
                        <div class="list"></div>
                    </div>
                </section>

                <section>
                    <label for="valor1">Quantidade entre:</label>
                    <input type="text" name="valor1" placeholder="valor 1" value="0" required>
                    <input type="text" name="valor2" placeholder="valor 2" value="1000" required>
                </section>

                <section style="flex-direction: column;">
                    <label for="validade">Ano de Validade</label>
                    <select name="validade">
                        <option selected disabled>Qualquer ano</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                    </select>
                </section>
                <section>
                    <button type="submit">Pesquisar</button>
                </section>

                <i id="add-button">
                    <label for="add" class="add">
                        <input type="checkbox" id="add">
                        <span></span>
                        <span></span>
                    </label>
                </i>
            </form>

            <form action='../database/atualizar.php' method='post' id="atualizar">
                <section>
                    <select name="produtos-add" required>
                        <option disabled selected value="">Produto</option>
                        <option value="3">Becks Long</option>
                        <option value="14">Bud long</option>
                        <option value="15">Bud Zero</option>
                        <option value="12">Colorado Appia</option>
                        <option value="13">Colorado Ribeirão</option>
                        <option value="4">GT</option>
                        <option value="1">Ice</option>
                        <option value="6">Michelob</option>
                        <option value="10">Patogônia Amber</option>
                        <option value="9">Patogonia Bohemia</option>
                        <option value="11">Patogônia Ipa</option>
                        <option value="5">Sense</option>
                        <option value="8">Spaten Long</option>
                        <option value="7">Stella Gold</option>
                        <option value="2">Stella Long</option>
                    </select>
                </section>

                <section>
                    <input type="text" name="quantidade-add" required placeholder="Quantidade">
                </section>

                <section>
                    <input id="validade" type="text" name="data_validade-add" required placeholder="AAAA/MM"
                        minlength="7" maxlength="7">
                </section>

                <section>
                    <button type="submit">Adicionar</button>
                </section>
            </form>

            <table cellspacing="8">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="qttde">Quantidade</th>
                        <th>Validade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../database/conexao.php';
                    if ($_POST) {
                        if (isset($_POST['validade']) && $_POST['Produto'] === "") {
                            $validade = $_POST['validade'];
                            $valor1 = $_POST['valor1'];
                            $valor2 = $_POST['valor2'];

                            $stmt = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM produtos_tbl INNER JOIN estoque_tbl USING (pro_id) WHERE est_quantidade BETWEEN ? AND ? AND est_data_validade = $validade ORDER BY pro_nome ASC ;");
                            $stmt->bindParam(1, $valor1);
                            $stmt->bindParam(2, $valor2);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>      
                                            <td>{$dt->pro_nome}</td>
                                            <td>{$dt->est_quantidade}</td>
                                            <td>{$dt->est_data_validade}</td>
                                            <td class='td-flex'>
                                                <section class = 'btn-container'>
                                                    <a href='../view/vendas.php?cod={$dt->est_id}'><button class='btn'>
                                                        <?xml version='1.0' ?><svg class = 'sparkle' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><g data-name='2. Coin' id='_2._Coin'><path d='M22,9h-.19A2.83,2.83,0,0,0,22,8V6a3,3,0,0,0-3-3H3A3,3,0,0,0,0,6V8a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,12v2a3,3,0,0,0,.22,1.12A3,3,0,0,0,0,18v2a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,24v2a3,3,0,0,0,3,3H22A10,10,0,0,0,22,9Zm-9.16,6H5a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H16A10,10,0,0,0,12.84,15ZM2,6A1,1,0,0,1,3,5H19a1,1,0,0,1,1,1V8a1,1,0,0,1-1,1H3A1,1,0,0,1,2,8ZM2,18a1,1,0,0,1,1-1h9.2a10.1,10.1,0,0,0,0,4H3a1,1,0,0,1-1-1Zm3,9a1,1,0,0,1-1-1V24a1,1,0,0,1,1-1h7.84A10,10,0,0,0,16,27Zm17,0a8,8,0,1,1,8-8A8,8,0,0,1,22,27Z'/><path d='M22,16h2a1,1,0,0,0,0-2H23a1,1,0,0,0-2,0v.18A3,3,0,0,0,22,20a1,1,0,0,1,0,2H20a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,22,18a1,1,0,0,1,0-2Z'/></g></svg>
                                                    </button></a>
                                                </section>
                                                <section class = 'btn-container'>
                                                    <a href='../view/deletar.php?cod={$dt->est_id}'><button class='btn delete'>
                                                        <?xml version='1.0' encoding='iso-8859-1'?><svg class = 'sparkle' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 460.775 460.775' xml:space='preserve'><path d='M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z'/></svg>
                                                    </button></a>
                                                </section>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Data de Validade não encontrado</td><tr>";
                            }

                        } elseif ($_POST['Produto'] === "" && !isset($_POST['validade'])) {
                            $valor1 = $_POST['valor1'];
                            $valor2 = $_POST['valor2'];

                            $stmt = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM produtos_tbl INNER JOIN estoque_tbl USING (pro_id) WHERE est_quantidade BETWEEN ? AND ? ORDER BY pro_nome ASC ;");
                            $stmt->bindParam(1, $valor1);
                            $stmt->bindParam(2, $valor2);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>      
                                            <td>{$dt->pro_nome}</td>
                                            <td>{$dt->est_quantidade}</td>
                                            <td>{$dt->est_data_validade}</td>
                                            <td class='td-flex'>
                                                <section class = 'btn-container'>
                                                    <a href='../view/vendas.php?cod={$dt->est_id}'><button class='btn'>
                                                        <?xml version='1.0' ?><svg class = 'sparkle' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><g data-name='2. Coin' id='_2._Coin'><path d='M22,9h-.19A2.83,2.83,0,0,0,22,8V6a3,3,0,0,0-3-3H3A3,3,0,0,0,0,6V8a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,12v2a3,3,0,0,0,.22,1.12A3,3,0,0,0,0,18v2a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,24v2a3,3,0,0,0,3,3H22A10,10,0,0,0,22,9Zm-9.16,6H5a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H16A10,10,0,0,0,12.84,15ZM2,6A1,1,0,0,1,3,5H19a1,1,0,0,1,1,1V8a1,1,0,0,1-1,1H3A1,1,0,0,1,2,8ZM2,18a1,1,0,0,1,1-1h9.2a10.1,10.1,0,0,0,0,4H3a1,1,0,0,1-1-1Zm3,9a1,1,0,0,1-1-1V24a1,1,0,0,1,1-1h7.84A10,10,0,0,0,16,27Zm17,0a8,8,0,1,1,8-8A8,8,0,0,1,22,27Z'/><path d='M22,16h2a1,1,0,0,0,0-2H23a1,1,0,0,0-2,0v.18A3,3,0,0,0,22,20a1,1,0,0,1,0,2H20a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,22,18a1,1,0,0,1,0-2Z'/></g></svg>
                                                    </button></a>
                                                </section>
                                                <section class = 'btn-container'>
                                                    <a href='../view/deletar.php?cod={$dt->est_id}'><button class='btn delete'>
                                                        <?xml version='1.0' encoding='iso-8859-1'?><svg class = 'sparkle' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 460.775 460.775' xml:space='preserve'><path d='M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z'/></svg>
                                                    </button></a>
                                                </section>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Quantidade não encontrada ou inválida</td><tr>";
                            }
                        } elseif (isset($_POST['Produto']) && !isset($_POST['validade'])) {
                            $produto = $_POST['Produto'];
                            $valor1 = $_POST['valor1'];
                            $valor2 = $_POST['valor2'];

                            $stmt = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM produtos_tbl INNER JOIN estoque_tbl USING (pro_id) WHERE pro_nome LIKE '%$produto%' AND est_quantidade BETWEEN ? AND ? ORDER BY pro_nome ASC ;");

                            $stmt->bindParam(1, $valor1);
                            $stmt->bindParam(2, $valor2);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>      
                                            <td>{$dt->pro_nome}</td>
                                            <td>{$dt->est_quantidade}</td>
                                            <td>{$dt->est_data_validade}</td>
                                            <td class='td-flex'>
                                                <section class = 'btn-container'>
                                                    <a href='../view/vendas.php?cod={$dt->est_id}'><button class='btn'>
                                                        <?xml version='1.0' ?><svg class = 'sparkle' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><g data-name='2. Coin' id='_2._Coin'><path d='M22,9h-.19A2.83,2.83,0,0,0,22,8V6a3,3,0,0,0-3-3H3A3,3,0,0,0,0,6V8a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,12v2a3,3,0,0,0,.22,1.12A3,3,0,0,0,0,18v2a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,24v2a3,3,0,0,0,3,3H22A10,10,0,0,0,22,9Zm-9.16,6H5a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H16A10,10,0,0,0,12.84,15ZM2,6A1,1,0,0,1,3,5H19a1,1,0,0,1,1,1V8a1,1,0,0,1-1,1H3A1,1,0,0,1,2,8ZM2,18a1,1,0,0,1,1-1h9.2a10.1,10.1,0,0,0,0,4H3a1,1,0,0,1-1-1Zm3,9a1,1,0,0,1-1-1V24a1,1,0,0,1,1-1h7.84A10,10,0,0,0,16,27Zm17,0a8,8,0,1,1,8-8A8,8,0,0,1,22,27Z'/><path d='M22,16h2a1,1,0,0,0,0-2H23a1,1,0,0,0-2,0v.18A3,3,0,0,0,22,20a1,1,0,0,1,0,2H20a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,22,18a1,1,0,0,1,0-2Z'/></g></svg>
                                                    </button></a>
                                                </section>
                                                <section class = 'btn-container'>
                                                    <a href='../view/deletar.php?cod={$dt->est_id}'><button class='btn delete'>
                                                        <?xml version='1.0' encoding='iso-8859-1'?><svg class = 'sparkle' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 460.775 460.775' xml:space='preserve'><path d='M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z'/></svg>
                                                    </button></a>
                                                </section>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Produto não encontrado</td><tr>";
                            }

                        } elseif (isset($_POST['Produto']) && isset($_POST['validade'])) {
                            $valor1 = $_POST['valor1'];
                            $valor2 = $_POST['valor2'];
                            $produto = $_POST['Produto'];
                            $validade = $_POST['validade'];

                            $stmt = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM produtos_tbl INNER JOIN estoque_tbl USING (pro_id) WHERE pro_nome LIKE '%$produto%' AND est_quantidade BETWEEN ? AND ? AND est_data_validade = $validade ORDER BY pro_nome ASC;");
                            $stmt->bindParam(1, $valor1);
                            $stmt->bindParam(2, $valor2);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>      
                                            <td>{$dt->pro_nome}</td>
                                            <td>{$dt->est_quantidade}</td>
                                            <td>{$dt->est_data_validade}</td>
                                            <td class='td-flex'>
                                                <section class = 'btn-container'>
                                                    <a href='../view/vendas.php?cod={$dt->est_id}'><button class='btn'>
                                                        <?xml version='1.0' ?><svg class = 'sparkle' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><g data-name='2. Coin' id='_2._Coin'><path d='M22,9h-.19A2.83,2.83,0,0,0,22,8V6a3,3,0,0,0-3-3H3A3,3,0,0,0,0,6V8a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,12v2a3,3,0,0,0,.22,1.12A3,3,0,0,0,0,18v2a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,24v2a3,3,0,0,0,3,3H22A10,10,0,0,0,22,9Zm-9.16,6H5a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H16A10,10,0,0,0,12.84,15ZM2,6A1,1,0,0,1,3,5H19a1,1,0,0,1,1,1V8a1,1,0,0,1-1,1H3A1,1,0,0,1,2,8ZM2,18a1,1,0,0,1,1-1h9.2a10.1,10.1,0,0,0,0,4H3a1,1,0,0,1-1-1Zm3,9a1,1,0,0,1-1-1V24a1,1,0,0,1,1-1h7.84A10,10,0,0,0,16,27Zm17,0a8,8,0,1,1,8-8A8,8,0,0,1,22,27Z'/><path d='M22,16h2a1,1,0,0,0,0-2H23a1,1,0,0,0-2,0v.18A3,3,0,0,0,22,20a1,1,0,0,1,0,2H20a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,22,18a1,1,0,0,1,0-2Z'/></g></svg>
                                                    </button></a>
                                                </section>
                                                <section class = 'btn-container'>
                                                    <a href='../view/deletar.php?cod={$dt->est_id}'><button class='btn delete'>
                                                        <?xml version='1.0' encoding='iso-8859-1'?><svg class = 'sparkle' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 460.775 460.775' xml:space='preserve'><path d='M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z'/></svg>
                                                    </button></a>
                                                </section>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Dados Inválidos ou Não Encontrados</td><tr>";
                            }

                        }
                    } else {
                        $stmt = $conexao->prepare("SELECT est_id, pro_id, pro_nome, est_quantidade, est_data_validade FROM produtos_tbl INNER JOIN estoque_tbl USING (pro_id) ORDER BY pro_nome ASC ;");
                        if ($stmt->execute()) {
                            while ($dt = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>
                                        <td>{$dt->pro_nome}</td>
                                        <td>{$dt->est_quantidade}</td>
                                        <td>{$dt->est_data_validade}</td>
                                        <td class='td-flex'>
                                            <section class = 'btn-container'>
                                                <a href='../view/vendas.php?cod={$dt->est_id}'><button class='btn'>
                                                    <?xml version='1.0' ?><svg class = 'sparkle' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><g data-name='2. Coin' id='_2._Coin'><path d='M22,9h-.19A2.83,2.83,0,0,0,22,8V6a3,3,0,0,0-3-3H3A3,3,0,0,0,0,6V8a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,12v2a3,3,0,0,0,.22,1.12A3,3,0,0,0,0,18v2a3,3,0,0,0,2.22,2.88A3,3,0,0,0,2,24v2a3,3,0,0,0,3,3H22A10,10,0,0,0,22,9Zm-9.16,6H5a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H16A10,10,0,0,0,12.84,15ZM2,6A1,1,0,0,1,3,5H19a1,1,0,0,1,1,1V8a1,1,0,0,1-1,1H3A1,1,0,0,1,2,8ZM2,18a1,1,0,0,1,1-1h9.2a10.1,10.1,0,0,0,0,4H3a1,1,0,0,1-1-1Zm3,9a1,1,0,0,1-1-1V24a1,1,0,0,1,1-1h7.84A10,10,0,0,0,16,27Zm17,0a8,8,0,1,1,8-8A8,8,0,0,1,22,27Z'/><path d='M22,16h2a1,1,0,0,0,0-2H23a1,1,0,0,0-2,0v.18A3,3,0,0,0,22,20a1,1,0,0,1,0,2H20a1,1,0,0,0,0,2h1a1,1,0,0,0,2,0v-.18A3,3,0,0,0,22,18a1,1,0,0,1,0-2Z'/></g></svg>
                                                </button></a>
                                            </section>
                                            <section class = 'btn-container'>
                                                <a href='../view/deletar.php?cod={$dt->est_id}'><button class='btn delete'>
                                                    <?xml version='1.0' encoding='iso-8859-1'?><svg class = 'sparkle' version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 460.775 460.775' xml:space='preserve'><path d='M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z'/></svg>
                                                </button></a>
                                            </section>
                                        </td>
                                     </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Erro ao executar a consulta</td></tr>";
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

    <script src="../js/sugestoes.js"></script>
    <script src="../js/sugestList.js"></script>
    <script>
        const addI = document.getElementById('add')
        const addForm = document.getElementById('atualizar')
        const searchForm = document.getElementById('search-form')
        const addB = document.getElementById('add-button')
        const addHeight = addForm.offsetHeight
        const searchHeight = searchForm.offsetHeight

        if (addI.checked) {

            addForm.style.top = `calc(${searchHeight}px + 40px)`
            addForm.style.marginTop = '2rem'

            console.log('CHECK')
        } else {
            addForm.style.top = '2rem'
            addForm.style.marginTop = `-${searchHeight}px`
            // addForm.style.marginTop = "calc(-20px -20px)"
            // addForm.style.marginTop = `calc(0px - ${searchHeight})`

            console.log('UNCHECK')
        }

        addB.addEventListener('click', () => {

            if (addI.checked) {
                console.log('CHECK')
                addForm.style.top = `calc(${searchHeight}px + 40px)`
                addForm.style.marginTop = '2rem'

            } else if (!addI.checked) {
                console.log('UNCHECK')
                addForm.style.top = '2rem'
                addForm.style.marginTop = `-${searchHeight}px`
                // addForm.style.marginTop = "calc(-20px -20px)"
                // addForm.style.marginTop = `calc(0px - ${searchHeight})`
            }
        })

        const th = document.querySelector('.qttde')
        function alterarTexto() {
            if (window.innerWidth <= 480) {
                th.textContent = 'Qttde'
            }
        }
        alterarTexto();
        window.addEventListener('resize', alterarTexto);
    </script>
    <script src="../js/script.js"></script>
</body>

</html>