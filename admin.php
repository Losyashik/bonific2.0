<?php
session_start();

if (isset($_POST['go_log'])) {
	$log = $_POST['login'];
	$pasw = $_POST['pas'];
	$lo = 'admin';
	$pa = '$2y$10$ec9HoTGq2guLuY234kD3NebIPFyoEQB4SMYRtyYH2NMJiiJAU0RqW';
	if ($log == $lo and password_verify($pasw, $pa)) {
		$_SESSION['admin'] = time();
	}
	header('Location:admin.php');
}

if (isset($_SESSION['admin'])) {
	if (time() - $_SESSION['admin'] < 1200) {
		$_SESSION['admin'] = time();
	} else {
		unset($_SESSION['admin']);
		header('Location:admin.php');
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

function echos($arr)
{
	echo ('<pre>');
	print_r($arr);
	echo ('</pre>');
}
$link = mysqli_connect('localhost', 'root', '', 'diplom');
if (isset($_POST['edit_ban'])) {
	$put = $link->query("SELECT src FROM baner WHERE id = " . $_POST['id'])->fetch_assoc()['src'];
	if ($put != NULL) {
		if (unlink($put)) {
			$type = explode('.', $_FILES['baner']['name']); //Разбивает строку с помощью разделителя
			$type = $type[count($type) - 1]; //вычисление длинны массива названия файла
			$put = "img/slider/" . $_POST['id'] . '.' . $type;
			if (move_uploaded_file($_FILES['baner']['tmp_name'], $put)) {
				$sql = "UPDATE baner SET src='$put' WHERE id=" . $_POST['id'];
				mysqli_query($link, $sql) or die(mysqli_error($link));
				header('Location:admin.php');
			}
		}
	} else {
		$type = explode('.', $_FILES['banner']['name']); //Разбивает строку с помощью разделителя
		$type = $type[count($type) - 1]; //вычисление длинны массива названия файла
		$put = "img/slider/" . $_POST['id'] . '.' . $type;
		if (move_uploaded_file($_FILES['banner']['tmp_name'], $put)) {
			$sql = "UPDATE baner SET src='$put' WHERE id=" . $_POST['id'];
			mysqli_query($link, $sql) or die(mysqli_error($link));
			header('Location:admin.php');
		}
	}
}
if(isset($_POST['off'])){
	$put = $link->query("SELECT src FROM baner WHERE id = " . $_POST['off'])->fetch_assoc()['src'];
	if ($put != NULL) {
		if (unlink($put)) {
			$sql = "UPDATE baner SET src=NULL WHERE id=" . $_POST['off'];
			mysqli_query($link, $sql) or die(mysqli_error($link));
			header('Location:admin.php');
		}
	}
	else
		header('Location:admin.php');
}
if (isset($_POST['go'])) {
	if (isset($_FILES['src'])) {
		$type = explode('.', $_FILES['src']['name']); //Разбивает строку с помощью разделителя
		$type = $type[count($type) - 1]; //вычисление длинны массива названия файла


		$sql = "INSERT INTO `product` (`name`, `description`, `id_type`, `price`, `dbl_price`) VALUES ('" . $_POST['name'] . "', '" . $_POST['description'] . "', '" . $_POST['type'] . "','" . $_POST['price'] . "', '" . $_POST['dbl_price'] . "')";
		mysqli_query($link, $sql) or die(mysqli_error($link));
		$id = $link->insert_id;
		$put = "img/product/" . $id . '.' . $type;
		if (move_uploaded_file($_FILES['src']['tmp_name'], $put)) {
			$sql = "UPDATE product SET src='$put' WHERE id=$id";
			mysqli_query($link, $sql) or die(mysqli_error($link));
		}

		header('Location:admin.php');
	}
}
if (isset($_GET['id'])) {
	$put = $link->query("SELECT src FROM product WHERE id = " . $_GET['id'])->fetch_assoc()['src'];
	if (unlink($put)) {
		$sql = 'DELETE FROM product WHERE id=' . $_GET['id'];
		mysqli_query($link, $sql) or die(mysqli_error($link));
		header('Location:admin.php');
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<script type="text/javascript" src="scripts/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="scripts/ajax.js"></script>
	<link rel="shortcut icon" href="img/ico.png" type="image/jpg">
	<title></title>
	<style type="text/css">
		form.form {
			margin: 2vw auto;
			width: 80vw;
			height: 50vh;
			border: 4px solid;
		}

		input,
		select,
		textarea {
			display: block;
			width: 30vw;
			height: 4vh;
			margin: 2vh auto;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
			border: .1vw solid;
		}

		.form {
			width: 40vw;
			height: 50vh;
			float: left;
		}

		form img {
			width: 35vw;
			height: 40vh;
			margin: 6vh 2.5vw;
			object-fit: cover;

		}

		.td {
			max-width: 30vw;
		}

		.off {
			display: none;
		}

		.a1 {
			width: 10vw;
		}
	</style>
</head>

<body>
	<button class="a2" onclick='opSlider();'>Изменить слайдер</button>
	<button class="a1" onclick='opForm();'>Добавить продукт</button>

	<form action="" id='form' class="off" method="POST" enctype='multipart/form-data'>
		<div class="form">
			<input required type="text" placeholder="Введите название продукта" name="name">
			<textarea required name="description" placeholder="Введите описание продукта"></textarea>
			<select required name='type' class="sel">
				<option selected="" disabled="">Выберете тип товара</option>
				<?php
				$query = 'SELECT * FROM type';
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
				$result = '';
				foreach ($data as $elem) {
					$result .= "<option value='" . $elem["id"] . "'>" . $elem["name"] . "</option>";
				}
				echo $result;
				?>
			</select>
			<input required type="file" class="img" name="src">
			<input required type="text" placeholder="Введите цену" name="price">
			<input required type="text" disabled="" class="dbl" placeholder="Введите вторую цену" name="dbl_price">
			<input type="submit" name="go">
		</div>
		<img src="img/ico.png" class="op" alt="">
	</form>

	<table class="slider_edit off" id="slider_edit">
		<tr>
			<th>Номер слайда</th>
			<th>Изображение</th>
			<th>Изменение</th>
			<th>Отключить</th>
		</tr>
		<?php
		$query = "SELECT * FROM baner ORDER BY id ASC";
		$result = $link->query($query);
		while ($elem = $result->fetch_assoc()) {
			echo "
			<tr>
				<td>" . $elem['id'] . "</td>
				<td><img style='max-height:35vh;' src='" . $elem['src'] . "' alt=''></td>
				<td><form method='post' enctype='multipart/form-data'> <input type='hidden' value='" . $elem['id'] . "' name='id'><input type='file' name='banner'><input type='submit' value='Изменить' name = 'edit_ban'></td>
				<td> <form method='post'><button name='off' value='" . $elem['id'] . "' type='submit'>Отключить слайд </button></form></td>
			</tr>
			";
		}
		?>
	</table>
	<select class="ajax">
		<?php
		$query = 'SELECT * FROM type';
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		$result = '';
		foreach ($data as $elem) {
			$result .= "<option value='" . $elem["id"] . "'>" . $elem["name"] . "</option>";
		}
		echo $result;
		?>
	</select>
	<div class="conteiner">

	</div>
	<script type="text/javascript">
		$('.sel').change(function() {
			if ($('.sel').val() == 1) {
				$('.dbl').removeAttr('disabled');
			} else {
				$('.dbl').attr('disabled', 'disabled');
				$('.dbl').val('');
			}
		});

		function readURL(input) {

			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {

					$('.op').attr('src', e.target.result);

				}

				reader.readAsDataURL(input.files[0]);
			}
		}
		$(".img").change(function() {
			readURL(this);
		});

		function opSlider() {
			$('#slider_edit').removeClass('off')
			$('.a2').attr('onclick', 'exSlider();');
			$('.a2').html('Скрыть');
		}

		function exSlider() {
			$('#slider_edit').addClass('off')
			$('.a2').attr('onclick', 'opSlider();');
			$('.a2').html('Изменить слайдер');
		}

		function opForm() {
			$('#form').removeClass('off')
			$('.a1').attr('onclick', 'exForm();');
			$('.a1').html('Скрыть');
		}

		function exForm() {
			$('#form').addClass('off')
			$('.a1').attr('onclick', 'opForm();');
			$('.a1').html('Добавить продукт');
		}

		function klick(e) {
			if (e.ctrlKey && e.keyCode == 13) {
				let promise = fetch('scripts/ajax_admin.php?redact=' + e.target.innerHTML + '&id=' + e.target.getAttribute('value') + '&name=' + e.target.getAttribute('name'));
				event.target.setAttribute('contenteditable', 'false');
				event.target.setAttribute('onkeyup', '');
				if (e.target.getAttribute('name') == 'price' || e.target.getAttribute('name') == 'dbl_price') {
					e.target.innerHTML = e.target.innerHTML + ' р'
				}
			}

		}
		updateContent(1, 'scripts/ajax_admin.php');
		$(".ajax").change(function() {
			updateContent($('.ajax').val(), 'scripts/ajax_admin.php');
		});
	</script>
</body>

</html>