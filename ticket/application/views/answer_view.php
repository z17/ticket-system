<?=$data['message']?>
<div class="itemComments"><ul class="itemCommentsList">
<?php
if (!empty($data['posts']))
{
	foreach ($data['posts'] as $post)
	{
	?>
	<li><h3><?=$post['topicname']?></h3><div class="commentBody">
	<?=$post['text']?></div>
		<div class="commentToolbar" style="padding:10px">
				<a href="/ticket/answer/<?=$post['id_user']?>" name="comment11" id="comment11">Ответить/Читать всё</a>		</div>	
	</li>
	<?php
	}
}
else
{
?>
	<li><div class="commentBody">Нет активных вопросов</div></li>
	<?php
}
?>
</ul></div>
  <ul>
	<li><a href="/ticket/profile">Профиль</a></li>
	<li><a href="/ticket/logout">Выйти</a></li>
  </ul>