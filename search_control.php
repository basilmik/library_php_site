<h2 style="text-align: center;">Поиск</h2>
<div style="">

<form action="" method="POST" >
	Название книги:<br><input type="text" name="book_name"<?php
	if (!empty($_POST['book_name']))
	{
		echo " value = ".$_POST['book_name'];
	}
	?>
	> <br>
	
		Автор:<br>
	<?php
	$query4=mysqli_query($mysqli, "SELECT DISTINCT id, name, surname FROM authors");
	$i = 0;
	while($res4=mysqli_fetch_array($query4))
	{
		echo "<input type=\"checkbox\" name=\"author_name[]\" value=$res4[id] ";
		if (isset($_POST['author_name']))
		if (in_array($res4[id], $_POST['author_name']))
		{
			echo " checked ";
		}		
		echo ">".$res4[name]." ".$res4[surname]."<br>";
		
		$i++;		
	}
	?>
	<br>
	
	Жанр:<br>
	<?php
	$query3=mysqli_query($mysqli, "SELECT id, name FROM genres");
	$i = 0;
	while($res3=mysqli_fetch_array($query3))
	{
		echo "<input type=\"checkbox\" name=\"genre[]\" value=$res3[id] ";
		if (isset($_POST['genre']))
		if (in_array($res3[id], $_POST['genre']))
		{
			echo " checked ";
		}		
		echo ">".$res3[name]."<br>";
		
		$i++;		
	}
	?>
				
	<br>
	
	
	Минимальный год:<br><input type="number" name="min_year" min="0"
	<?php
	if (!empty($_POST['min_year']))
	{
		echo " value = ".$_POST['min_year'];
	}
	?>
	> <br>
	Максимальный год:<br><input type="number" name="max_year" min="0"<?php
	if (!empty($_POST['max_year']))
	{
		echo " value = ".$_POST['max_year'];
	}
	?>
	> <br>

<input class="btn" type="submit" name="send_spec" value="Искать"> 
<br>
<br>
<button class="btn"><a href="/index.php" style="text-decoration:none; color:black;">Очистить</a></button>
</form>
</div>