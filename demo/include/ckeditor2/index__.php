<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Sample CKEditor Site</title>
<!--	<script type="text/javascript" src="ckeditor.js"></script>-->
<meta http-equiv="content-type" content="text/html charset=utf-8">
<meta name="author" content="PVA Pirat Production">
<meta name="keywords" content="Учебный портал, вебинары, новости, электронные курсы, база знаний, обучение">
<meta name="robots" content="index">
<meta name="revisit-after" content="1 days">
<meta name="description" content="Учебный портал, на котормо вы сможете пройти электронные курсы, прослушать вебинары и сдать обучение">
<link href="/myproject/template/learn/style.css" type="text/css" rel="stylesheet" />
<link href="/myproject/menu/main/style.css" type="text/css" rel="stylesheet" />
<link href="/myproject/menu/main_2/style.css" type="text/css" rel="stylesheet" />
<link href="/myproject/content/news/style.css" type="text/css" rel="stylesheet" />
<link href="/myproject/content/news/style2.css" type="text/css" rel="stylesheet" />
<link href="/myproject/module/ckeditor/contents.css" type="text/css" rel="stylesheet" />
<link href="/myproject/javascript/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/myproject/javascript/jquery.js"></script>

<script type="text/javascript" src="/myproject/javascript/jsgui.js"></script>
<script type="text/javascript" src="/myproject/module/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="/myproject/module/ckeditor/ckeditor_basic.js"></script>-->
<!--<script type="text/javascript" src="/myproject/module/ckeditor/ckeditor_basic_source.js"></script>-->
<!--<script type="text/javascript" src="/myproject/module/ckeditor/ckeditor_source.js"></script>-->
<!--<script type="text/javascript" src="/myproject/module/ckeditor/config.js"></script>-->
<title>Учебный портал</title>
</head>
<body>
	<form method="post">
			<table width="80%" align="center">
				<tr>
					<td height="20px;"></td>
				</tr>
				<tr>
					<td>
<div style="background-color:#ECE9C1;border-top: solid 1px #000000;border-left: solid 1px #000000;border-right: solid 1px #000000;height:10px;"></div>
<div style="font-size: 19px;color: #4E0000;text-align:center;background-color:#ECE9C1;border-left: solid 1px #000000;border-right: solid 1px #000000;">Добавить запись</div>
<div style="background-color:#ECE9C1;border-bottom: solid 1px #000000;border-left: solid 1px #000000;border-right: solid 1px #000000;height:10px;"></div>
					</td>
				</tr>
<tr>
<td>
<table width="100%">
<tr>
<td width="100px;">Название записи: </td>
<td>
<input type="text" value="" name="blogname" style="width:100%">
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td height="10"></td>
</tr>
				<tr>
					<td>
			<textarea id="editor1" name="editor1"></textarea>
			<script type="text/javascript">
				CKEDITOR.replace( 'editor1' );
			</script>
					</td>
				</tr>
<tr>
<td height="10"></td>
</tr>
<tr>
<td align="right">
<input type="submit" value="Сохранить">
</td>
</tr>
			</table>
	</form>
</body>
</html>