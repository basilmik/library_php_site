<div style = "margin: auto; width: 300px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">

<h2>Корзина</h2> 

<?php
$user_id=$_SESSION['user_in_id'];
$str = "SELECT * FROM orders WHERE user_id='$user_id' AND state_id='1'"; // find all opened orders (should be 1 or 0)

$order_id = "-1";
$query = mysqli_query($mysqli, $str);
if (!empty($query))
{
	$res=mysqli_fetch_array($query);
	if (!empty($res))
	{
		$order_id = $res[id];	
	}
}


if (isset($_POST["delete_book_from_order"]))
{
	$book_id = $_POST["delete_book_from_order"];
	$str = "DELETE FROM buskets WHERE book_id=$book_id AND order_id=$order_id";
	mysqli_query($mysqli, $str);
	echo "<script type='text/JavaScript'>  alert('Удалено! ');  </script> ";
}

if (isset($_POST["do_order_books"]))
{
	$str = "UPDATE orders SET state_id='2' WHERE id=$order_id";
	
	mysqli_query($mysqli, $str);

	$date = date('Y-m-d');	
	$str = "UPDATE orders SET last_state_update_time='$date' WHERE id=$order_id";
	
	mysqli_query($mysqli, $str);
	echo "<script type='text/JavaScript'>  alert('Книги были заказаны! ');  </script> ";
	header("refresh: 0");	
}



$str="SELECT buskets.book_id as id, books.name as name FROM buskets 
JOIN books ON buskets.book_id = books.id WHERE buskets.order_id='$order_id' 
";

$query = mysqli_query($mysqli, $str);
if (mysqli_num_rows($query) > 0)
{
	echo"
	<form method='POST'>
	<table style='border: 2px solid black; margin: auto;'>
	<thead>
	<th>Название книги</th>
	<th>Удалить из корзины</th>

	</thead>
	<tbody >";



	$counter = 0;
	if (!empty($query))
	{
		while($res=mysqli_fetch_array($query))
		{
			if ($counter %2 == 0)
				echo "<tr style='background-color: #cccccc;'>";
			else
				echo "<tr style='background-color: #e3e3e3;'>";
			echo "<td style='width: 150px;'>";
			echo $res[name];
			echo "</td>";				
			echo "<td style='height: 50px; width: 50px;'>";
			echo "<button type='submit' style='height: 70px; width: 70px;' name='delete_book_from_order' value='$res[id]'>Удалить</button>";// echo $res[name];
			echo "</td>";		
			echo "</tr>";	
			$counter+=1;
		}

	}
	
	echo "</tbody>
</table>
<br>";
}

?>

<?php
if ($counter > 0)
	echo "<button class='btn' type='submit' name='do_order_books'>Заказать!</button>";
else
	echo "В корзине пусто!";
?>
</form>
</div>