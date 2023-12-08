<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Public/Js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="Public/Css/index.css">
    <title>ADM</title>
</head>
<body style="background-image: url('../imagens/background_bibliotecat.png')">
    <?php
        session_start();
        include '../Login/verifica_login.php'
    ?>
    <h2>Olá <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h2>
    <button id="log" onclick="logout()"><ion-icon name="log-out-outline"></ion-icon></button><br>
    <div class="container">
        <a href="livro.php">Livros</a>
        <a href="users.php">Users</a>
        <a href="lista.php">Lista</a>
    </div>
</body>
</html>