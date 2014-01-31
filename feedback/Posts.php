<html>
<head>
<title>Posts</title>
</head>
<body>
	<form method="post" action="">
		<label> Nombre <input type="text" name="nombre" />
		</label> <br> <label><textarea name="comentario"></textarea> </label>
		<p>
			<label><input type="submit" value="Enviar" /> </label>
		</p>
	</form>
	<?php
	$posts = file_get_contents("posts.txt");

	echo nl2br($posts);

	if(!empty($_POST["nombre"]) && !empty($_POST["comentario"]))
	{
		$comentario = $_POST["comentario"];
		$nombre = $_POST["nombre"];

		$posts = "<hr>\r\n
		$comentario \r\n
		- $nombre -
		\r\n
		\r\n"
		. $posts;

		file_put_contents("posts.txt", $posts);
		header("Location: " . $_SERVER["PHP_SELF"]);
	}
	?>
</body>
</html>
