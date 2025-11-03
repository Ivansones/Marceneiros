<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();
$user_id = $_SESSION['user_id'];




if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];

    $sql_check = "select id from usuario 
                  where nome = '$nome' and senha = '$senha' ";
    $check = mysql_query($sql_check);
    if (mysql_num_rows($check) > 0) {
            echo "<script>alert('Já existe um usuário com esse nome e senha!');</script>";
    }else {
         $sql_update = "UPDATE usuario SET nome = '$nome',senha = '$senha',cpf = '$cpf',email = '$email',cep = '$cep',
            cidade = '$cidade',telefone = '$telefone',endereco = '$endereco',bairro = '$bairro'
            WHERE id = '$user_id'";

        $resultado = mysql_query($sql_update);
        if ($resultado) {
            echo "<script>alert('Informações atualizadas com sucesso!'); window.location.href='conta.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar suas informações!');</script>";
        }
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Conta</title>
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
            <a href="home.php" class="btn">Sua conta</a>
            <a href="pedido.html" class="btn">Realizar Pedido</a>
            <a href="fale_conosco.html" class="btn">Fale Conosco</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="cadastro.html" class="btn">Cadastrar-se</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
          
        </div>
    </header>
    <?php
    echo "Aqui estão as informações da sua conta:";
    
    $sql_conta = "select nome,senha,cpf,email,cep,cidade,telefone,endereco,bairro 
                from usuario where id = '$user_id'";
    $busca = mysql_query($sql_conta);
    if ($busca && mysql_num_rows($busca) > 0){
    $dados = mysql_fetch_object($busca);

    ?>
    <form action="conta.php" method="post">
        Nome: <input type="text" name="nome" value="<?php echo $dados->nome; ?>"><br>
        Senha: <input type="text" name="senha" value="<?php echo $dados->senha; ?>"><br>
        CPF: <input type="text" name="cpf" value="<?php echo $dados->cpf; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $dados->email; ?>"><br>
        CEP: <input type="text" name="cep" value="<?php echo $dados->cep; ?>"><br>
        Cidade: <input type="text" name="cidade" value="<?php echo $dados->cidade; ?>"><br>
        Telefone: <input type="text" name="telefone" value="<?php echo $dados->telefone; ?>"><br>
        Endereço: <input type="text" name="endereco" value="<?php echo $dados->endereco; ?>"><br>
        Bairro: <input type="text" name="bairro" value="<?php echo $dados->bairro; ?>"><br><br>

        <input type="submit" name="atualizar" value="Atualizar">
    </form>

    <?php
} else {
    echo "Erro ao buscar seus dados.";
}
?>

</body>
</html>