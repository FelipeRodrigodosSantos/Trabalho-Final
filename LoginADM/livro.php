<?php
require_once '../Config/config.php';
require_once 'App/Controller/LivroController.php';

if (isset($_FILES['imagem']) && !empty($_FILES['imagem'])) {
    $imagem = "../uploads/" . $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
} else {
    $imagem = "";
}

$livroController = new LivroController($pdo);

if (isset($_POST['nome']) && 
    isset($_POST['categoria']) &&
    isset($_POST['quantidade']) &&
    isset($_POST['categoria_id'])) 
{
    $livroController->criarLivro($_POST['nome'], $_POST['categoria'], $_POST['quantidade'], $imagem, $_POST['categoria_id']);
    header('Location: #');
}
$livros = $livroController->listarLivros();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Public/Css/style.css">
    <title>Livros</title>
</head>
<body>
    <header>
        <a href="index.php">Voltar</a>
        <h1>Livros</h1>
    </header>
    
    <form action="livro.php" method="post" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="categoria" placeholder="Categoria" required>
        <input type="number" name="quantidade" placeholder="Qntd De Livros" min="1" max="5" required>
        <input type="file" name="imagem" accept="image/*" required>
        <input type="number" name="categoria_id" required placeholder="Categoria_id">
        <button type="submit">Adicionar Livro</button>
    </form>

    <?php
        $livroController->exibirListaLivros();
    ?>
</body>
</html>