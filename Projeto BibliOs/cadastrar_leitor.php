<?php

include "config/conexao.php";

$nome_leitor = $_POST["nome_leitor"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$data_nascimento = $_POST["data_nascimento"];

$foto = $_FILES["foto"]["name"];

$pasta = "leitores/";

move_uploaded_file($_FILES["foto"]["tmp_name"], $pasta . $foto);

$sql = "INSERT INTO tb_leitores (nome_leitor, email, telefone, data_nascimento, foto) VALUES ('$nome_leitor', '$email', '$telefone', '$data_nascimento', '$foto')";

if ($conexao->query($sql)){
    echo "Leitor cadastrado com sucesso!";
}
else {
    echo "Erro ao cadastrar o leitor!";
}

echo "<br><a href='lista_leitores.php'>Ir para a Página dos Leitores</a>";

?>