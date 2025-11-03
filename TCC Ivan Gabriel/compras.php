<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();
$fatura_inicial = 0;
$total_fatura = 0 ;
?>
<!DOCTYPE html>
<html lang="en">
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
        
        </div>
    </header>
<?php
 $sql = "select * from vendas";
 $seleciona_vendas = mysql_query($sql);
 if (mysql_num_rows($seleciona_vendas) == 0 ){
    echo "Não ha nenhuma venda realizada";
 }else {
    echo "Aqui estão as vendas realizadas:";
    while ($dados = mysql_fetch_object($seleciona_vendas)){
        echo "<form action='compras.php' method='post'>".
                 "Nomes        : ". $dados->nome   . "<br>".
                 "Descrição    : ". $dados->descricao . "<br>".
                 "Preço        : ". $dados->preco   . "<br>".
                 "Id do usuario: ". $dados->id_usuario   . "<br>".
                 "Data         : ". $dados->data   . "<br>".
                 "<img src='imagens/" . $dados->imagen . "'height='100' width='150' />";
                 echo "</form>";
                  $total_fatura += $dados->preco ;

    }
 }

 echo " O valor total faturado das vendas é ".$total_fatura;
?>


</body>
</html>