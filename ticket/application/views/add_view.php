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
if ($data['fl'] === false and empty($data['errors'])) // плохой способ, но пока что будет так
{
?>
<form action="/ticket/add" method="post">
<dl>
	<dt class="key">
		<label id="namemsg">Тема</label>
    </dt>
    <dd>
      <input name="topicname" size="40" class="inputbox required" maxlength="255"></textarea>
	</dd>
	<dt class="key">
		<label id="namemsg">Текст</label>
    </dt>
    <dd>
      <textarea name="text" class="mce_editable" id="description"  style="width: 100%; height: 150px;"></textarea>
	</dd>	
</dl>
<div class="k2AccountPageUpdate">
<input type="text" name="fl" value="true" hidden>
  <button class="button validate" type="submit">Отправить</button>
</div>
</form>


<form action="http://test.robokassa.ru/Index.aspx" method="post">
<!-- для реального режима измените action формы на "https://merchant.roboxchange.com/Index.aspx" -->
<dl>
	<dt class="key">
		<label id="namemsg">Тема</label>
    </dt>
    <dd>
      <input name="topicname" size="40" class="inputbox required" maxlength="255"></textarea>
	</dd>
	<dt class="key">
		<label id="namemsg">Текст</label>
    </dt>
    <dd>
      <textarea name="text" class="mce_editable" id="description"  style="width: 100%; height: 150px;"></textarea>
	</dd>	
</dl>
<div class="k2AccountPageUpdate">
	<button class="button validate" type="submit">Оплатить Вопрос</button>	
	
	<input type="hidden" name="MrchLogin" value="<?=$data['pay']['mrh_login']?>">
	<input type="hidden" name="OutSum" value="<?=$data['pay']['out_summ']?>">
	<input type="hidden" name="SignatureValue" value="<?=$data['pay']['crc']?>">
	<input type="hidden" name="Culture" value="<?=$data['pay']['culture']?>">  
</div>
</form>
<?=$data['price']?>
<?php } ?>
<?php if ($data['userFl']) {?>
  <ul>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>
<?php } ?>