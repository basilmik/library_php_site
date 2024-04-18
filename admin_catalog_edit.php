	
<!-- MAIN -->
	
	<?php

	include("catalog_table_manager.php");
	
	echo "<h2>Каталог книг</h2>";
	if (isset($_POST['edit_this_book_btn']))
	{
		$_SESSION['edit_book_id'] = $_POST['edit_this_book_btn'];
	}
	
	if (isset($_POST['cancel_this_book_btn']))
	{
		$_SESSION['edit_book_id'] = '-1';
	}

	
	if (isset($_POST["save_this_book_btn"]))
	{
		$name = $_POST['book_name_e'];
		$dsc = $_POST['book_description'];
		$year = $_POST['book_year_published'];
		$pic = $_POST['book_picture'];
		$book_id = $_POST["save_this_book_btn"];
		
		$delete_string = "DELETE FROM book_author WHERE book_id=$book_id";
		$query=mysqli_query($mysqli, $delete_string);
		$delete_string = "DELETE FROM book_genre WHERE book_id=$book_id";
		$query=mysqli_query($mysqli, $delete_string);

		if (count($_POST['authors_list']) > 0)
			{ 		
				foreach ($_POST['authors_list'] as $var)
				{
					$author_insert="INSERT INTO book_author (book_id, author_id) VALUES ($book_id, $var)";
					$query=mysqli_query($mysqli, $author_insert);
				}
			}

			if (count($_POST['genres_list']) > 0)
			{ 		
				foreach ($_POST['genres_list'] as $var)
				{
					$genre_insert="INSERT INTO book_genre (book_id, genre_id) VALUES ($book_id, $var)";
					$query=mysqli_query($mysqli, $genre_insert);
				}
			}

		$update_string="UPDATE books SET name='$name', description='$dsc', year_published ='$year', file_name = '$pic' WHERE id=$book_id";

		$query=mysqli_query($mysqli, $update_string);
		
		$_SESSION['edit_book_id'] = '-1';
	}	
	
	if (isset($_POST["delete_this_book_btn"]))
	{
		$delete_string = "DELETE FROM book_author WHERE book_id=".$_POST["delete_this_book_btn"];
		$query=mysqli_query($mysqli, $delete_string);
		$delete_string = "DELETE FROM book_genre WHERE book_id=".$_POST["delete_this_book_btn"];
		$query=mysqli_query($mysqli, $delete_string);
		$delete_string = "DELETE FROM books WHERE id=".$_POST["delete_this_book_btn"];
		$query=mysqli_query($mysqli, $delete_string);
	}
	

	$query_created = create_main();

	$query = mysqli_query($mysqli, $query_created);
	
	create_edit_catalog($mysqli, $query);

	?>

