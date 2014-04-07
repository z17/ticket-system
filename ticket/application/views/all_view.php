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
	<li><div class="commentBody">Вы ещё не задавали вопросов</div></li>
	<?php
}
?>
</ul></div>
<ul>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>
