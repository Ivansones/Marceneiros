<?php
session_start();

$conectar = mysql_connect('localhost', 'root', '');
if (!$conectar) {
    die('Erro de conexão: ' . mysql_error());
}

$db = mysql_select_db('marcenaria', $conectar);
if (!$db) {
    die('Erro ao selecionar banco: ' . mysql_error());
}

$query = "SELECT * FROM itens ORDER BY id DESC";
$resultado = mysql_query($query, $conectar);

$itens = array();

if ($resultado) {
    while ($item = mysql_fetch_assoc($resultado)) {
        $itens[] = $item;
    }
}

mysql_close($conectar);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Marcenaria</title>
    <link rel="icon" href="logo.jpg">
    <link rel="stylesheet" href="estiliza.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="logo.jpg" alt="logo">
            <div class="logo-text">
                <strong>Casa da madeira</strong>
                <small>Desde 2017</small>
            </div>
        </div>
        
        <div class="header-right">
            <a href="pedido.html" class="btn">Realizar Pedido</a>
            <a href="fale_conosco.html" class="btn">Fale Conosco</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
    </header>

    <main>
        <div class="home-content">
            <h1>Bem-vindo à Marcenaria Artesanal</h1>
            <p>Bem-vindo à Casa da Madeira, veja as diferentes marcenarias feitas por Amilcar Daniel Cesa.
            Também estamos disponíveis para fazer pedidos customizados, dependendo de suas preferências e desejos.</p>

            <section class="items-section">
                <h2>Nossos Produtos</h2>
                
                <?php if (count($itens) > 0): ?>
                    <div class="items-grid">
                        <?php foreach ($itens as $item): ?>
                            <div class="item-card">
                                <div class="item-header">
                                    <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                </div>
                                
                                <?php 
                                // Verifica se a coluna existe (pode ser 'imagen' ou 'imagem')
                                $caminho_imagem = '';
                                if (!empty($item['imagen'])) {
                                    $caminho_imagem = 'imagens/' . $item['imagen'];
                                } elseif (!empty($item['imagem'])) {
                                    $caminho_imagem = 'imagens/' . $item['imagem'];
                                }
                                
                                if ($caminho_imagem && file_exists($caminho_imagem)): 
                                ?>
                                    <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" 
                                         alt="<?php echo htmlspecialchars($item['nome']); ?>"
                                         style="width: 100%; height: 250px; object-fit: cover; display: block;">
                                <?php else: ?>
                                    <div style="width: 100%; height: 250px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                                        <p>Imagem não disponível</p>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="item-body">
                                    <?php if (isset($item['descricao'])): ?>
                                        <p class="item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($item['preco'])): ?>
                                        <p class="item-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($item['categoria'])): ?>
                                        <span class="item-category"><?php echo htmlspecialchars($item['categoria']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="item-footer">
                                    <a href="pedido.php?item_id=<?php echo $item['id']; ?>" class="btn-order">Comprar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Nenhum produto disponível</h3>
                        <p>No momento não há produtos cadastrados. Entre em contato conosco para mais informações.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html
