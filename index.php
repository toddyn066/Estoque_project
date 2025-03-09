<?php
include_once './database/conexao.php';

session_start();

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexao->prepare("SELECT * FROM login_tbl WHERE log_email = '$email' AND log_senha = '$password';");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        header('location: ./view/index.php');
        $_SESSION['usuario_logado'] = $email;
    } else {
        $alert = "E-mail ou senha inválidos.";
        header('location: ./index.php?alert=' . urldecode($alert));
    }
}

if (isset($_GET['alert'])) {
    $message = $_GET['alert'];
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>🔥 Villa Garden 🔥</title>
</head>

<body>
    <div class="container">
        <div class="heading">Login</div>
        <form action="./index.php" method="post" class="form">
            <input required="" class="input" type="email" name="email" id="email" placeholder="E-mail">
            <input required="" class="input" type="password" name="password" id="password" placeholder="Senha">
            <span class="forgot-password"><a href="#"><?php echo $message; ?></a></span>
            <input class="login-button" type="submit" value="Sign In">
        </form>
    </div>
</body>

</html>

<?php


?>