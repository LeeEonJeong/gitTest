
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
div.container {
	 
	width: 300px;
	height : 100px;
	margin: 10% auto;
}
div.content{
	 
	margin : 5px auto;
	width : 80%;
	height : 80%;
}
</style>
<title>login페이지</title>
</head>
<body>

	<div class="container">
		<div class="content">
			<form action="login.php" method="post">
				<table>
					<tr>
						<td>아이디</td>
						<td><input type="text" name="loginid" /></td>
					</tr>
					<tr>
						<td>비밀번호</td>
						<td><input type="text" name="loginpwd" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="로그인" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

</body>
</html>