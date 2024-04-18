<div style = "margin: auto; width: 60%; height:400px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">

<h2>Информация о библиотеке</h2> 
<table style = "text-align: left">
<tr>
<td style = "width: 40%;">
<h3>Добро пожаловать на сайт нашей электронной библиотеки!</h3>
<p>Наша онлайн библиотка открыта круглосуточно :)
<br>
Вы можете связаться с нами через <form method="post"><input class="btn" type="submit" name="to_feedback_form" value="Форму обратной связи"/></form>
<br>
<br>
<?php 
if ($_SESSION['user'] == "out")
	echo "Для заказа книг, авторизируетейтесь или зарегистрируйтесь в нашей системе!";
else
	echo "Приятного чтения!";
?>
</p>
</td>

<td style = "text-align: center">

<br>
	<img src= 'cat_with_book.jpg' width='60%' height='60%'/>
	<p>Это котик <b>Ио</b>, главный администратор нашей библиотеки.
<br> 
Он ученый кот!
</p>
</td>

</tr>
</table>

</div>

