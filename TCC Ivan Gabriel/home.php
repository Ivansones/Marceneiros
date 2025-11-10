<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];
$user_tipo = $_SESSION['user_tipo'];

if (isset($_POST['id']) && $_POST['id']!=""){
    $id = $_POST['id'];
    $resultado = mysql_query("select nome,descricao,preco,quantidade,imagen from itens where id = '$id'");
    $row = mysql_fetch_assoc($resultado);
    $nome = $row['nome'];
    $descricao = $row['descricao'];
    $preco = $row['preco'];
    $quantidade = $row['quantidade'];
    $imagen = $row['imagen'];

    $cartArray = array($id=>array('id'=>$id,'nome'=>$nome,'descricao'=>$descricao,'preco'=>$preco,'quantidade'=>$quantidade,'imagen'=>$imagen));

    if(empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'>Produto foi adicionados ao carrinho !</div>";
        }
        else{
        $array_keys = array_keys($_SESSION["shopping_cart"]);
    
       if(in_array($id,$array_keys)) {
        $status = "<div class='box' style='color:red;'>
        Produto ja foi adicionado ao carrinho!</div>";
        }
        else {
        $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
        $status = "<div class='box'>Produto  foi adicionado ao carrinho!</div>";
        }
    
        }
}

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
<div class="cart_div">
    <a href="cart.php" class="cart-link">
        <img src="carrinho.png" alt="Carrinho" class="cart-icon">
        <span class="cart-text">Carrinho</span>
        <?php if(!empty($_SESSION["shopping_cart"])): ?>
            <span class="cart-count"><?php echo count($_SESSION["shopping_cart"]); ?></span>
        <?php else: ?>
            <span class="cart-count" style="background-color: #777;">0</span>
        <?php endif; ?>
    </a>
</div>

    <header class="header">
        <div class="logo">
            <img src="logo.jpg" alt="logo">
            <div class="logo-text">
                <strong>Casa da madeira</strong>
                <small>Desde 2017</small>
            </div>
        </div>
        
        <div class="header-right">
            <a href="conta.php" class="btn">Sua conta</a>
            <a href="pedido.html" class="btn">Realizar Pedido</a>
            <a href="fale_conosco.html" class="btn">Fale Conosco</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="logout.php" class="btn">logout</a>
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
                                    
                                    <div class="item-footer">
                                        <input type="hidden" name="id" value="<?php echo $dados->id; ?>">
                                        <?php if ($dados->quantidade == 0): ?>
                                            <button type="button" class="btn-order" disabled style="background-color: #ccc; cursor: not-allowed;">
                                                Produto indisponível
                                            </button>
                                        <?php else: ?>
                                            <input type="submit" name="comprar" value="Adicionar ao Carrinho" class="btn-order">
                                        <?php endif; ?>
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
