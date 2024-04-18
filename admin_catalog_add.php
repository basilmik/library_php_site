
<form METHOD="POST">

	
Название книги:<br><input type="text" size='20' name="book_name_e" /><br>
	
Описание:<br>
<textarea name='book_description' rows='2' cols='20' value=''/> </textarea>
<br>

Год выпуска:<br>
<input type='number' name='book_year_published' size='20'/>

<br>
Картинка:<br>
<input type='text' name='book_picture' size='20'/>
<br>
Авторы:<br>
<?php

	$query=mysqli_query($mysqli, "select authors.id, CONCAT(authors.name, ' ', authors.surname) as name from authors");
	$i = 0;
	while($all_list=mysqli_fetch_array($query))
	{
		echo "<input type='checkbox' name='authors_list[]' value='$all_list[id]' ";
		echo ">".$all_list[name]."<br>";
	}

?>
<br>
Жанры:<br>
<?php 

		
	$query=mysqli_query($mysqli, "SELECT genres.id, genres.name FROM genres");
	$i = 0;
	while($all_list_g=mysqli_fetch_array($query))
	{
		echo "<input type='checkbox' name='genres_list[]' value='$all_list_g[id]' ";
		
		echo "	>".$all_list_g[name]."<br>";
	}

?>
	<button type="submit" name="add_UI" value="add">add</button>
	<br>
	<button type="clear" name="clear_add_UI" value="clear">clear</button>
	

</form>