<?php

include "config/conexao.php";

$pesquisa = $_GET["pesquisa"] ?? "";

$sql = "SELECT * FROM tb_livros WHERE nome LIKE '%$pesquisa%'";
$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Livros| Biblios</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>Biblios</h1>
        <p class="subtitulo">Livros cadastrados na loja</p>

        <div class="formulario">

            <h2>Lista de livros</h2>
            <form action= "historico_livros.php" method="GET">
                <input type="text" name="pesquisa" placeholder="Digite o nome do livro">
                <button type="submit">🔍 Pesquisar</button>
                <a href="listar.php">Limpar</a>
            </form>

            <br><br>