<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();
$fatura_inicial = 0;
$total_fatura = 0 ;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas Realizadas</title>
    <link rel="icon" href="logo.jpg">
    <link rel="stylesheet" href="estiliza.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="logo.jpg" alt="Logo Casa da Madeira">
            <div class="logo-text">
                <strong>Casa da Madeira</strong>
                <small>Desde 2017</small>
            </div>
        </div>
        
        <div class="header-right">
            <a href="cadastro_produtos.html" class="btn">Cadastro de produtos</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="home_adm.php" class="btn">Home</a>
            <a href='logout.php' class='btn'>logout</a>
        </div>
    </header>

    <main>
        <div class="home-content">
            <section class="items-section">
                <h2>Relatório de Vendas Realizadas</h2>
                
                <?php
                 $sql = "select * from vendas ORDER BY data DESC";
                 $seleciona_vendas = mysql_query($sql);
                 
                 if ($seleciona_vendas === FALSE) {
                    // Tratar erro de consulta, se necessário
                    echo "<div class='empty-state'><h3>Erro ao consultar vendas</h3><p>Verifique a conexão com o banco de dados e a tabela 'vendas'.</p></div>";
                 } else if (mysql_num_rows($seleciona_vendas) == 0 ){
                    echo "<div class='empty-state'><h3>Não há nenhuma venda realizada</h3><p>O histórico de vendas está vazio.</p></div>";
                 } else {
                    echo "<p style='margin-bottom: 20px; font-size: 1.1em;'>Aqui estão as vendas realizadas:</p>";
                    echo "<div class='items-grid'>"; // Usando a mesma grid de produtos para exibir as vendas
                    
                    while ($dados = mysql_fetch_object($seleciona_vendas)){
                        $total_fatura += $dados->preco ;
                        
                        // Usando a estrutura de item-card para exibir cada venda
                        echo "<div class='item-card'>";
                        echo "<form action='compras.php' method='post'>";
                        
                        echo "<div class='item-header'>";
                        echo "<h3>" . htmlspecialchars($dados->nome) . "</h3>";
                        echo "</div>";
                        
                        echo "<img src='imagens/" . htmlspecialchars($dados->imagen) . "' alt='" . htmlspecialchars($dados->nome) . "' style='width: 100%; height: 250px; object-fit: cover; display: block;'>";
                        
                        echo "<div class='item-body'>";
                        echo "<p class='item-description'><strong>Descrição:</strong> " . htmlspecialchars($dados->descricao) . "</p>";
                        echo "<p class='item-price'>R$ " . number_format($dados->preco, 2, ',', '.') . "</p>";
                        echo "<p class='item-quantity'><small>ID do Usuário:</small> " . htmlspecialchars($dados->id_usuario) . "</p>";
                        echo "<p class='item-quantity'><small>Data da Venda:</small> " . date('d/m/Y H:i:s', strtotime($dados->data)) . "</p>";
                        echo "</div>";
                        
                        echo "</form>";
                        echo "</div>";
                    }
                    
                    echo "</div>"; // Fecha items-grid
                    
                    echo "<div class='total-faturamento'>";
                    echo "<h3>Valor Total Faturado: R$ " . number_format($total_fatura, 2, ',', '.') . "</h3>";
                    echo "</div>";
                 }
                ?>
            </section>
        </div>
    </main>
</body>
</html>
