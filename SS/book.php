<?php
require_once '../Config/config.php';
require_once 'App/Controller/LivroController.php';
require_once 'App/Controller/EmprestimoController.php';

session_start();

$livroController = new LivroController($pdo);
$emprestimoController = new EmprestimoController($pdo);

$livros = $livroController->listarLivros();

$livrosPorCategoria = [];
foreach ($livros as $livro) {
    $categoria = $livro['categoria'];
    if (!isset($livrosPorCategoria[$categoria])) {
        $livrosPorCategoria[$categoria] = [];
    }
    $livrosPorCategoria[$categoria][] = $livro;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestar'])) {
    $livroID = $_POST['livro_id'];
    $livroNome = $_POST['nome'];
    $usuarioNome = $_SESSION['usuarioNomedeUsuario'];

    $emprestimoController->emprestarLivro($livroID, $livroNome, $usuarioNome);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $livroID = $_POST['livro_id'];

    $emprestimoController->devolverLivro($livroID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="Public/Js/script.js"></script>
    <link rel="stylesheet" href="Public/Css/style_book.css">
    <title>Lista de Livros</title>
</head>
<body style="background-image: url('../imagens/background_bibliotecat.png')">
    <header>
    <section class="cat">
        <img src="../imagens/logo_bibliocat.png">
        
        <h1>bibliotecat</h1>

        <a href="index.php"><h5>Home</h5></a>
        <a href="book.php"><h6>Acervo</h6></a>

        <div class="user-icon" id="user-icon" onclick="showUserInfo()">
            <ion-icon name="person-circle-outline"></ion-icon>
        </div>
        <div class="user-info" id="user-info">
        <?php
            include '../Login/verifica_login.php'
        ?>
        <h3>Olá <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h3><br>
        <h4>Livros Emprestados</h4><br>
            <ul>
                <?php $livrosEmprestados = $emprestimoController->listarLivrosEmprestados($_SESSION['usuarioNomedeUsuario']); ?>
                <?php foreach ($livrosEmprestados as $emprestimo): ?>
                    <li>
                        <?php echo "<strong>ID do Livro: </strong>" . $emprestimo['livro_emprestimo']; ?> <br>
                        <?php echo "<strong>Livro: </strong>" . $emprestimo['nome_livro']; ?> <br>
                        <?php echo "<strong>Nome do Usuário: </strong>" . $emprestimo['aluno_emprestimo']; ?>
                        <form method="post" action="book.php">
                            <input type="hidden" name="livro_id" value="<?php echo $emprestimo['emprestimo_id']; ?>">
                            <button type="submit" name="devolver">Devolver</button><br><br>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <button id="log" onclick="logout()"><ion-icon name="log-out-outline"></ion-icon></button></div>
    </section>
    </header>
    <section>
        <div class="acervo">
            <h1>Nosso Acervo</h1>
        </div>
                <div class="livros">
            <?php foreach ($livrosPorCategoria as $categoria => $livrosNaCategoria): ?>
                <div class="categoria">
                    <h2><?php echo $categoria; ?></h2><br>
                    <ul>
                        <?php foreach ($livrosNaCategoria as $livro): ?>
                            <li>
                                <div class="livrobox">
                                    <?php
                                    if (!empty($livro['imagem'])) {
                                        echo '<img src="' . $livro['imagem'] . '" alt="Imagem do Livro" width="100">';
                                    } else {
                                        echo 'Sem Imagem';
                                    }
                                    ?>
                                    <?php echo $livro['nome']; ?><br>
                                    <strong><?php echo $livro['quantidade']; ?> Livro(s)</strong> Disponíveis
                                    <form method="post" action="book.php">
                                        <input type="hidden" name="livro_id" value="<?php echo $livro['livro_id']; ?>">
                                        <input type="hidden" name="nome" value="<?php echo $livro['nome']; ?>">
                                        <button type="submit" name="emprestar">Emprestar</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
