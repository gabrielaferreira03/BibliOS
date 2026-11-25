<?php

include "config/conexao.php";

$sql = "SELECT
            l.*,
            GROUP_CONCAT(
                DISTINCT livro.titulo
                ORDER BY livro.titulo
                SEPARATOR ', '
            ) AS resumo

        FROM tb_leitores l

        LEFT JOIN tb_emprestimos e
            ON e.id_leitor = l.id_leitor

        LEFT JOIN tb_emprestimo_livros el
            ON el.id_emprestimo = e.id_emprestimo

        LEFT JOIN tb_livros livro
            ON livro.id_livro = el.id_livro
            AND livro.status = 'Emprestado'

        GROUP BY l.id_leitor
        ORDER BY l.nome_leitor";

$resultado = $conexao->query($sql);
$leitores = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Leitores - BibliOS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo_semfundo.png">
    <link rel="icon" href="logo_semfundo.png">

    <style> body { text-align: center; } img { width: 200px; } button { width: 112,5px; height: 45px; margin: 10px; font-size: 18px; } table {margin: auto;} </style>
</head>
<body>

    <header class="cabecalho-inicial">
        <img src="BibliOS.png" alt="Logo do BibliOS">

        <div>
            <h1>BibliOS</h1>
            <p>Sistema de Gerenciamento de Biblioteca</p>
        </div>
    </header>

    <h2>👧🏻 Alunos Cadastrados 👦🏻</h2>

    <div class="busca-leitor">
        <label>Buscar por nome:</label>
        <input type="text" id="buscarLeitor" placeholder="Digite o nome que deseja buscar">
    </div>

    <br><br>

    <table border="1" id="tabelaLeitores">

        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Resumo</th>
        </tr>

<?php foreach ($leitores as $leitor) { ?>

    <tr>
        <td>
            <img src="leitores/<?php echo htmlspecialchars($leitor['foto']); ?>"
                alt="Foto do leitor">
        </td>

        <td><?php echo htmlspecialchars($leitor["nome_leitor"]); ?></td>

        <td><?php echo htmlspecialchars($leitor["email"]); ?></td>

        <td><?php echo htmlspecialchars($leitor["telefone"]); ?></td>

        <td>
            <?php
            if (!empty($leitor["resumo"])) {
                echo "Livros emprestados: " .
                    htmlspecialchars($leitor["resumo"]);
            } else {
                echo "Nenhum livro emprestado";
            }
            ?>
        </td>
    </tr>

<?php } ?>

    </table>

    <br>

    <a href="cadastro_leitor.html">
        <button>Cadastrar Leitor →</button>
    </a>

    <br><br>
    
    <div class="voltar-inicio">
    <a href="inicial.php">← Voltar ao início</a>
    </div>

    <footer class="rodape-inicial">
        <p>BibliOS © 2026 — Organização e conhecimento em um só lugar.</p>
    </footer>


    <script>

        const campoPesquisa = document.getElementById("buscarLeitor");
        const tabela = document.getElementById("tabelaLeitores");

        campoPesquisa.addEventListener("input", function() {

            const pesquisa = campoPesquisa.value.toLowerCase();

            // Percorre todas as linhas da tabela
            const linhas = tabela.querySelectorAll("tr");

            linhas.forEach(function(linha, indice) {

                // Ignora a primeira linha, que contém os títulos
                if (indice === 0) {
                    return;
                }

                // Pega o nome do leitor
                const nome = linha.cells[1].textContent.toLowerCase();

                // Verifica se o nome corresponde à pesquisa
                if (nome.includes(pesquisa)) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }

            });

        });

    </script>

</body>
</html>