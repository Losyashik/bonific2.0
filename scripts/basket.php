<?php
$link = mysqli_connect('localhost', 'root', '', 'diplom');
function echos($arr)
{
	echo ('<pre>');
	print_r($arr);
	echo ('</pre>');
}
if(isset($_POST['products'])){
	foreach($_POST['products'] as $key => $product){
		$data = $link->query("SELECT * FROM product WHERE id = ".$product['id'])->fetch_assoc();
		if($data['id_type']==1){
			echo "
			<div class='products__item'>
			<div class='products__img'><img src='".$data['src']."' alt=''></div>
			<div class='products__info'>
				<h4>".$data['name']." ".$product['size']." см</h4>
				<div class='products__discription'>
					".$data['description']."
				</div>
				<div class='products__nav'>
					<div class='counter'>
						<span class='counter__minus' data-basket-id = '$key'>&mdash;</span>
						<span class='counter__count'>".$product['count']."</span>
						<span class='counter__plus' data-basket-id = '$key'>+</span>
					</div>";
					if($product['size']==35){
						echo "<div class='price'>".$data['price']."</div>";
					}
					else{
						echo "<div class='price'>".$data['dbl_price']."</div>";
					}
					
				echo"</div>
			</div>
			<div class='products__delete'><img data-basket-id = '$key' src='img/ico/close.png' alt=''></div>
			</div>
			";
		}
		else{
			echo "
			<div class='products__item'>
			<div class='products__img'><img src='".$data['src']."' alt=''></div>
			<div class='products__info'>
				<h4>".$data['name']."</h4>
				<div class='products__discription'>
					".$data['description']."
				</div>
				<div class='products__nav'>
					<div class='counter'>
						<span class='counter__minus' data-basket-id = '$key'>&mdash;</span>
						<span class='counter__count'>".$product['count']."</span>
						<span class='counter__plus' data-basket-id = '$key'>+</span>
					</div>
						<div class='price'>".$data['price']."</div>
				</div>
			</div>
			<div class='products__delete'><img data-basket-id = '$key' src='img/ico/close.png' alt=''></div>
			</div>
			";
		}
		
	}
}