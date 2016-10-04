<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<?php 
	$loginid = $_POST["loginid"];
	$loginpwd = $_POST["loginpwd"];
	
	if(!$loginid){
		echo "<script> window.alert('아이디 입력하세요.'); history.go(-1); </script>";
		exit;
	}
	if(!$loginpwd){
		echo "<script> window.alert('비밀번호 입력하세요.'); history.go(-1); </script>";
		exit;
	}
	
	include 'dbconn.php';
	
	$sql = "SELECT * FROM eonjeong_db_test.member where id='".$loginid."'";
	$result = mysqli_query($conn, $sql);
	 
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		 
		$userpwd = $row [pwd];
		
		echo '비밀번호 : '.$userpwd.'<br>';
		
		if($userpwd != $loginpwd){
			echo ("
				<script>
					alert('비밀번호가 일치하지 않습니다.');
					history.go(-1);
				</script>
			");
			exit;
		}
		
		$userid = $row [id];
		
		$userapikey = $row [apikey];
		$usersecretkey = $row [secretkey];
		
		$_SESSION ['userid'] = $userid;
		$_SESSION ['userapikey'] = $userapikey;
		$_SESSION ['usersecretkey'] = $usersecretkey;
		
// 		include 'printArray.php';
// 		myPrint($_SESSION);
		 
		echo ("
              <script>
                location.href = './Server/index.php';
              </script>
         ");
	}else{
		echo "<script> alert('해당 아이디가 존재하지 않습니다.'); history.go(-1);</script>";
	}
	
	
?>
</head>
<body>
 </body>
</html>