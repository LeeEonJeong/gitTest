<div class="span10">
<!-- 볼륨정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<span></span>
				<div class="span12" id='volumeinfodiv'>
					<h5>선택된 볼륨: <span id="selectvolume"></span></h5>
					<br>
					<table id="volumeinfo_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">Disk이름</th>
					 		<th id='name'></th>
					 		<th class="subtitle">Disk id</th>
					 		<th id="volumeid"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">용량</th>
					 		<th id='disksize'></th>
					 		<th class="subtitle">생성일시</th>
					 		<th id='created'></th>
					 	</tr>
					 	
					 	<tr>
					 		<th class="subtitle">상태</th>
					 		<th colspan="3" id='state'></th> 
					 	</tr> 
					 	<tr>
					 		<th class="subtitle">적용서버</th>
					 		<th colspan="3" id='vmdisplayname'></th> 
					 	</tr>
					</table>
				</div>
			</div>