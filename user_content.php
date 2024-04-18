	<div class="column left">   
	<form method="POST">
<button class="btn" type="submit" name="send_UI" value="index">Информация
	о библиотеке</button>
<button class="btn" type="submit" name="send_UI" value="katalog">Каталог</button>
<button class="btn" type="submit" name="to_feedback_form" value="feedback">Обратная связь</button></td></tr>

<?php if ($_SESSION['page'] == "katalog")
{
	include("search_control.php");
}
?>


	</form> 

</div>

<div class="column center" style="">

		<?php 
	if (isset($_POST["add_this_book_btn"]))
	{
		$book_id = $_POST["add_this_book_btn"];
		$user_id=$_SESSION['user_in_id'];
		$str = "SELECT * FROM orders WHERE user_id='$user_id' AND state_id='1'"; // find all opened (should be 1)
		//echo $str;
		$query = mysqli_query($mysqli, $str);
		if (!empty($query))
		{
			$res=mysqli_fetch_array($query);
			if (!empty($res))
			{
				//echo "Существует карзина: ".$res[last_state_update_time];
				add_book_to_order($res[id], $book_id);
			}
		
			else
			{
				//echo "no korzina";
				$date = date('Y-m-d');
				// INSERT INTO `orders` (`id`, `user_id`, `state_id`, `last_state_update_time`) VALUES (NULL, '1', '2', '2024-04-09');
				$str2="INSERT INTO orders (user_id, state_id, last_state_update_time) VALUES ('$user_id','1','$date')";
				//echo $str2;
				$query = mysqli_query($mysqli, $str2);
				
				$query = mysqli_query($mysqli, $str);
				if (!empty($query))
				{
					$res=mysqli_fetch_array($query);
					if (!empty($res))
					{
						//echo "Существует заказ: ".$res[id];
						add_book_to_order($res[id], $book_id);
							
					}
				}
			}
		}
	}

if (isset($_POST["to_feedback_form"]))
{
	$_SESSION['page'] = "feedback";
	header("refresh: 0");
	
}


		if ($_SESSION['page'] == "katalog")
			include("katalog.php");
		else
			if ($_SESSION['page'] == "index")
			include("lib_info.php");
		else
			if ($_SESSION['page'] == "feedback")
			include("feedback_form.php");
			
	if($_SESSION['user'] == "in" and  $_SESSION['page'] == "info")
	{
		include("user_info.php");
	}
	
	if($_SESSION['user'] == "in" and  $_SESSION['page'] == "history")
	{
		include("user_history.php");
	}	
	
	if($_SESSION['user'] == "in" and  $_SESSION['page'] == "busket")
	{
		include("user_busket.php");
	}
	
		if($_SESSION['user'] == "out" and  $_SESSION['page'] == "register")
	{
		include("register_form.php");
		//$_SESSION['page']="index";
	}	
?>

</div>

<?php
function add_book_to_order($order_id, $book_id)
{
	global $mysqli;
	$str="SELECT * FROM buskets WHERE order_id = '$order_id' AND book_id = '$book_id'";
	$query = mysqli_query($mysqli, $str);
	if (!empty($query))
	{
		$res=mysqli_fetch_array($query);
		if (!empty($res))
		{
	echo "<script type='text/JavaScript'>  alert('Такая книга уже заказана! ');  </script> ";
			return;
		}
	}
	$str="INSERT INTO buskets (order_id, book_id) VALUES ('$order_id','$book_id')";
	//echo $str;
	$query = mysqli_query($mysqli, $str);
	echo "<script type='text/JavaScript'> ";
	echo "alert('Книга добавлена!'); ";
	echo "</script> ";
}


?>