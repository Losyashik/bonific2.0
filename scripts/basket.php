<?php
    $link = mysqli_connect('localhost','root','','diplom');
    function echos($arr)
{
	echo ('<pre>');
	print_r($arr);
	echo ('</pre>');
}
echos($_POST);
?>