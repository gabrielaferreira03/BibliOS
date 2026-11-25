<?php

include "config/conexao.php";

$titulo = $_GET["titulo"];

$sql = "SELECT* FROM tb_livros WHERE titulo = $titulo";
$resultado = $conexao->query($sql);

$produto = $resultado->fetch(PDO::FETCH_ASSOC);
?>

if ($conexao->query($sql)){
    echo "✅ Livro excluído com sucesso!";
}
else {
    echo "❌ Erro ao excluir o livro!";
}

echo "<br><a href='inicial.html'>Voltar para a lista</a>";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro | Biblios</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Cadastro de Novos Livros</h2>

    <form>

        <label>Título do livro:</label>
        <input type="text" name="titulo">
        <br><br>

        <label>Autor:</label>
        <input type="text" name="autor">
        <br><br>

        <label>Gênero:</label>
        <select name="genero">
            <option value="romance">Romance</option>
            <option value="fantasia">Fantasia</option>
            <option value="terror">Terror</option>
            <option value="aventura">Aventura</option>
            <option value="ficcao">Ficção</option>
        </select>

        <br><br>
        
        <label>Capa do livro:</label>
        <input type="file" name="capa">
        <br><br>

        <label>Status:</label>
        <select name="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>

        <br><br>

        <button type="submit">Editar</button>

    </form>

