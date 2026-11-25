
<?php

include "config/conexao.php";

$titulo = $_POST["titulo"];
$autor = $_POST["autor"];
$genero = $_POST["genero"];
$status = "Disponível";

$capa = $_FILES["capa"]["name"];

$pasta = "capas/";

move_uploaded_file($_FILES["capa"]["tmp_name"], $pasta . $capa);

$sql = "INSERT INTO tb_livros (titulo, autor, genero, capa, status)
        VALUES (:titulo, :autor, :genero, :capa, :status)";

$stmt = $conexao->prepare($sql);

if ($stmt->execute([
    ":titulo" => $titulo,
    ":autor" => $autor,
    ":genero" => $genero,
    ":capa" => $capa,
    ":status" => $status
])) {
    echo "Livro cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar livro.";
}

echo "<br><a href='lista_livros.php'>Ir para o Catálogo de Livros</a>";

?>
