<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcineiros</title>
    <link rel="icon" href="logo.jpg">
    <link rel="stylesheet" href="estiliza.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="logo.jpg" alt="logo">
            <div class="logo-text">
                <strong>Casa da madeira</strong>
                <small>Desde 2017</small>
            </div>
        </div>
        
        <div class="header-right">
            <a href="cadastro_no_log.html" class="btn">Cadastra-se</a>
            <a href="login_no_log.html" class="btn">Login</a>
        </div>
    </header>

    <main>
        <div class="home-content">
            <?php if(isset($status)): ?>
                <?php echo $status; ?>
            <?php endif; ?>
            
            <h1>Bem-vindo à Marcenaria Artesanal</h1>
            <p>
                Bem-vindo à Casa da Madeira, veja as diferentes marcenarias feitas por Amilcar Daniel Cesa.
                Também estamos disponíveis para fazer pedidos customizados, dependendo de suas preferências e desejos.
            </p>

            <section class="items-section">
                <h2>Nossos Produtos</h2>
                
                <?php
                $sql_produto = "select id,nome,descricao,preco,quantidade,imagen from itens ORDER BY id DESC";
                $seleciona_produto = mysql_query($sql_produto);

                if (mysql_num_rows($seleciona_produto) == 0):
                ?>
                    <div class="empty-state">
                        <h3>Nenhum produto disponível</h3>
                        <p>Não há nenhum produto disponível no momento. Entre em contato conosco para mais informações.</p>
                    </div>
                <?php else: ?>
                    <div class="items-grid">
                        <?php while ($dados = mysql_fetch_object($seleciona_produto)): ?>
                            <div class="item-card">
                                <form action="home.php" method="post">
                                    <div class="item-header">
                                        <h3><?php echo htmlspecialchars($dados->nome); ?></h3>
                                    </div>
                                    
                                    <?php 
                                    $caminho_imagem = 'imagens/' . $dados->imagen;
                                    if ($dados->imagen && file_exists($caminho_imagem)): 
                                    ?>
                                        <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" 
                                             alt="<?php echo htmlspecialchars($dados->nome); ?>"
                                             style="width: 100%; height: 250px; object-fit: cover; display: block;">
                                    <?php else: ?>
                                        <div style="width: 100%; height: 250px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                                            <p>Imagem não disponível</p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="item-body">
                                        <p class="item-description"><?php echo htmlspecialchars($dados->descricao); ?></p>
                                        <p class="item-price">R$ <?php echo number_format($dados->preco, 2, ',', '.'); ?></p>
                                        <p class="item-quantity">
                                            <small>Quantidade disponível:</small> 
                                            <span class="quantity-value"><?php echo intval($dados->quantidade); ?></span>
                                        </p>
                                    </div>

                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>
