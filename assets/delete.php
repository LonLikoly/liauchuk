<?php
session_start();
require_once ($_SERVER["DOCUMENT_ROOT"]."/assets/class/Database.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/assets/class/Product.php");
if ($_GET['id'] && $_SESSION['user']['admin']==1) 
{
    $product = new Product(addslashes($_GET['id'])); //создание объекта продукта
    $product->deleteData();
}
?>
<script>
    window.location.reload();
    window.close();

</script>
