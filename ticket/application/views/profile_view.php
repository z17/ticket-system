<?php
if ($data['login'] == false)
{
	echo $data['message'];
}
else
{

?>

<h1>Профиль</h1>
	<div class="profile">
		<div><span>Имя:</span> <?=$data['user']['name']?></div>
		<div><span>E-mail:</span> <?=$data['user']['email']?></div>
		<div><span>Телефон:</span> <?=$data['user']['phone']?></div>
		<div><span>Баланс:</span> <?=$data['user']['balance']?></div>
	</div>
    </dl>
  </fieldset>
  <?php
  if ($data['fl'])
{
	echo "<p>".$data['message']."</p>";
}
  ?>
  <ul>
	<li><a href="/ticket/add">Задать вопрос</a></li>
	<li><a href="/ticket/all">Все мои вопросы</a></li>
	<?php if($data['user']['id_group'] ==2) {?><li><a href="/ticket/answer">Все активные вопросы пользователей</a></li><?php } ?>
	<li><a href="/ticket/profile/edit">Редактировать профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>

<?php
}
?>
