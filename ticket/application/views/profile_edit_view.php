<p><?=$data['message']?>
</p>
<?php
	if (isset($data['errors']))
	{
	  foreach($data['errors'] as $error)
		{
			echo "<li class=\"redtext\">".$error."</li>";
		}
	}	
?>
<div id="k2Container" class="k2AccountPage">
<form action="/ticket/profile/edit" method="post" class="profile-edit">
  <h2>Редактировать профиль</h2>
    <div class="key">
      <span>Имя:</span>     
      <input type="text" name="newName" size="40" value="<?=$data['user']['name']?>" class="inputbox required" maxlength="50">
    </div>
	<div class="key">
      <span>Новый пароль:</span> 
    
      <input type="password" name="newPass1" size="40" value="" class="inputbox required" maxlength="50">
    </div>
	<div class="key">
      <span>Повторите новый пароль:</span> 
    
      <input type="password" name="newPass2" size="40" value="" class="inputbox required" maxlength="50">
    </div>
	<div class="key">
      <span>Телефон:</span> 
    
      <input type="text" name="newPhone" size="40" value="<?=$data['user']['phone']?>" class="inputbox required" maxlength="50">
    </div>
	<div class="key">
      <span>Старый пароль:</span>     
      <input type="password" name="password" size="40" value="" class="inputbox required" maxlength="50">
    </div>
  <div class="k2AccountPageUpdate">
  <input type="text" name="fl" value="true" hidden>
    <button class="button validate" type="submit" onclick="submitbutton( this.form );return false;">Сохранить</button>
</div>
</form>
</div>
  <ul>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>