<?=$data['message']?>
<?php
	if (isset($data['errors']))
	{
		echo "<ul>";
		foreach($data['errors'] as $error)
		{
			echo "<li class=\"redtext\">".$error."</li>";
		}
		echo "</ul>";
	}
?>
<?php
if ($data['fl'] === false) // плохой способ, но пока что будет так
{
?>
<form action="/ticket/add" method="post">
<div class="form-add">
	 <div class="key">
		<span class="name">Тема:</span>
		<input name="topicname" class="topicname" maxlength="255"></textarea>
	</div>
	<div class="key">
		<span class="name">Текст:</span>
		<textarea name="text" class="text" id="description"></textarea>
	</div>	
</div>
<p>
	<input type="text" name="fl" value="true" hidden>
	<button class="button" type="submit">Отправить</button>
</p>
</form>


<?=$data['price']?>
<?php } ?>
<?php if ($data['userFl']) {?>
  <ul>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>
<?php } ?>