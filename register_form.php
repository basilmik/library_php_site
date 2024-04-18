
<?php
if (isset($_POST["cancel_register_btn"]))
{
	$_SESSION['user'] = "out";
	$_SESSION['page'] = "index";
	header("Refresh:0");
}
?>
<div style = "margin: auto; width: 300px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">

<form method="POST" >
	<h2 style="">Регистрация</h2> 
<?php

if (isset($_POST["do_register_btn"]))
{
	if (empty($_POST["login_register_input"]) || empty($_POST["password_register_input"]) || empty($_POST["name_register_input"]) || empty($_POST["email_register_input"]))
		echo "Пожалуйста, заполните все поля!";
	else
	{	
		
		$login = $_POST["login_register_input"];
		$pass = $_POST["password_register_input"];
		$name = $_POST["name_register_input"];
		$email = $_POST["email_register_input"];
		
		$query = 
		"SELECT id FROM users WHERE login='$login'";
		

		$m_query = mysqli_query($mysqli, $query);
		if (!empty($m_query))

			$res=mysqli_fetch_array($m_query);
		if (!empty($res))	
		{
			echo "Пользователь с таким логином уже зарегистрирован!";
		}
		else	
		{
			$query = 
			"INSERT INTO users (login, password, name, email) VALUES ('$login', '$pass', '$name', '$email')";
			$m_query = mysqli_query($mysqli, $query);
			login_user($login, $pass);
		}
		
	}
}
else
	echo "<br>";
?>


	<table style = "margin: auto; text-align: center; font-size: 20px;">
	<tr>
	<td>логин:</td>
	<td><input type="text" name="login_register_input"> </td>
	</tr>

	<tr>
	<td>пароль:</td>
	<td><input type="password" name="password_register_input"></td>
	</tr>
	
	<tr>
	<td>имя:</td>
	<td><input type="text" name="name_register_input"></td>
	</tr>	
	
	<tr>
	<td>email:</td>
	<td><input type="text" name="email_register_input"></td>
	</tr>
	
	</table>

	<br>
	<input class="btn" style="width:100%;" type="submit" name="do_register_btn" value="Зарегистрироваться и войти"></input> 
	<br><br>
	<input class="btn" style="width:100%;" type="submit" name="cancel_register_btn" value="Отмена"></input> 
</form>
</div>
