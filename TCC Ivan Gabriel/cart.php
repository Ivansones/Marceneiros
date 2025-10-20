<?php
$connect = mysql_connect('localhost','root','');
$db = mysql_select_db('marcenaria');
session_start();
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove")
{
  if(!empty($_SESSION["shopping_cart"])) {
    foreach($_SESSION["shopping_cart"] as $key => $value) {
      if($_POST["id"] == $key){
      unset($_SESSION["shopping_cart"][$key]);
      $status = "<div class='box' style='color:red;'>
         Produto foi removido do carrinho !</div>";
      }
      if(empty($_SESSION["shopping_cart"]))
         unset($_SESSION["shopping_cart"]);
    }
  }
}

if (isset($_POST["comprar"])){
    $sql = "insert into vendas (id,nome,descricao,preco,imagen) 
            values ("
}
?>
<HTML>
<HEAD>
 <TITLE>Carrinho Compras </TITLE>
  <link rel="stylesheet" href="estilo.css">
</HEAD>
<BODY>

<a href="home.php">voltar</a>
<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){

?>
    <table class="table">
        <thead>
            <tr>
                <td>Nome</td>
                <td>Descricao</td>
                <td>Preco</td>
                <td>Imagen</td>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($_SESSION["shopping_cart"] as $key => $product){
    ?>
        <tr>
            <td><?php echo $product["nome"]; ?></td>
            <td><?php echo $product["descricao"]; ?></td>
            <td><?php echo number_format($product["preco"],2,',','.'); ?></td>
            <td><img src="imagens/<?php echo $product["imagen"]; ?>" height="50" width="75"></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="codigo" value="<?php echo $key; ?>" />
                    <input type="hidden" name="action" value="remove" />
                    <button type="submit" class="remove">Remover Item</button>
                </form>
            </td>
        </tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="5" align="right">
            </td>
    </tr>
    </tbody>
</table>
  <?php
}else{
	echo "<h3>Seu carrinho est� vazio !</h3>";
	}
?>
</div>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>
<form action="cart.php" method="submit">
    <input type="submit" name="comprar" id="comprar">;
</form>

</BODY>
</HTML>
