<div style="padding: 1%;">
логин:<input type="text" name="login_input"> пароль:<input type="password" name="password_input" >
<br>
<div style="padding-top: 1%;">
<input class="btn"  type="submit" name="enter_btn" value="Войти"></input> 
<br>
<input class="btn"  type="submit" name="register_btn" value="Регистрация"></input> 
</div>
</div>

<?php
if (isset($_POST["enter_btn"]))
{
	$login = $_POST["login_input"];
	$pass = $_POST["password_input"];
	if (empty($login) || empty($pass))
			echo "<script type='text/JavaScript'>  alert('Введите данные!');  </script> ";
	else
	{
		login_user($login, $pass);
	}
}

if (isset($_POST["reset_btn"]))
{
	$_SESSION['page'] = "index"; 
    $_SESSION['user'] = "out"; // in out admin
	$_SESSION['edit_book_id'] = '-1';
}


?>