<div class="column left">   
	<form method="POST">
	<button class="btn" type="submit" name="send_UI" value="index">Информация о библиотеке</button>
	<br>
	<button class="btn" type="submit" name="send_UI" value="katalog">Каталог</button>
	<br>
	<button class="btn" type="submit" name="send_UI" value="admin_edit">Редактировать каталог</button>
		<br>
	<button class="btn" type="submit" name="send_UI" value="admin_add">Добавить в каталог</button>
	
	</form> 
	
	<?php 
	if ($_SESSION['page'] == "katalog")
		include("search_control.php");

	
	?>
</div>



	

<div class="column center">

	<?php
	if (isset($_POST["add_UI"]))
	{
		if (empty($_POST['book_name_e']))
		{
			echo "Введите название книги!<br>";
		}
		else
		{
			$name = $_POST['book_name_e'];
			$dsc = $_POST['book_description'];
			$year = $_POST['book_year_published'];
			$pic = $_POST['book_picture'];
			
			$insert_string = 
			"INSERT INTO books (name, description, year_published, file_name) 
			VALUES ('$name' , '$dsc' , '$year' , '$pic')";
			
			$query=mysqli_query($mysqli, $insert_string);

			$select_last_string = "SELECT max(id) as id FROM books";
			
			$query=mysqli_query($mysqli, $select_last_string);
			
			
			$added_book=mysqli_fetch_array($query);

			$added_book_id=$added_book[id];

			if (count($_POST['authors_list']) > 0)
			{ 		
				foreach ($_POST['authors_list'] as $var)
				{
					$author_insert="INSERT INTO book_author (book_id, author_id) VALUES ($added_book_id, $var)";
					$query=mysqli_query($mysqli, $author_insert);
				}
			}

			if (count($_POST['genres_list']) > 0)
			{ 		
				foreach ($_POST['genres_list'] as $var)
				{
					$genre_insert="INSERT INTO book_genre (book_id, genre_id) VALUES ($added_book_id, $var)";
					$query=mysqli_query($mysqli, $genre_insert);
				}
			}
			echo "<br>";
		//echo "added?";
		$_SESSION['page'] = "admin_edit";
		
		}
	}
	
	
	?>

		<?php 
		if ($_SESSION['page'] == "index")
			echo "INFO page!";
		else
		if ($_SESSION['page'] == "katalog")
			include("katalog.php");
		else
		if ($_SESSION['page'] == "admin_edit")
			include("admin_catalog_edit.php");
		else
			if ($_SESSION['page'] == "admin_add")
		{
			
			include("admin_catalog_add.php");
		}
		else
			echo "INFO page!";
		?>

</div>

