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
        $status = "<div class='box'>Produto foi add ao carrinho !</div>";
        }
        else{
        $array_keys = array_keys($_SESSION["shopping_cart"]);
    
       if(in_array($id,$array_keys)) {
        $status = "<div class='box' style='color:red;'>
        Produto ja foi adicionado ao carrinho!</div>";
        }
        else {
        $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
        $status = "<div class='box'>Produto  foi add ao carrinho!</div>";
        }
    
        }
}

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
        <div class="cart_div">
        <a href="cart.php"><img src="carrinho.png" height=50 width=50/>Carrinho<span>
        <?php  
        if(!empty($_SESSION["shopping_cart"])) {
            $cart_count = count(array_keys($_SESSION["shopping_cart"]));   
            echo $cart_count;   }
            ?></span></a>
        </div>
    <header class="header" >
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
                    "<input type='hidden' name='id' value='" . $dados->id . "'>".
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
