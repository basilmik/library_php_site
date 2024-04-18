<div style = "margin: auto; width: 300px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">
<h2>Моя книжная история</h2> 
<?php
$user_id=$_SESSION['user_in_id'];

if (empty($_POST["show_filter"]))
	$limit = " LIMIT 5 ";
elseif ($_POST["show_filter"]!="all")
	$limit = " LIMIT ".$_POST["show_filter"];
else
	$limit = "";
$str = "SELECT orders.*, YEAR(last_state_update_time) as year, 
MONTH(last_state_update_time) as mon,
DAY(last_state_update_time) as day 
FROM orders WHERE user_id='$user_id' AND state_id='2' ORDER BY id DESC $limit"; // find all opened (should be 1)
$order_id = "-1";
$query = mysqli_query($mysqli, $str);
if (mysqli_num_rows($query) > 0)
	{echo '

	<form method="POST">
	<div style = "margin: auto; text-align: right;">

	<label for="show_filter">Показать</label>
	<select name="show_filter">
		<option value="5" if ($_POST["show_filter"] == "5") echo "selected";
		>5</option>
		<option value="10" 
		if ($_POST["show_filter"] == "10") echo "selected";?>
		10</option>
		<option value="20" 
		if ($_POST["show_filter"] == "20") echo "selected";?>
		20</option>
		<option value="all" 
		if ($_POST["show_filter"] == "all") echo "selected";?>
		Все</option>
	</select>
	<button type ="submit" value="">фильтр</button>

	</div>
	<table style="border: 2px solid black; margin: auto;">
	<tr>
	<th>Дата заказа</th>
	<th>Книги</th>
	</tr>
	';
	$counter = 0;
	if (!empty($query))
	{
		while($res=mysqli_fetch_array($query))
		{
			$order_id=$res[id];
			if ($counter %2 == 0)
				echo "<tr style='background-color: #cccccc;'>";
			else
				echo "<tr style='background-color:  #e3e3e3;'>";
			$counter+=1;
			echo "<td  style='padding:2%; width: 30%;'>";
			echo $res[day].".".$res[mon].".".$res[year];

			echo "</td>";				
			echo "<td style='padding:2%; height:100%; width: 80%; text-align: left;'> <ul>";
			
			$str2="SELECT buskets.book_id as id, books.name as name FROM buskets 
			JOIN books ON buskets.book_id = books.id WHERE buskets.order_id='$order_id' 
			";
			$query2 = mysqli_query($mysqli, $str2);

			if (!empty($query))
			{
				while($res2=mysqli_fetch_array($query2))
				{
					echo "<div style='padding:2%; height:100%; width: 80%; text-align: right;'>";
					echo "</div>";
					echo "<li>".$res2[name]."<br>";
				}
			}
			
			echo "</ul></td>";		
			echo "</tr>";		
		}
	}
	echo '</table></form>';
}
else
	echo "Ваша история еще не написана!";
?>
</div>