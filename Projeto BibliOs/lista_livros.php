<?php

include "config/conexao.php";

$pesquisa = $_GET["pesquisa"] ?? "";

$sql = "SELECT * FROM tb_livros
        WHERE titulo LIKE '%$pesquisa%'
        OR autor LIKE '%$pesquisa%'";

$resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BibliOS | Acervo </title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo_semfundo.png">
</head>

<body class="pagina-inicial">

    <header class="cabecalho-inicial">
        <img src="BibliOS.png" alt="Logo do BibliOS">

        <div>
            <h1>BibliOS</h1>
            <p>Sistema de Gerenciamento de Biblioteca</p>
        </div>
    </header>

<section class="acervo">
    <h2>📚 Acervo da Biblioteca</h2>
    <p class="descricao-acervo">
        Conheça alguns dos livros disponíveis em nosso acervo.
    </p>

    <div class="pesquisa-acervo">

        <form action="lista_livros.php" method="GET">

            <input type="text" name="pesquisa"
                placeholder="Pesquisar por título ou autor..."
                value="<?php echo htmlspecialchars($pesquisa); ?>">

            <button type="submit">🔍 Pesquisar</button>
            <a href="lista_livros.php">Limpar</a>
        </form>

    </div>

    <div class="grade-livros">


        <?php while ($livro = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="cartao-livro" >

                <img src="capas/"
                    alt="Capa de <?php echo htmlspecialchars($livro['titulo']); ?>">

                <h3><?php echo htmlspecialchars($livro["titulo"]); ?></h3>

                <p><?php echo htmlspecialchars($livro["autor"]); ?></p>

                <p><?php echo ucfirst(htmlspecialchars($livro["genero"])); ?></p>

                <?php
                    if ($livro['status'] == 'Disponível') {
                        echo '<span class="etiqueta disponivel">Disponível</span>';
                    } else {
                        echo '<span class="etiqueta emprestado">Emprestado</span>';
                    }
                ?>
            </div>

        <?php } ?>

    </div>

    
    <a href="livros.html" class="botao-acervo">
        Fazer cadastro de livros →
    </a>
</section>

<div class="voltar-inicio">
    <a href="inicial.php">← Voltar ao início</a>
</div>

<footer class="rodape-inicial">
    <p>BibliOS © 2026 — Organização e conhecimento em um só lugar.</p>
</footer>

</body>
</html>