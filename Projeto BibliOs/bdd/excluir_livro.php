<?php

include "config/conexao.php";

$titulo = $_GET["titulo"];

$sql = "DELETE FROM tb_livros WHERE titulo = $titulo";

if ($conexao->query($sql)){
    echo "✅ Livro excluído com sucesso!";
}
else {
    echo "❌ Erro ao excluir o livro!";
}

echo "<br><a href='inicial.html'>Voltar para a lista</a>";
?>