<?=$data['message']?><br>
<div class="itemComments"><ul class="itemCommentsList">
<?php
if (!empty($data['posts']))
{
	foreach ($data['posts'] as $post)
	{
		if ($post['type'] == 'answer')
		{	?>
			<li style="margin-left:30px;"><h3>Ответ:</h3><div class="commentBody"><?=$post['text']?></div></li>
		<?php
		}
		else
		{ ?>
			<li><h3><?=$post['topicname']?></h3><div class="commentBody"><?=$post['text']?></div></li>
		<?php
		}
	}
}
else
{
?>
	<li><div class="commentBody">Вопросов нет</div></li>
	<?php
}
?>
</ul></div><br>
<?php
if (isset($data['messageForm']))
{
	echo $data['messageForm'].'<br>';
}
	if (isset($data['errors']))
	{	
	  foreach($data['errors'] as $error)
		{
			echo "<li class=\"redtext\">".$error."</li>";
		}
	}
?>

<h2>Ответить</h2>
<form action="/ticket/answer/<?=$data['id_author']?>" method="post">
<dl>
	<dt class="key">
		<label id="namemsg">Текст ответа</label>
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

  <ul>
	<li><a href="/ticket/answer">Все вопросы</a></li>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>