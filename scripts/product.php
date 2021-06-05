<?php
    $id = $_POST['product'];
    $link = mysqli_connect('localhost', 'root', '', 'diplom');
    $data = $link->query("SELECT * FROM product WHERE id = $id")->fetch_assoc();
    echo'
        <div class="product__info">
            <div class="product__img">
                <img src="'.$data['src'].'" alt="">
            </div>
            <div class="product__description">
                <h2>'.$data['name'].'</h2>
                <div>'.$data['description'].'</div>
            </div>
        </div>
        <div class="product__price">';
        if($data['id_type']==1){
            echo'
            <div class="check">
                <span class="left check_on check_price" data-size="35" data-price="'.$data['price'].'">35 см</span>
                <span class="right check_price" data-size="40" data-price="'.$data['dbl_price'].'">40 см</span>
            </div>
            <div class="price pizza">'.$data['price'].' ₽</div>
        </div>
        <a class="submit" data-price="'.$data['price'].'" data-id="'.$data['id'].'" data-size="35">
            <h2>В корзину</h2>
        </a>
            ';
        } 
        else{
            echo'
            <div class="price pizza">'.$data['price'].' ₽</div>
        </div>
        <a class="submit" data-price="'.$data['price'].'" data-id="'.$data['id'].'">
            <h2>В корзину</h2>
        </a>
            ';
        }