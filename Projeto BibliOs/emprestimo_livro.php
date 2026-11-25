<?php
include "config/conexao.php";

$sql_leitores = "SELECT * FROM tb_leitores";
$leitores = $conexao->query($sql_leitores);

$sql_livros = "SELECT * FROM tb_livros  WHERE status = 'Disponível'";
$livros = $conexao->query($sql_livros);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Empréstimo de Livros - BibliOS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo_semfundo.png">
</head>
<body>

    <header class="cabecalho-inicial">
        <img src="BibliOS.png" alt="Logo do BibliOS">

        <div>
            <h1>BibliOS</h1>
            <p>Sistema de Gerenciamento de Biblioteca</p>
        </div>
    </header>

    <h2>Empréstimo de Livros</h2>

    <form action="emprestimo.php" method="post">

        <label>Selecionar aluno:</label>
        <select name="leitor" required>
            <option value="" disabled selected>Escolha um leitor</option>
            
            <?php
            while ($leitor = $leitores->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$leitor['id_leitor']."'>";
                echo $leitor['nome_leitor'];
                echo "</option>";
            }
            ?>
        </select>

        <label>Selecionar livro(s):</label>
        <select name="livros[]" multiple required>
            <?php
            while ($livro = $livros->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='".$livro['id_livro']."'>";
                echo $livro['titulo']." - ".$livro['autor'];
                echo "</option>";
    }
    ?>
        </select>

        <p>Segure Ctrl para selecionar mais de um livro.</p>

        <label>Data de saída:</label>
        <input type="date" name="data_saida" id="data_saida" required>

        <label>Data prevista de devolução:</label>
        <input type="date" name="data_prevista" id="data_prevista" readonly>

        <label>Observação de saída:</label>
        <textarea name="observacao_saida"
                  rows="4"
                  placeholder="Estado do livro ou outras observações"></textarea>

        <button type="submit">Confirmar empréstimo</button>

    </form>

    
    <div class="voltar-inicio">
    <a href="inicial.php">← Voltar ao início</a>
    </div>

    <p><a href="lista_emprestimos.php">Ver empréstimos</a></p>

    <footer class="rodape-inicial">
        <p>BibliOS © 2026 — Organização e conhecimento em um só lugar.</p>
    </footer>


</body>
</html>