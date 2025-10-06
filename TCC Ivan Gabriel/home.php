<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcineiros</title>
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
        
        <div class="header-right">
            <a href="pedido.html" class="btn">Realizar Pedido</a>
            <a href="fale_conosco.html" class="btn">Fale Conosco</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="cadastro.html" class="btn">Cadastrar-se</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
          
        </div>
    </header>
    <main>
        <p>
            Bem-vindo à Casa da Madeira, veja as diferentes marcenarias feitas por Amilcar Daniel Cesa.
            Também estamos disponíveis para fazer pedidos customizados, dependendo de suas preferências e desejos.
        </p>
        <?php
        $sql_produto = "select id,nome,descricao,preco,quantidade,imagen from itens";

        $seleciona_produto = mysql_query($sql_produto);

        if (mysql_num_rows($seleciona_produto) == 0){
            echo "Não ha nenhum produto disponivel no momento";
        }
        else {
            while ($dados = mysql_fetch_object($seleciona_produto)){
                echo "<form action='home.php' method='post'>".
                    "Nome       : ". $dados->nome .      "<br>".
                    "Descrição  : ". $dados->descricao . "<br>".
                    "Preço      : ". $dados->preco . "<br>".
                    "Quantidade : ". $dados->quantidade . "<br>".
                    "<img src='imagens/" . $dados->imagen . "'height='100' width='150' />";
                    if ($dados->quantidade == 0){
                        echo "Produto indisponivel";
                    }
                    else{
                        echo "<input type='submit' name='comprar' value='comprar'>";
                    }
                echo "</form>";
            }
        }
        ?>
    </main>

</body>

</html>
