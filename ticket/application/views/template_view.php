<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?=$data['title']?></title>
  <link rel="stylesheet" href="/ticket/css/normalize.css" type="text/css" />
  <link rel="stylesheet" href="/ticket/css/style.css" type="text/css" />

	 </head>
    <body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">Ticket system</div> 
				<div id="menu"><a href="/ticket/">Главная</a></div>
			</div>
			<div id="content">
				<?php include_once 'application/views/'.$content_view; ?>
			</div>
			<div id="footer">
				<a href="http://github.com/z17" target="_blank">z17</a>, 2014
			</div>
		</div>
	</body>
</html>	