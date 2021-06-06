<?php
$link = mysqli_connect('localhost','root','','diplom');
$info = $_POST['info'];
$result = $link->query("INSERT INTO data_user(name, number, address, payment) VALUES('".$info['name']."','".$info['phone']."','".$info['address']."','".$info['payment']."')");
if ($result){
    $id = $link->insert_id;
    foreach($_POST['products'] as $product){
        $result = $link->query("INSERT INTO `basket`(`data_user_id`, `product_id`, `size`, `count`) VALUES ($id,'".$product['id']."','".$product['size']."','".$product['count']."')");
    }
    if($result){
        echo"Ваш заказ принят, ожидайте доставки".$link->error;
    }
    else{
        echo "Ошибка добавления товара";
    }
}
else{
    echo "Ошибка добавления данных клиента";
}
?>