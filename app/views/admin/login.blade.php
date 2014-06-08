<html>
<head>
	<title>客服登录--透视宝</title>
</head>
<body>
		{{ Form::open(array('url'=>'/login'))}}
		<table cellpadding="8">
			<tr>
				<td>Email:</td>
				<td><input type="text" name="admin_email" /></td>
			</tr>
			<tr>
				<td>密 码:</td>
				<td><input type="password" name="admin_pass" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="登录"/></td>
			</tr>
		</table>
		{{ Form::close() }}
</body>
</html>		
