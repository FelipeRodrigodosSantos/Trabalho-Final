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
    <link rel="stylesheet" href="Public/Css/style_index.css">
    <title>bibliotecat</title>
</head>
<body>
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
    <section><br><br>
        <div class="bioP">
            <img src="../imagens/livros extras.png" alt="Pietro">
            <div class="lineBio"></div>
            <div class="desc"><p>É com grande prazer que te recebemos em nosso site!!!<br><br><br>
        VOCÊ SABIA QUE ESTA BIBLIOTECA É INTEIRAMENTE VIRTUAL?<br>
    Esta biblioteca tem como proposta levar até a sua casa o prazer de ler, portanto não temos uma sede física.</p></div>
        </div>
        <div class="bioO">
            <img src="Public/Assets/Oscar.jpeg" alt="Oscar">
            <div class="lineBio"></div>
            <div class="desc"><p>NOSSO MAIOR COLABORADOR:<BR>Oscar Osvaldo é um talentoso autor e programador cujo dom para contar histórias se funde elegantemente com sua habilidade em código. 
            Desde jovem, Oscar cativou leitores com narrativas envolventes, e ao abraçar a era digital, ele se tornou um mestre na programação, criando soluções inovadoras.
            Contribuindo significativamente para este site, Oscar é reconhecido por seus artigos informativos e por compartilhar seu conhecimento tanto em escrita quanto em programação.
            Sua paixão por inspirar outros é evidente, tornando-o uma figura respeitada na comunidade online. 
            Oscar Osvaldo continua a explorar os limites entre palavras e códigos, deixando um impacto duradouro como um pioneiro em ambos os campos.</p></div>
        </div>
        <div class="pub">
            <div class="cub"></div>
            <div class="pubtext"><p>Clique <a href="book.php" style="color:#FF0099">Aqui</a> para acessar nosso acervo digital!</p></div>
        </div>
    </section>
</body>
</html>