<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link
	href="http://localhost/project1/static/lib/bootstrap/css/bootstrap.min.css"
	rel="stylesheet" media="screen">
<link
	href="http://localhost/project1/static/lib/bootstrap/css/bootstrap-responsive.css"
	rel="stylesheet">
<link href="http://localhost/project1/static/css/style.css"
	rel="stylesheet">
 
<script src="//code.jquery.com/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php if($this->session->flashdata('message')) { 
	echo "message : ".$this->session->flashdata('message');?>
		<script>
			alert("<?= $this->session->flashdata('message')?>");
		</script>
<?php }?>
 
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <!-- response navbar -->
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
     			</a>
				 
				<!-- Be sure to leave the brand out there if you want it shown --> 
				
      			<a class="brand" href="#">Cloud Console</a>
      			
      			 <!-- Everything you want hidden at 940px or less, place within here -->
			      <div class="nav-collapse collapse">
			        <ul class="nav pull-right"> <!-- 오른정렬 -->
			        	<?php
			        	if($this->session->userdata('is_login')){
			        	?>
			        		<li><a href="/project1/index.php/auth/logout">로그아웃</a></li>
			        	<?php
			        	} else {
			        	?>
			        		<li><a href="/project1/index.php/auth/login">로그인</a></li>
			        		<li><a href="/project1/index.php/auth/register">회원가입</a></li>
			        	<?php
			        	}
			        	?>
			        </ul>				        
			      </div>
			</div>
		</div>
	</div>
	
	<script>
	$(
		function(){
			where = $('#where').text();
			if(where=='cloudlist'){ 
				$('.nav-tabs #cloudlist').css('background-color',' #f4f4f4');
			}else if(where=='network'){
				$('.nav-tabs #network').css('background-color',' #f4f4f4');
			}else if(where=='diskvolume'){
				$('.nav-tabs #diskvolume').css('background-color',' #f4f4f4');
			}else if(where=='nasvolume'){
				$('.nav-tabs #nasvolume').css('background-color',' #f4f4f4');
			}
		}
 
	);
	</script> 
	 
		<ul class="nav nav-tabs" id='menuTab'  role="tablist" >
		  <li id='cloudlist' ">
		    <a href="/project1/index.php/cloudlist">클라우드리스트</a>
		  </li>
		  <li id="diskvolume" ><a href="/project1/index.php/volumelist">디스크볼륨</a></li>
		  <li id='network'  ><a href="/project1/index.php/networklist">네트워크</a></li>
		  <li id="nasvolume"><a href="/project1/index.php/naslist">NAS 볼륨</a></li>
   		</ul> 
   <div class="container-fluid">
	 <div class="row-fluid"> 