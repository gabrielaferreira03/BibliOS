<?php

include "config/conexao.php";

$sql = "SELECT
            e.id_emprestimo,
            l.nome_leitor,
            l.foto,
            e.data_saida,
            e.data_devolucao_prevista,
            b.titulo,
            b.capa,
            el.status,

            CASE
                WHEN LOWER(el.status) = 'entregue'
                    THEN 'entregue'
                WHEN e.data_devolucao_prevista < CURDATE()
                    THEN 'atrasado'
                ELSE 'andamento'
            END AS situacao

        FROM tb_emprestimos e

        INNER JOIN tb_leitores l
            ON e.id_leitor = l.id_leitor

        INNER JOIN tb_emprestimo_livros el
            ON e.id_emprestimo = el.id_emprestimo

        INNER JOIN tb_livros b
            ON el.id_livro = b.id_livro

        ORDER BY e.id_emprestimo DESC";

$emprestimos = $conexao->query($sql);

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empréstimos - BibliOS</title>
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

    <h2>Lista de Empréstimos 🔍</h2>

    <p>
        <a href="emprestimo_livro.php">
            <button>Novo empréstimo</button>
        </a>

        <a href="devolucao.php">
            <button>Registrar devolução</button>
        </a>
    </p>

    
<div class="filtro-emprestimos">
    <label for="filtro">Filtrar empréstimos:</label>

    <select id="filtro" onchange="filtrarEmprestimos()">
        <option value="todos">Todos os empréstimos</option>
        <option value="atrasado">Somente atrasados</option>
        <option value="andamento">Em andamento</option>
        <option value="entregue">Entregues</option>
    </select>
</div>


    <table border="1" id="tabelaEmprestimos">

        <tr>
            <th>Aluno</th>
            <th>Livro</th>
            <th>Data de saída</th>
            <th>Devolução prevista</th>
            <th>Situação</th>
        </tr>

        <?php
        while ($emprestimo = $emprestimos->fetch(PDO::FETCH_ASSOC)) {

            $situacao = $emprestimo['situacao'];

            $saida = date(
                "d/m/Y",
                strtotime($emprestimo['data_saida'])
            );

            $devolucao = date(
                "d/m/Y",
                strtotime($emprestimo['data_devolucao_prevista'])
            );
        ?>

        <tr data-situacao="<?php echo $situacao; ?>">

            <td>
                <img src="leitores/<?php echo htmlspecialchars($emprestimo['foto']); ?>"
                    alt="Foto do leitor">

                <br>

                <?php echo htmlspecialchars($emprestimo['nome_leitor']); ?>
            </td>

            <td>
                <img src="capas/<?php echo htmlspecialchars($emprestimo['capa']); ?>"
                    alt="Capa do livro">

                <br>

                <?php echo htmlspecialchars($emprestimo['titulo']); ?>
            </td>

            <td>
                <?php echo $saida; ?>
            </td>

            <td>
                <?php echo $devolucao; ?>
            </td>

            <td class="situacao <?php echo $situacao; ?>">

                <?php
                if ($situacao == "andamento") {
                    echo "Em andamento";
                }
                elseif ($situacao == "atrasado") {
                    echo "Atrasado";
                }
                else {
                    echo "Entregue";
                }
                ?>

            </td>
        </tr>
    <?php
    }
    ?>

</table>

    
    <div class="voltar-inicio">
    <a href="inicial.php">← Voltar ao início</a>
    </div>

    <footer class="rodape-inicial">
        <p>BibliOS © 2026 — Organização e conhecimento em um só lugar.</p>
    </footer>

    <script>
        function filtrarEmprestimos() {
            var filtro = document.getElementById("filtro").value;
            var linhas = document.querySelectorAll(
                "#tabelaEmprestimos tr[data-situacao]"
            );

            linhas.forEach(function(linha) {
                if (filtro === "todos" ||
                    linha.dataset.situacao === filtro) {
                    linha.style.display = "";
                } else {
                    linha.style.display = "none";
                }
            });
        }
    </script>

</body>
</html>