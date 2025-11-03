<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();

$user_id = $_SESSION['user_id'];


if (isset($_POST['excluir'])){
    $id = $_POST['id'];
    $sql_tira = "delete from itens where id = '$id'";

    $mudando = mysql_query($sql_tira);
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
            <a href="cadastro_produtos.html" class="btn">Cadastro de produtos</a>
            <a href="compras.php" class="btn">Vendas</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
          
        </div>
    </header>
    <main>
        <p>
            Admistrado muito bem vindo
        </p>
        <?php
        $sql_produto = "select id,nome,descricao,preco,quantidade,imagen from itens";

        $seleciona_produto = mysql_query($sql_produto);

        if (mysql_num_rows($seleciona_produto) == 0){
            echo "Não ha nenhum produto disponivel no momento";
        }
        else {
            while ($dados = mysql_fetch_object($seleciona_produto)){
                echo "<form action='home_adm.php' method='post'>".
                    "Nome       : ". $dados->nome .      "<br>".
                    "Descrição  : ". $dados->descricao . "<br>".
                    "Preço      : ". $dados->preco . "<br>".
                    "Quantidade : <input type='number' name='quantidade' value='". $dados->quantidade ."' min='0'><br>".
                    "<img src='imagens/" . $dados->imagen . "'height='100' width='150' />".
                    "<input type='hidden' name='id' value='" . $dados->id . "'>".
                    "<input type='submit' name='excluir' value='excluir'>".
                    "<input type='submit' name='atualizar' value='atualizar quantidade'>";
                echo "</form>";
            }
        }
        ?>
    </main>

</body>

</html>
