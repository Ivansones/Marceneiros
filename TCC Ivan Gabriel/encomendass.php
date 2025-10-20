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

if (isset($_POST['cancelando'])){
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
            "<a href='cadastra_produtos.html' class='btn'>Cadastra produtos</a>".
            "<a href='home_adm.html' class='btn'>Home</a>".
            "<a href='logout.php' class='btn'>logout</a>".
            "<a href='cadastro.html' class='btn'>Cadastrar-se</a>";
          echo "</div>";
}
?>
          
     </div>
    </header>
    <div class="main-container">
    
    <?php
    
if ($user_tipo == "usuario" ){
    $sql = "SELECT pedido_id,nome,cidade,endereco,bairro,data,hora,descricao,preco,andamento FROM pedidos
    WHERE user_id ='$user_id' ";
    

    $seleciona_produtos = mysql_query($sql);
    if (mysql_num_rows($seleciona_produtos) == 0){
        echo "Voce não tem nenhum pedido";
    }
    else{
        echo "Aqui estão os pedidos realizados";
        while ($dados = mysql_fetch_object($seleciona_produtos)){
            echo "<form action='encomendass.php' method='post'>".
                 "Cidade       : ". $dados->cidade   . "<br>".
                 "Endereço     : ". $dados->endereco . "<br>".
                 "Bairro       : ". $dados->bairro   . "<br>".
                 "Data         : ". $dados->data     . "<br>".
                 "Hora         : ". $dados->hora     . "<br>".
                 "Descriçao    : ". $dados->descricao. "<br>".
                 "preco        : ". $dados->preco    . "<br>".
                 "Andamento    : ". $dados->andamento. "<br>".
                 "<input type='hidden' name='pedido_id' value='" . $dados->pedido_id . "'>";
                 if ($dados->andamento == 'nao'){
                    echo "<input type='submit' name='cancelando' value='cancelar'>";
                 }
                 echo "</form>";
        }
    }
    }
else{
    $sql = "SELECT pedido_id,nome,cidade,endereco,bairro,data,hora,descricao,preco,andamento FROM pedidos";
    $seleciona_produtos = mysql_query($sql);
    if (mysql_num_rows($seleciona_produtos) == 0){
        echo "Nenhum pedidos foi enviado";
    }
    else{
        echo "Aqui estão os pedidos que foram mandados";
        while ($dados = mysql_fetch_object($seleciona_produtos)){
            $codigo = $dados->pedido_id;
            echo "<form action='encomendass.php' method='post'>".
                 "Nome         : ". $dados->nome   . "<br>".
                 "Cidade       : ". $dados->cidade   . "<br>".
                 "Endereço     : ". $dados->endereco . "<br>".
                 "Bairro       : ". $dados->bairro   . "<br>".
                 "Data         : ". $dados->data     . "<br>".
                 "Hora         : ". $dados->hora     . "<br>".
                 "Descriçao    : ". $dados->descricao. "<br>".
                 "preco        : ". $dados->preco    . "<br>".
                 "Andamento    : ". $dados->andamento. "<br>".
                 "<input type='hidden' name='pedido_id' value='" . $dados->pedido_id . "'>";
                 if ($dados->andamento == 'nao'){
                    echo "<input type='submit' name='iniciar' value='Iniciar'>";
                 }
                 else if ($dados->andamento == 'processando'){
                    echo "<input type='submit' name='cancelar' value='cancelar'>";
                    echo "<input type='submit' name='finalizar' value='finalizar'>";
                 }
                 echo "</form>";
        }
    } 
}
?>
</body>
</html>
