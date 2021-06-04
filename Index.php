<?php $link = mysqli_connect('localhost', 'root', '', 'diplom'); ?>

<!DOCTYPE html>

<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="img/ico/ico.png" type="image/jpg">
    <link rel="stylesheet" href="styles/style.css">

    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/ajax.js"></script>


    <script type="text/javascript">
        localStorage.clear()
        window.onload = function() {
            updateContent(1, 'scripts/ajax.php');
        }
        if(typeof dataBasket === 'undefined' && localStorage.getItem('basket')===null){
            var dataBasket = {};
            localStorage.counter = 0;
        }
        else if(localStorage.getItem('basket') !== null){
            var dataBasket = JSON.parse(localStorage.getItem('basket'));
        }
        function adimin_on() {
            if (event.shiftKey && event.ctrlKey) {
                event.preventDefault()
                window.open('admin.php');
            }
        }
    </script>


    <title>Bonific</title>


</head>

<body>

    <div class="flex">
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt="логотип"></a>
        </div>
        <div class="button_block">
            <img class="burger" src="img/ico/burger.png" alt="меню">
        </div>
    </div>

    <div class="slider">
        <?php
        $result = $link->query("SELECT src as src FROM baner WHERE NOT src = 'NULL' ORDER BY `id` ASC");
        echo $link->error;
        for($data = [];$row = $result->fetch_assoc();$data[]=$row);
        $result='';
        foreach($data as $elem){
            $result.='
                <div class="slaid">
                    <img src="'.$elem['src'].'" alt="">
                </div>
            ';
        }
        ?>
        <?= $result?>
    </div>


    <script src="scripts/slick.min.js"></script>
    <script src="scripts/slaider.js"></script>

    <nav class="nav">
        <div class="logo"><img src="img/logo.png" alt=""></div>
        <ul>
            <li>
                <a class="nav_item selected" data-value="1"><img src="img/ico/pizza.png" alt=""><span>Пицца<span></span></a>
            </li>
            <li>
                <a class="nav_item" data-value="2"><img src="img/ico/zakuski.png" alt="">Закуски</a>
            </li>
            <li>
                <a class="nav_item" data-value="3"><img src="img/ico/desert.png" alt="">Дисерты</a>
            </li>
            <li>
                <a class="nav_item" data-value="4"><img src="img/ico/napitok.png" alt="">Напитки</a>
            </li>
            <li>
                <a class="nav_item" data-value="5"><img src="img/ico/sous.png" alt="">Соусы</a>
            </li>
        </ul>
        <div class="basket">
            <div data-id="basket" class="open_basket">
                <img src="img/ico/korzina.png" class="open_modal_window" data-id="basket" alt="корзина">
                <div class='count'>0</div>
            </div>
        </div>
    </nav>

    <div class="conteiner"></div>

    <footer>
        <div>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <dim class="map"></dim>
        </div>
        <div>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <dim class="map">

            </dim>
        </div>
    </footer>
    
    <div class="modal_window" id="basket">
        <div class="hiden_block" data="basket"></div>
        <img src="img/form_fon.png" alt="" class="fon">
        <form action="" method="post" class="basket">
            <div class="basket__products" style="display: none;">
                <div class="products"></div>
                <input type="submit" value="Оформить заказ">
            </div>

            <div class="basket__information" style="display: block;">
                <h2>Контактная информация</h2>
                <h4>Форма обращения</h4>
                <input type="text" name="fullName">
                <h4>Адрес</h4>
                <input type="text" name="addres">
                <h4>Телефон</h4>
                <input type="tel" name="phone">
                <div class="final_price">
                    <span>Итого к оплате:</span>
                    <span class="output_final_prise">0</span>
                </div>
                <h4>Способ оплаты</h4>
                <div class="payment">
                    <label><input type="radio" name="payment" id="">Наличными</label>
                    <label><input type="radio" name="payment" id="">Картой</label>
                </div>
                <div class="navigation">
                    <input type="submit" id='back' onclick="event.preventDefault();" value="Назад">
                    <input type="submit" name="add_order" value="Оформить заказ">
                </div>
            </div>
        </form>
    </div>

    <script src="scripts/open-modal.js"></script>
    <script>
        $('.nav_item').click(event => {
            $('.nav_item').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            value = $(event.currentTarget).data('value');
            updateContent(value, 'scripts/ajax.php');
        })
        
    </script>
</body>

</html>