
<?php

include "config/conexao.php";

$leitor = $_POST["leitor"];
$livros = $_POST["livros"];
$data_saida = $_POST["data_saida"];
$observacao = $_POST["observacao_saida"];

$data = new DateTime($_POST["data_saida"]);
$data->modify("+15 days");

$data_prevista = $data->format("Y-m-d");

try {

    // Inicia uma transação
    $conexao->beginTransaction();

    // Verifica se todos os livros estão disponíveis
    foreach ($livros as $id_livro) {

        $sql_verifica = "SELECT status FROM tb_livros
                         WHERE id_livro = :livro";

        $stmt_verifica = $conexao->prepare($sql_verifica);
        $stmt_verifica->execute([":livro" => $id_livro]);

        $status_livro = $stmt_verifica->fetchColumn();

        if ($status_livro != "Disponível") {
            throw new Exception("Um ou mais livros selecionados não estão disponíveis.");
        }
    }

    // Cadastra o empréstimo
    $sql = "INSERT INTO tb_emprestimos
            (id_leitor, data_saida, data_devolucao_prevista, observacao_saida)
            VALUES (:leitor, :saida, :prevista, :observacao)";

    $stmt = $conexao->prepare($sql);

    $stmt->execute([
        ":leitor" => $leitor,
        ":saida" => $data_saida,
        ":prevista" => $data_prevista,
        ":observacao" => $observacao
    ]);

    // Pega o ID do empréstimo cadastrado
    $id_emprestimo = $conexao->lastInsertId();

    // Cadastra cada livro selecionado
    foreach ($livros as $id_livro) {

        $sql_livro = "INSERT INTO tb_emprestimo_livros
                      (id_emprestimo, id_livro)
                      VALUES (:emprestimo, :livro)";

        $stmt_livro = $conexao->prepare($sql_livro);

        $stmt_livro->execute([
            ":emprestimo" => $id_emprestimo,
            ":livro" => $id_livro
        ]);

        // Atualiza o status do livro
        $sql_status = "UPDATE tb_livros
                       SET status = 'Emprestado'
                       WHERE id_livro = :livro";

        $stmt_status = $conexao->prepare($sql_status);

        $stmt_status->execute([
            ":livro" => $id_livro
        ]);
    }

    // Confirma as alterações
    $conexao->commit();

    echo "Empréstimo cadastrado com sucesso!";

}
catch (Exception $erro) {

    // Desfaz as alterações se ocorrer algum erro
    if ($conexao->inTransaction()) {
        $conexao->rollBack();
    }

    echo "Erro ao cadastrar empréstimo: " . $erro->getMessage();
}

echo "<br><a href='emprestimo_livro.php'>Voltar</a>";
echo "<br><a href='lista_emprestimos.php'>Ver empréstimos</a>";

?>