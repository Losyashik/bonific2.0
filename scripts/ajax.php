<?php

$link = mysqli_connect('localhost', 'root', '', 'diplom');

$result = $link->query("SELECT * FROM product WHERE id_type = " . $_POST['type']);
if ($result and $result->num_rows > 0) {
    for ($data = []; $row = $result->fetch_assoc(); $data[] = $row);
    $result = "";
    foreach ($data as $elem) {
        $result .= '
        <div class="con_item">
            <img src="'.$elem['src'].'" alt="'.$elem['name'].'">
            <h1>'.$elem['name'].'</h1>';
            if($elem['id_type']==1){
                $result.=' 
                <div class="check">
                    <span class="left check_on check_price" data-size="35" data-price="'.$elem['price'].'">35 см</span>
                    <span class="right check_price" data-size="40" data-price="'.$elem['dbl_price'].'">40 см</span>
                </div>';
            }
            $result.=   
            '<div class="price pizza">'.$elem['price'].'</div>
            <a class="submit" data-id="'.$elem['id'].'" data-size="35" data-price="'.$elem['price'].'">
                <h2>В корзину</h2>
            </a>
        </div>';
    }
    echo $result;
} else {
    echo '<div class="con_item">
            <h1>Товар скоро появится на сайте</h1>
          </div>';
}
