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
                <strong>Loja de maçonaria</strong>
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
    <form action="compras.php" method="POST">
    <label for="user_id">Buscar vendas por ID do usuário:</label>
    <input type="text" name="user_id" id="user_id" placeholder="Digite o ID do usuário" required>
    <button type="submit">Buscar</button>
    </form>
<?php
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    if (!empty($user_id)) {
    $sql = "SELECT * FROM vendas WHERE id_usuario = '$user_id'";
    $seleciona_venda_especifica = mysql_query($sql);
    $sql_quem = "select nome from usuario where id = '$user_id'";
    $quem = mysql_query($sql_quem);
    if (mysql_num_rows($quem) == 0){
        echo "Esta conta não existe";
    }else{
        if (mysql_num_rows($seleciona_venda_especifica) == 0){
            echo "Essa conta não realizou nenhuma compra";
    }   else{
        $nome = mysql_fetch_object($quem);
        echo "Aqui estão as vendas realizadas do usuario ".$nome->nome;
        while ($dados = mysql_fetch_object($seleciona_venda_especifica)){
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
    
        } 
    }else {
    echo "<p>Por favor, insira o ID de um usuário para buscar suas vendas.</p>";
     $sql = "select * from vendas";
    
?>
<?php
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
}
 echo " O valor total faturado das vendas é ".$total_fatura;
?>


</body>
</html>
