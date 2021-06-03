<?php 
	$link = mysqli_connect('localhost','root','','diplom');
	if(isset($_GET['id'])&isset($_GET['redact'])&isset($_GET['name'])){
		$query='UPDATE product SET '.$_GET['name'].'="'.$_GET['redact'].'" WHERE id='.$_GET['id'];
		mysqli_query($link,$query) or die(mysqli_error($link));
	}
?>
<table>
	
	<?php 
		if (isset($_POST['type'])) {
			if ($_POST['type']==1) {

				$query='SELECT * FROM product WHERE id_type="'.$_POST['type'].'"';
				$result=mysqli_query($link,$query) or die(mysqli_error($link));
				for($data=[];$row=mysqli_fetch_assoc($result);$data[]=$row);
				$result="<tr><th>img</th><th>name</th><th>description</th><th>price</th><th>dbl_price</th><th>delete</th></tr>";
				foreach ($data as $elem) {
					$result.="<tr>";
					$result.='<td class=""><img src="'.$elem['src'].'" alt=""></td>';
					$result.='<td>'.'<div class="redact" name="name" value="'.$elem['id'].'">'.$elem['name'].'</div>'.'</td>';
					$result.='<td class="td">'.'<div class="redact" name="description" value="'.$elem['id'].'">'.$elem['description'].'</div>'.'</td>';
					$result.='<td>'.'<div class="redact" name="price" value="'.$elem['id'].'">'.$elem['price'].' р</div>'.'</td>';
					$result.='<td>'.'<div class="redact" name="dbl_price" value="'.$elem['id'].'">'.$elem['dbl_price'].' р</div>'.'</td>';
					$result.='<td><a href="admin.php?id='.$elem['id'].'">delete</a></td>';
					$result.="<tr>";
				}
				echo $result;
			}
			else{
				$query='SELECT * FROM product WHERE id_type="'.$_POST['type'].'"';
				$result=mysqli_query($link,$query) or die(mysqli_error($link));
				for($data=[];$row=mysqli_fetch_assoc($result);$data[]=$row);
				$result="<tr><th>img</th><th>name</th><th>description</th><th>price</th><th>delete</th></tr>";
				foreach ($data as $elem) {
					
					$result.="<tr>";
					$result.='<td><img src="'.$elem['src'].'" alt=""></td>';
					$result.='<td>'.'<div class="redact" name="name" value="'.$elem['id'].'">'.$elem['name'].'</div>'.'</td>';
					$result.='<td class="td">'.'<div class="redact" name="description" value="'.$elem['id'].'">'.$elem['description'].'</div>'.'</td>';
					$result.='<td>'.'<div class="redact" name="price" value="'.$elem['id'].'">'.$elem['price'].' р</div>'.'</td>';
					$result.='<td><a href="admin.php?id='.$elem['id'].'">delete</a></td>';
					$result.="<tr>";
			}
			echo $result;
			}
			
		}
	 ?>
</table>
<script type="text/javascript">
	$( ".redact" ).dblclick(function(event) {
		event.target.setAttribute('contenteditable','true');
		event.target.setAttribute('onkeyup','klick(event);');
});
</script>