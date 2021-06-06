<?php $link = mysqli_connect('localhost', 'root', '', 'diplom'); ?>

<!DOCTYPE html>

<html lang="ru">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="img/ico/ico.png" type="image/jpg">
    <link rel="stylesheet" href="styles/style.css">

    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery.maskedinput.js"></script>
    <script src="scripts/ajax.js"></script>


    <script type="text/javascript">
        localStorage.clear()
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
        for ($data = []; $row = $result->fetch_assoc(); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
            $result .= '
                <div class="slaid">
                    <img src="' . $elem['src'] . '" alt="">
                </div>
            ';
        }
        ?>
        <?= $result ?>
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
        <div class="information_conteiner">
            <div class="fa">
                <h2>Мы в социальных сетях</h2>
                <ul>
                    <li><a href="#"><img src="img/ico/vk.png" alt=""></a></li>
                    <li><a href="#"><img src="img/ico/odkl.png" alt=""></a></li>
                    <li><a href="#"><img src="img/ico/twit.png" alt=""></a></li>
                    <li><a href="#"><img src="img/ico/inst.png" alt=""></a></li>
                </ul>
            </div>
            <div class="contact">
                <ul>
                    <li>г. Нижний новгород ул.Пятигорская 7</li>
                    <li></li>
                    <li>Bonific@bk.ru</li>
                    <li>+49370457080</li>
                </ul>
            </div>
            <div class="map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A9581ffe294cfc2610d775c3f24bc30b6d983489b02f45c9e109b050a4d264a1c&amp;width=100%25&amp;height=250&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
        </div>
        <div class="cop" style="text-align: center; color:#999">© Все права защищены</div>
    </footer>

    <div class="modal_window" id="basket">
        <div class="hiden_block" data="basket"></div>
        <img src="img/form_fon.png" alt="" class="fon">
        <form method="post" class="basket">
            <div class="basket__products">
                <div class="products"></div>
                <div class="final_price">
                    <span>Итого к оплате:</span>
                    <span class="output_final_prise">0</span>
                </div>
                <input type="submit" class='next' value="Оформить заказ">
            </div>

            <div class="basket__information">
                <h2>Контактная информация</h2>
                <h4>Форма обращения</h4>
                <input required type="text" name="name">
                <h4>Адрес</h4>
                <input required type="text" name="address">
                <h4>Телефон</h4>
                <input required type="text" id="phone" name="phone">
                <div class="final_price">
                    <span>Итого к оплате:</span>
                    <span class="output_final_prise">0</span>
                </div>
                <h4>Способ оплаты</h4>
                <div class="payment">
                    <label><input type="radio" checked name="payment" value="0">Наличными</label>
                    <label><input type="radio" name="payment" value='1'id="">Картой</label>
                </div>
                <div class="navigation">
                    <input type="submit" id='back' onclick="event.preventDefault();" value="Назад">
                    <input type="submit" id="add_order" value="Оформить заказ">
                </div>
            </div>
        </form>
    </div>
    <div class="modal_window" id="product">
        <div class="hiden_block" data="product"></div>
        <img src="img/form_fon.png" alt="" class="fon">
        <div class="product">
            
        </div>
    </div>
    <div class="compleat_modal">
        <h2>Ваш заказ принят, ожидайте доставки</h2>
        <button onclick="$(event.currentTarget).parent().hide()">ОК</button>
    </div>
    <script src="scripts/open-modal.js"></script>
    <script>
        $("#phone").click(function(){
            $(this).setCursorPosition(2);
        }).mask("8(999) 999-99 99");
        $('.basket').submit(event=>{
            event.preventDefault();
            dataForm = $('.basket').serializeArray();
            data = {}
            dataForm.forEach(element => {
                data[element['name']] = element['value'];
            });
            dataForm = data;
            $.ajax({
                url:'scripts/add_order.php',
                type:'post',
                data:{
                    products:dataBasket,
                    info:dataForm
                },
                success: text=>{
                    $('.compleat_modal h2').html(text);
                    $('.compleat_modal').show();
                    $('#basket').hide()
                    $("#back").parent().parent().hide();
                    $("#back").parent().parent().prev().show();
                    dataBasket={};
                    $('.output_final_prise').html(finalPrice(dataBasket)+" ₽")
                    localStorage.counter = 0;
                    counter();
                    ajaxBasket(dataBasket);
                    
                }
            })
            console.log(dataForm)
        })
        $('.nav_item').click(event => {
            $('.nav_item').removeClass('selected');
            $(event.currentTarget).addClass('selected');
            value = $(event.currentTarget).data('value');
            updateContent(value, 'scripts/ajax.php');
            $('body,html').animate({
                scrollTop: $('.conteiner').offset().top - 100
            }, 500);
        })
    </script>
</body>

</html>