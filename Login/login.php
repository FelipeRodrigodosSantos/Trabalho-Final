<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Public/Css/style_login.css">
    <title>Login</title>
</head>
<body style="background-image: url('../imagens/background_bibliotecat.png');">
    <header>
    <?php
        if(isset($_SESSION['nao_autenticado'])):
            echo '<div class="alert">Usuário ou senha inválidos!</div>';
            unset($_SESSION['nao_autenticado']);
        endif;
        ?>
    </header>

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
            <h2>Login</h2>

            <form action="loginconfig.php" method="POST">
                <div class="input">
                    <input type="text" name="email" placeholder="E-mail ou Nome de Usuário">
                    <input type="password" name="senha" placeholder="Senha">
                </div>
                <div class="button">
                    <button type="submit">Login</button>
            </form>

            <form action="cadastro.php">
            <button>Crie sua conta</button></div>
            </form>
        </div>
    </section>
</body>
</html>
