<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];
$user_tipo = $_SESSION['user_tipo'];
if (!$connect) {
    die("Erro de conexão: " . mysql_connect());
}

if (isset($_POST['iniciar'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_muda = "UPDATE pedidos SET andamento = 'processando' WHERE pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_muda);
}
if (isset($_POST['cancelar'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_muda = "UPDATE pedidos SET andamento = 'nao' WHERE pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_muda);
}
if (isset($_POST['finalizar'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_muda = "UPDATE pedidos SET andamento = 'finalizado' WHERE pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_muda);
}

if (isset($_POST['voltar'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_muda = "UPDATE pedidos SET andamento = 'processando' WHERE pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_muda);
}

if (isset($_POST['cancelando'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_tira = "delete from pedidos where pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_tira);
}

if (isset($_POST['retirar'])){
    $pedido_id = $_POST['pedido_id'];
    $sql_tira = "delete from pedidos where pedido_id = '$pedido_id'";

    $mudando = mysql_query($sql_tira);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pedidos realizados</title>
    <link rel="icon" href="logo.jpg">
    <link rel="stylesheet" href="estiliza.css">
</head>
<body>
    <header class="header" >
        <div class="logo">
            <img src="logo.jpg" alt="logo">
            <div class="logo-text">
                <strong>Casa da madeira</strong>
                <small>Desde 2017</small>
            </div>
        </div>
<?php
if ($user_tipo == "usuario" ){
        echo "<div class='header-right'>".
            "<a href='pedido.html' class='btn'>Realizar Pedido</a>".
            "<a href='fale_conosco.html' class='btn'>Fale Conosco</a>".
            "<a href='home.php' class='btn'>Home</a>".
            "<a href='logout.php' class='btn'>logout</a>".
            "<a href='cadastro.html' class='btn'>Cadastrar-se</a>";
          echo "</div>";
        }
else{
        echo "<div class='header-right'>".
            "<a href='cadastro_produtos.html' class='btn'>Cadastra produtos</a>".
            "<a href='compras.php' class='btn'>Vendas</a>".
            "<a href='home_adm.php' class='btn'>Home</a>".
            "<a href='logout.php' class='btn'>logout</a>";
          echo "</div>";
}
?>
          
     </div>
    </header>
    <div class="main-container">
        <div class="items-section">
            <h2>
                <?php
                if ($user_tipo == "usuario" ){
                    echo "Meus Pedidos Realizados";
                } else {
                    echo "Pedidos Recebidos";
                }
                ?>
            </h2>
            <div class="items-grid">
    
            <?php
            
            if ($user_tipo == "usuario" ){
                $sql = "SELECT pedido_id,nome,cidade,endereco,bairro,data,hora,descricao,preco,andamento FROM pedidos
                WHERE user_id ='$user_id' ";
                
            
                $seleciona_produtos = mysql_query($sql);
                if (mysql_num_rows($seleciona_produtos) == 0){
                    echo "<div class='empty-state'><h3>Nenhum Pedido Encontrado</h3><p>Você ainda não realizou nenhum pedido.</p></div>";
                }
                else{
                    while ($dados = mysql_fetch_object($seleciona_produtos)){
                        echo "<div class='item-card'>".
                                "<div class='item-header'>".
                                    "<h3>Pedido #". $dados->pedido_id . "</h3>".
                                "</div>".
                                "<div class='item-body'>".
                                    "<p><strong>Descrição:</strong> <span class='item-description'>". $dados->descricao. "</span></p>".
                                    "<p><strong>Preço:</strong> <span class='item-price'>R$ ". number_format($dados->preco, 2, ',', '.') . "</span></p>".
                                    "<p><strong>Data:</strong> ". $dados->data . " às " . $dados->hora . "</p>".
                                    "<p><strong>Endereço:</strong> ". $dados->endereco . ", " . $dados->bairro . " - " . $dados->cidade . "</p>".
                                    "<p><strong>Andamento:</strong> <span class='item-category'>". strtoupper($dados->andamento) . "</span></p>".
                                "</div>".
                                "<div class='item-footer'>".
                                    "<form action='encomendass.php' method='post'>".
                                        "<input type='hidden' name='pedido_id' value='" . $dados->pedido_id . "'>";
                                        if ($dados->andamento == 'nao'){
                                            echo "<input type='submit' name='cancelando' value='Cancelar Pedido' class='btn-order'>";
                                        }
                                    echo "</form>".
                                "</div>".
                            "</div>";
                    }
                }
                }
            else{
                $sql = "SELECT pedido_id,nome,cidade,endereco,bairro,data,hora,descricao,preco,andamento FROM pedidos";
                $seleciona_produtos = mysql_query($sql);
                if (mysql_num_rows($seleciona_produtos) == 0){
                    echo "<div class='empty-state'><h3>Nenhum Pedido Recebido</h3><p>Ainda não há pedidos para processar.</p></div>";
                }
                else{
                    while ($dados = mysql_fetch_object($seleciona_produtos)){
                        $codigo = $dados->pedido_id;
                        echo "<div class='item-card'>".
                                "<div class='item-header'>".
                                    "<h3>Pedido #". $dados->pedido_id . "</h3>".
                                "</div>".
                                "<div class='item-body'>".
                                    "<p><strong>Cliente:</strong> ". $dados->nome . "</p>".
                                    "<p><strong>Descrição:</strong> <span class='item-description'>". $dados->descricao. "</span></p>".
                                    "<p><strong>Preço:</strong> <span class='item-price'>R$ ". number_format($dados->preco, 2, ',', '.') . "</span></p>".
                                    "<p><strong>Data:</strong> ". $dados->data . " às " . $dados->hora . "</p>".
                                    "<p><strong>Endereço:</strong> ". $dados->endereco . ", " . $dados->bairro . " - " . $dados->cidade . "</p>".
                                    "<p><strong>Andamento:</strong> <span class='item-category'>". strtoupper($dados->andamento) . "</span></p>".
                                "</div>".
                                "<div class='item-footer'>".
                                    "<form action='encomendass.php' method='post'>".
                                        "<input type='hidden' name='pedido_id' value='" . $dados->pedido_id . "'>";
                                        if ($dados->andamento == 'nao'){
                                            echo "<input type='submit' name='iniciar' value='Iniciar Processamento' class='btn-order'>";
                                        }
                                        else if ($dados->andamento == 'processando'){
                                            echo "<input type='submit' name='cancelar' value='Cancelar' class='btn-order btn-cancelar-processando'>";
                                            echo "<input type='submit' name='finalizar' value='Finalizar Pedido' class='btn-order'>";
                                        } else if ($dados->andamento == 'finalizado'){
                                            echo "<input type='submit' name='voltar' value='Voltar para Processamento' class='btn-order btn-voltar-processamento'>";
                                            echo "<input type='submit' name='retirar' value='Retirar Pedido' class='btn-order btn-retirar-pedido'>";
                                        }
                                    echo "</form>".
                                "</div>".
                            "</div>";
                    }
                } 
            }
            ?>
            </div>
        </div>
    </div>
</body>
</html>
