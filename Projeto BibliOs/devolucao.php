<?php

include "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $data_devolucao = $_POST["data_devolucao"];
    $observacao = $_POST["observacao_devolucao"];

    try {

        $conexao->beginTransaction();

        // Busca o livro do empréstimo
        $sql = "SELECT id_livro
                FROM tb_emprestimo_livros
                WHERE id = :id AND status = 'andamento'";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([":id" => $id]);

        $livro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$livro) {
            throw new Exception("Empréstimo não encontrado ou já devolvido.");
        }

        // Registra a devolução
        $sql = "UPDATE tb_emprestimo_livros
                SET status = 'entregue',
                    data_devolucao = :data,
                    observacao_devolucao = :observacao
                WHERE id = :id";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            ":data" => $data_devolucao,
            ":observacao" => $observacao,
            ":id" => $id
        ]);

        // Deixa o livro disponível novamente
        $sql = "UPDATE tb_livros
                SET status = 'Disponível'
                WHERE id_livro = :livro";

        $stmt = $conexao->prepare($sql);

        $stmt->execute([
            ":livro" => $livro["id_livro"]
        ]);

        $conexao->commit();

        echo "Devolução registrada com sucesso!";

    }
    catch (Exception $erro) {

        $conexao->rollBack();

        echo "Erro ao registrar devolução: " . $erro->getMessage();
    }

    echo "<br><a href='devolucao.php'>Voltar</a>";
    echo "<br><a href='lista_emprestimos.php'>Ver empréstimos</a>";

    exit;
}

$sql = "SELECT
            el.id,
            e.id_emprestimo,
            l.nome_leitor,
            b.titulo,
            e.data_saida,
            e.data_devolucao_prevista

        FROM tb_emprestimo_livros el

        INNER JOIN tb_emprestimos e
            ON el.id_emprestimo = e.id_emprestimo

        INNER JOIN tb_leitores l
            ON e.id_leitor = l.id_leitor

        INNER JOIN tb_livros b
            ON el.id_livro = b.id_livro

        WHERE el.status = 'andamento'

        ORDER BY e.id_emprestimo DESC";

$emprestimos = $conexao->query($sql);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Devolução de Livros - BibliOS</title>
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

    <h2>Devolução de Livros</h2>

    <form action="devolucao.php" method="post">

        <label>Selecionar empréstimo:</label>
        <select name="id" required>
            <option value="" disabled selected>Escolha um empréstimo feito:</option>

            <?php
            while ($emprestimo = $emprestimos->fetch(PDO::FETCH_ASSOC)) {

                echo "<option value='".$emprestimo['id']."'>";

                echo htmlspecialchars(
                    $emprestimo['nome_leitor'] . " - " .
                    $emprestimo['titulo']
                );

                echo "</option>";
            }
            ?>

        </select>

        <label>Data de devolução:</label>
        <input type="date"
            name="data_devolucao"
            value="<?php echo date('Y-m-d'); ?>"
            required>

        <label>Observação de devolução:</label>
        <textarea name="observacao_devolucao"
                rows="4"
                placeholder="Descreva o estado do livro na devolução"></textarea>

        <button type="submit">Dar baixa</button>
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