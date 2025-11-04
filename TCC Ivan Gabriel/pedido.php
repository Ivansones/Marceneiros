<?php
session_start();
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');

if (!$connect) {
    die("Erro de conexão: " . mysql_connect());
}
$user_id = $_SESSION['user_id'];
$user_cpf = $_SESSION['user_cpf'];
$user_nome = $_SESSION['user_nome'];
$user_email = $_SESSION['user_email'];
$user_cep = $_SESSION['user_cep'];
$user_cidade = $_SESSION['user_cidade'];
$user_telefone = $_SESSION['user_telefone'];
$user_endereco = $_SESSION['user_endereco'];
$user_bairro = $_SESSION['user_bairro'];

if (isset($_POST['enviar'])) {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $descricao = $_POST['descricao'];
    $qual = $_POST['qual'];
    $price = 0;
    $andamento = "nao";
    //Para o item base//
    $sql = "SELECT preco FROM opcoes
            WHERE nome = '$qual'";
    $resposta = mysql_query($sql);
    if ($resposta){
    $dados = mysql_fetch_assoc($resposta);
    if ($dados){    
        $price = $dados['preco'];

        }       
    }

    //Aqui é para os adicionais//
    if (!empty($_POST['adicionas'])){
        foreach($_POST['adicionas'] as $adicional) {
        $sqladicional = "SELECT preco FROM adicionais
                     WHERE nome = '$adicional'";
        $respostaadi = mysql_query($sqladicional);
        if ($respostaadi){
        $dadosadi = mysql_fetch_assoc($respostaadi);
        if ($dadosadi){    
            $price = $price + $dadosadi['preco'];
    
            }       
        }
    }
    }
    $sql = "insert into pedidos(cpf,user_id,nome,email,cep,telefone_celular,cidade,endereco,bairro,data,hora,descricao,preco,andamento)
    values('$user_cpf','$user_id','$user_nome','$user_email','$user_cep','$user_telefone','$user_cidade','$user_endereco','$user_bairro','$data','$hora','$descricao','$price','$andamento')";


    $resultado = mysql_query($sql);

    if($resultado==TRUE)
    {
        echo "<script language ='javascript' type='text/javascript'>
        alert ('O pedido foi enviado com sucesso.');
        window.location.href ='home.php';
        </script>";
    }
    else{
        die("Erro na query: " . mysql_error());
    }

}

?>

