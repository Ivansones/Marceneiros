<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['excluir'])){
    $id = $_POST['id'];
    $sql_tira = "delete from itens where id = '$id'";
    $mudando = mysql_query($sql_tira);
    
    if ($mudando) {
        echo "<script>alert('Produto excluído com sucesso!'); window.location.href='home_adm.php';</script>";
    }
}

if (isset($_POST['atualizar'])){
    $id = $_POST['id'];
    $nova_quantidade = $_POST['quantidade'];

    $sql_atualiza = "UPDATE itens SET quantidade = '$nova_quantidade' WHERE id = '$id'";
    $resultado = mysql_query($sql_atualiza);

    if ($resultado) {
        echo "<script>alert('Quantidade atualizada com sucesso!'); window.location.href='home_adm.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar quantidade!');</script>";
    }
}

// Busca os produtos
$sql_produto = "select id,nome,descricao,preco,quantidade,imagen from itens ORDER BY id DESC";
$seleciona_produto = mysql_query($sql_produto);

$itens = array();
if ($seleciona_produto) {
    while ($item = mysql_fetch_assoc($seleciona_produto)) {
        $itens[] = $item;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Marcineiros</title>
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
            <a href="cadastro_produto.html" class="btn">Cadastro de produtos</a>
            <a href="compras.php" class="btn">Vendas</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
    </header>

    <main>
        <div class="home-content">
            <h1>Painel de Administração</h1>
            <p>Administrador, muito bem-vindo! Gerencie seus produtos abaixo.</p>

            <section class="items-section">
                <h2>Gerenciar Produtos</h2>
                
                <?php if (count($itens) > 0): ?>
                    <div class="items-grid">
                        <?php foreach ($itens as $item): ?>
                            <div class="item-card">
                                <div class="item-header">
                                    <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                </div>
                                
                                <?php 
                                $caminho_imagem = '';
                                if (!empty($item['imagen'])) {
                                    $caminho_imagem = 'imagens/' . $item['imagen'];
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
                                    <p class="item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                    <p class="item-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                </div>
                                
                                <div class="item-footer">
                                    <!-- Formulário de Atualização de Quantidade -->
                                    <form action="home_adm.php" method="POST" class="quantity-form" style="margin-bottom: 10px;">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <div class="quantity-control">
                                            <label for="quantidade_<?php echo $item['id']; ?>" class="quantity-label">Quantidade:</label>
                                            <input type="number" 
                                                   id="quantidade_<?php echo $item['id']; ?>" 
                                                   name="quantidade" 
                                                   value="<?php echo isset($item['quantidade']) ? intval($item['quantidade']) : 0; ?>" 
                                                   min="0" 
                                                   class="quantity-input">
                                            <button type="submit" name="atualizar" class="btn btn-edit-quantity">Atualizar</button>
                                        </div>
                                    </form>
                                    
                                    <!-- Formulário de Exclusão -->
                                    <form action="home_adm.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="excluir" class="btn-delete">Excluir Produto</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <h3>Nenhum produto disponível</h3>
                        <p>Não há nenhum produto cadastrado no momento. Cadastre novos produtos para começar.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>
