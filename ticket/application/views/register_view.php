<?=$data['message']?><br>
<?php
	if (isset($data['errors']))
	{
	  foreach($data['errors'] as $error)
		{
			echo "<li class=\"redtext\">".$error."</li>";
		}
	}
?>
<?php
if ($data['formFl']) // плохой способ, но пока что будет так
{
?>
<form action="/ticket/register" method="post">
<dl>
	<dt class="key">
		<label id="namemsg">E-mail</label>
    </dt>
    <dd>
      <input type="text" name="email" size="40" class="inputbox required" maxlength="50" value="<?=$data['email']?>">
	</dd>
	<dt class="key">
		<label id="namemsg">Пароль</label>
    </dt>
    <dd>
      <input type="password" name="pass1" size="40" class="inputbox required" maxlength="50">
	</dd>
	<dt class="key">
		<label id="namemsg">Повторите пароль</label>
    </dt>
    <dd>
      <input type="password" name="pass2" size="40" class="inputbox required" maxlength="50">
	</dd>
	<dt class="key">
		<label id="namemsg">Имя</label>
    </dt>
    <dd>
      <input type="text" name="name" size="40" class="inputbox required" maxlength="50" value="<?=$data['name']?>">
	</dd>
	<dt class="key">
		<label id="namemsg">Телефон</label>
    </dt>
    <dd>
      <input type="text" name="phone" size="40" class="inputbox required" maxlength="50" value="<?=$data['phone']?>">
	</dd>
</dl>
<div class="k2AccountPageUpdate">
<input type="text" name="fl" value="true" hidden>
  <button class="button validate" type="submit">Зарегистрироваться</button>
</div>
</form>
<?php } ?>