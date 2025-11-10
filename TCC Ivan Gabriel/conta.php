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
            <a href="home.php" class="btn">Home</a>
            <a href="pedido.html" class="btn">Realizar Pedido</a>
            <a href="fale_conosco.html" class="btn">Fale Conosco</a>
            <a href="encomendass.php" class="btn">Encomendas Feitas</a>
            <a href="logout.php" class="btn">logout</a>
        </div>
          
        </div>
    </header>

    <div class="auth-container">
        <div id="corpo_cad">
            <h2 class="auth-title">Atualizar Informações da Conta</h2>
            <?php
            echo "<p style='margin-bottom: 20px; color: #666;'>Aqui estão as informações da sua conta:</p>";
            
            $sql_conta = "select nome,senha,cpf,email,cep,cidade,telefone,endereco,bairro 
                        from usuario where id = '$user_id'";
            $busca = mysql_query($sql_conta);
            if ($busca && mysql_num_rows($busca) > 0){
            $dados = mysql_fetch_object($busca);

            ?>
            <form action="conta.php" method="post">
                <div class="form-grid">
                    <div class="field-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo $dados->nome; ?>">
                    </div>
                    <div class="field-group">
                        <label for="senha">Senha:</label>
                        <input type="text" id="senha" name="senha" value="<?php echo $dados->senha; ?>">
                    </div>
                    <div class="field-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" value="<?php echo $dados->cpf; ?>">
                    </div>
                    <div class="field-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $dados->email; ?>">
                    </div>
                    <div class="field-group">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" value="<?php echo $dados->cep; ?>">
                    </div>
                    <div class="field-group">
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cidade" value="<?php echo $dados->cidade; ?>">
                    </div>
                    <div class="field-group">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" value="<?php echo $dados->telefone; ?>">
                    </div>
                    <div class="field-group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" value="<?php echo $dados->endereco; ?>">
                    </div>
                    <div class="field-group full-width">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" value="<?php echo $dados->bairro; ?>">
                    </div>
                </div>
                <input type="submit" name="atualizar" value="Atualizar">
            </form>

            <?php
        } else {
            echo "<p style='color: red;'>Erro ao buscar seus dados.</p>";
        }
        ?>
        </div>
    </div>
	
</body>
</html>
