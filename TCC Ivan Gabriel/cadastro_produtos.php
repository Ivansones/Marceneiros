<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');


if (isset($_POST['cadastrar'])){
    $id        = $_POST['id'];
    $nome      = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco     = $_POST['preco'];
    $quantidade     = $_POST['quantidade'];
    $foto     = $_FILES['foto'];

    $diretorio = "imagens/";

    $extensao = strtolower(substr($_FILES['foto']['name'], -4));
    $novo_nome = md5(time().$extensao);
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome );

    $sql = "insert into itens(id,nome,descricao,preco,quantidade,imagen)
            values ('$id','$nome','$descricao','$preco','$quantidade','$novo_nome')";
        
    $resultado = mysql_query($sql);

    if($resultado==TRUE){
        echo "Foi cadastrado com sucesso";
    }
    else{
        echo "Deu erro";
    }
}

?>