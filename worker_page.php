<?php
$link = mysqli_connect('localhost','root','','diplom'); 
session_start();

if (isset($_POST['go_log'])) {
	$log = $_POST['login'];
	$pasw = $_POST['pas'];
	$lo = 'admin';
	$pa = '$2y$10$ec9HoTGq2guLuY234kD3NebIPFyoEQB4SMYRtyYH2NMJiiJAU0RqW';
	if ($log == $lo and password_verify($pasw, $pa)) {
		$_SESSION['worker'] = time();
	}
	header('Location:worker_page.php');
}

if (isset($_SESSION['worker'])) {
	if (time() - $_SESSION['worker'] < 1200) {
		$_SESSION['worker'] = time();
	} else {
		unset($_SESSION['worker']);
		header('Location:worker_page.php');
	}
} else {
	echo ("
	<!DOCTYPE html>
	<html lang='ru'>
	<head>
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<title>Document</title>
		<link rel='stylesheet' href='styles/style.css'>
	</head>
	<body>
		<div class='modal_window login' id='login'>
			<div class='hiden_block' data='login'></div>
			<img src='img/form_fon.png' class='fon'>
			<form action='' class='login' method='POST'>
				<h2>Авторизация</h2>
				<h4>Логин</h4>
				<input name='login' type='text'>
				<h4>Пароль</h4>
				<input name='pas' type='password'>
				<input class='formknop' type='submit' value='Войти' name='go_log'>
			</form>
		</div>	
	</body>
	</html>
	");
	exit;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="styles/worker_page.css">
    <script src="scripts/jquery-3.4.1.js"></script>

</head>

<body>
    <div class="content">
        <?php
        
        $result = $link->query('SELECT * FROM data_user ORDER BY time ASC');
        if($result){
            for($data = []; $row = $result->fetch_assoc(); $data[]=$row);
            $result='';
            foreach($data as $data_user){
                $result .= '
                <article class="item">
                    <div class="item__fliper">
                        <div class="item__front">
                            <h2>Заказ №'.$data_user['id'].'</h2>
                            <ul class="list">';
                                $summ = 0;
                                $res = $link->query('SELECT name, count,size, price, dbl_price,id_type FROM `basket`,`product`  WHERE `product`.`id` = `product_id` and `data_user_id`='.$data_user['id']);
                                for($list = []; $row = $res->fetch_assoc(); $list[]=$row);
                                foreach($list as $product)
                                {   
                                    if($product['id_type']==1)
                                        $result.='<li class="list__item"><span class="column">'.$product['name'].'</span><span class="column">'.$product['count'].' шт</span><span class="column">'.$product['size'].' см</span></li>';
                                    else
                                    $result.='<li class="list__item"><span class="column">'.$product['name'].'</span><span class="column">'.$product['count'].'</span></li>';
                                    if($product['size']==null or $product['size']==35){
                                        $summ+=$product['count']*$product['price'];
                                    }
                                    else{
                                        $summ+=$product['count']*$product['dbl_price'];
                                    }
                                }
                            $result.='</ul>
                        </div>
                        <div class="item__back">
                            <h2>Заказ №'.$data_user['id'].'</h2>
                            <ul class="list">
                                <li class="list__item">Форма обращения: '.$data_user['name'].'</li>
                                <li class="list__item">Адрес: '.$data_user['address'].'</li>
                                <li class="list__item">Номер телефона: '.$data_user['number'].'</li>
                                <li class="list__item">Итого: '.$summ.' ₽</li>
                                ';
                                if($data_user['payment']){
                                    $result.='<li class="list__item">Способ оплаты: Картой</li>';
                                }
                                else{
                                    $result.='<li class="list__item">Способ оплаты: Наличными</li>';
                                }
                                $result.= '
                            </ul>
                            <div class="compleat" data-id="'.$data_user['id'].'">Отправлено</div>
                        </div>
                    </div>
                </article>
                ';
            }
        }
        echo $result;
        
        ?>
        
    </div>
    <script>
        $(document).on('click','.item ',e=>{
            console.log($('.compleat').has(event.currentTarget));
            if ($('.compleat').has(e.target).length == 0){
                console.log($(e.currentTarget).children()[0])
                if($($(e.currentTarget).children()[0]).hasClass('active'))
                $($(e.currentTarget).children()[0]).removeClass('active');
                else
                $($(e.currentTarget).children()[0]).addClass('active');
            }
        })
        $(document).on('click','.compleat',e=>{
            id = $(e.currentTarget).data('id');

        })
    </script>
</body>

</html>