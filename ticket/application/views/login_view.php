<div class="login">
<div class="login-description">
<?php
	if (strlen($data['message']) > 0)
	{
			echo "<p>".$data['message']."</p>";
	}
	if (isset($data['error']))
	{
			echo "<p>".$data['error']."</p>";
	}
?>
</div>
<?php
if ($data['formFl'] == true) {
?>		
  <form action="/ticket/login" method="post">
    <fieldset>
      <div class="login-fields">
        <label id="username-lbl" for="username" class="">E-mail</label>
        <input type="text" name="email" class="validate-username inputbox" size="25">
      </div>
      <div class="login-fields">
        <label id="password-lbl" for="password" class="">Пароль</label>
        <input type="password" name="password" class="validate-password inputbox" size="25">
      </div>
      <div class="readon">
        <button type="submit" class="button">Войти</button>
      </div>
      <input type="text" name="fl" value="true" hidden>
    </fieldset>
  </form>
  <div>
    <ul class="userLinks">
      <li class="firstItem">
        <a href="#">Забыли пароль?</a>
      </li>
      <li class="lastItem">
        <a href="/ticket/register">Зарегестрироваться</a>
      </li>
    </ul>
  </div>

<?php } ?>
</div>