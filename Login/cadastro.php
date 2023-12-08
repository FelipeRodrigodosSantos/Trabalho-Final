<?php
session_start(); // Inicie a sessão no início do arquivo

require_once '../Config/config.php';
require_once 'App/Controller/UserController.php';

$userController = new UserController($pdo);

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $userController->criarUser($_POST['nome'], $_POST['email'], $_POST['senha']);
    header('Location: cadastro.php'); // Redirecione para a página de cadastro
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Public/Css/style_login.css">
    <title>Cadastro</title>
</head>
<body style="background-image: url('../imagens/background_bibliotecat.png')">
    <?php
    // Adicione esta parte para exibir a mensagem
    if (isset($_SESSION['mensagem'])) {
        echo '<div class="alert"><p>' . $_SESSION['mensagem'] . '</p></div>';
        unset($_SESSION['mensagem']); // Remova a mensagem da sessão
    }
    ?>



        






   <section class="cat">
        <img src="../imagens/logo_bibliocat.png">
        <h1>bibliotecat</h1>
        <img src="../imagens/livros_transparente.png">
    </section>
    <br>
    <br>
    <br>
    <br>
    <section class= "cadastro">
        <div class="login_box">
            <h2>Fazer Cadastro</h2>
            <form method="post">
                <input type="text" name="nome" placeholder="Nome Usuário" required>
                <input type="text" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <div class="button"><button type="submit">Criar</button>
            </form>
            <form action="login.php">
                <button>Voltar</button>
            </form></div>
        </div>
    </section>
</body>
</html>