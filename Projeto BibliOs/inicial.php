
<?php

include "config/conexao.php";

// Total de livros
$sql_livros = "SELECT COUNT(*) FROM tb_livros";
$total_livros = $conexao->query($sql_livros)->fetchColumn();

// Total de leitores
$sql_leitores = "SELECT COUNT(*) FROM tb_leitores";
$total_leitores = $conexao->query($sql_leitores)->fetchColumn();

// Livros disponíveis
$sql_disponiveis = "SELECT COUNT(*) FROM tb_livros  WHERE status = 'Disponível'";
$total_disponiveis = $conexao->query($sql_disponiveis)->fetchColumn();

// Livros emprestados
$sql_emprestados = "SELECT COUNT(*) FROM tb_livros WHERE status = 'Emprestado'";
$total_emprestados = $conexao->query($sql_emprestados)->fetchColumn();

// Calcula a porcentagem do gráfico
if ($total_livros > 0) {
    $percent_disponiveis = ($total_disponiveis / $total_livros) * 100;
} else {
    $percent_disponiveis = 0;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BibliOS | Início</title>
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

    <main class="conteudo-inicial">

        <section class="boas-vindas">
            <p class="subtitulo">SEU ESPAÇO DE LEITURA</p>
            <h2>Bem-vindo ao BibliOS! 📚</h2>
            <p>
                Organize livros, acompanhe leitores e gerencie
                empréstimos em um só lugar.
            </p>
        </section>

        <section class="menu-inicial">
            <h2>O que você deseja acessar?</h2>

            <div class="grade-menu">

                <a href="livros.html" class="cartao-menu">
                    <span class="icone-menu">📚</span>
                    <h3>Cadastro de Novos Livros</h3>
                    <p>Consulte e cadastre os livros da biblioteca.</p>
                    <span class="acessar">Acessar página →</span>
                </a>

                <a href="lista_leitores.php" class="cartao-menu">
                    <span class="icone-menu">👥</span>
                    <h3>Leitores</h3>
                    <p>Veja e gerencie os cadastros dos leitores.</p>
                    <span class="acessar">Acessar página →</span>
                </a>

                <a href="lista_emprestimos.php" class="cartao-menu">
                    <span class="icone-menu">📋</span>
                    <h3>Empréstimos</h3>
                    <p>Registre a saída de livros para os leitores.</p>
                    <span class="acessar">Acessar página </span>
                </a>

                <a href="lista_livros.php" class="cartao-menu">
                    <span class="icone-menu">📖</span>
                    <h3>ACERVO DA BIBLIOTECA</h3>
                    <p>Veja aqui todos os livros que existem em nossa biblioteca.</p>
                    <span class="acessar">Acessar página →</span>
                </a>

                <a href="devolucao.php" class="cartao-menu">
                    <span class="icone-menu">↩️</span>
                    <h3>Devoluções</h3>
                    <p>Registre o retorno dos livros emprestados.</p>
                    <span class="acessar">Acessar página →</span>
                </a>

                <a href="sobre.html" class="cartao-menu">
                    <span class="icone-menu">ℹ️</span>
                    <h3>Sobre o BibliOS</h3>
                    <p>Conheça o sistema e sua finalidade.</p>
                    <span class="acessar">Saiba mais →</span>
                </a>

            </div>
        </section>

        <hr>

        <section class="painel-biblios">

            <h2>📊 Resumo da Biblioteca</h2>
            <p class="subtitulo-painel">
                Acompanhe as informações do seu acervo.
            </p>

            <!-- Cartões de estatísticas -->
            <div class="grade-estatisticas">

                <div class="cartao-estatistica livros">
                    <div class="icone-estatistica">📚</div>
                    <h3>Total de livros</h3>
                    <p><?php echo $total_livros; ?></p>
                    <span>Livros cadastrados</span>
                </div>

                <div class="cartao-estatistica leitores">
                    <div class="icone-estatistica">👥</div>
                    <h3>Total de leitores</h3>
                    <p><?php echo $total_leitores; ?></p>
                    <span>Leitores cadastrados</span>
                </div>

                <div class="cartao-estatistica disponiveis">
                    <div class="icone-estatistica">📗</div>
                    <h3>Disponíveis</h3>
                    <p><?php echo $total_disponiveis; ?></p>
                    <span>Livros disponíveis</span>
                </div>

                <div class="cartao-estatistica emprestados">
                    <div class="icone-estatistica">📕</div>
                    <h3>Emprestados</h3>
                    <p><?php echo $total_emprestados; ?></p>
                    <span>Livros emprestados</span>
                </div>

            </div>

            
            <!-- Gráfico de rosca -->
            <div class="area-grafico">

                <h3>Disponibilidade do acervo</h3>
                <p>Confira a situação dos livros da biblioteca.</p>

                <div class="conteudo-grafico">

                    <div class="grafico-pizza"
                        style="background: conic-gradient(
                            #800020 0% <?php echo $percent_disponiveis; ?>%,
                            #E8BFC7 <?php echo $percent_disponiveis; ?>% 100%
                        );">

                        <div class="centro-grafico">
                            <strong><?php echo $total_livros; ?></strong>
                            <span> Total de Livros</span>
                        </div>

                    </div>

                    <div class="legenda-grafico">

                        <div class="item-legenda">
                            <span class="cor-legenda verde"></span>
                            <div>
                                <strong>Disponíveis</strong>
                                <p>
                                    <?php echo $total_disponiveis; ?> livros
                                    (<?php echo number_format($percent_disponiveis, 1, ',', '.'); ?>%)
                                </p>
                            </div>
                        </div>

                        <div class="item-legenda">
                            <span class="cor-legenda coral"></span>
                            <div>
                                <strong>Emprestados</strong>
                                <p>
                                    <?php echo $total_emprestados; ?> livros
                                    (<?php
                                    if ($total_livros > 0) {
                                        echo number_format(
                                            ($total_emprestados / $total_livros) * 100,
                                            1, ',', '.'
                                        );
                                    } else {
                                        echo "0,0";
                                    }
                                    ?>%)
                                </p>
                            </div>
        </section>

    </main>

    <footer class="rodape-inicial">
        <p>BibliOS © 2026 — Organização e conhecimento em um só lugar.</p>
    </footer>

</body>
</html>