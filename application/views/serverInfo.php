<div class="span10">
	<!-- 서버정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<span></span>
			<div class="span12" id='serverinfodiv'> 
				<br>
				<table id="serverinfo_table" class="table table-condensed" >
				 	<tr>
				 		<th class="subtitle">인스턴스명</th>
				 		<th id='displayname'><?= $server[0]['displayname']?></th>
				 		<th class="subtitle">호스트명</th>
				 		<th id='hostname'><?= $server[0]['name']?></th>
				 	</tr>
				 	<tr>
				 		<th class="subtitle">서버 ID</th>
				 		<th colspan="3" id='vmid'><?= $server[0]['id']?></th>
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">내부주소</th>
				 		<th id='nic_ipaddress'><?= $server[0]['nic']['ipaddress']?></th>
				 		<th class="subtitle">외부주소</th>
				 		<th id='nic_netmask'><?= $server[0]['nic']['netmask']?></th>
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">운영체제</th>
				 		<th id='templatename'><?= $server[0]['templatename']?></th>
				 		<th class="subtitle">데이터센터</th>
				 		<th id='zonename'><?= $server[0]['zonename']?></th>
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">CPU/메모리</th>
				 		<th id='serviceofferingname'><?= $server[0]['serviceofferingname']?></th>
				 		<th class="subtitle">생성시간</th>
				 		<th id='created'><?= $server[0]['created']?></th>
				 	</tr>
				 	<tr>
				 		<th class="subtitle">상태</th>
				 		<th colspan="3" id='state'><?= $server[0]['state']?></th>
				 	</tr>
				 					 	 
				</table>
			</div>
			
			
			<div class="span12" id='servervolumeinfodiv'>
				<br>
				<table id="servervolumeinfo_table" class="table table-condensed" >
					<thead>
						<tr>
							<th class="subtitle"></h>
							<th class="subtitle">이름</th>
							<th class="subtitle">타입</th>
							<th class="subtitle">용량</th>
							<th class="subtitle">생성일시</th> 
						</tr>
					</thead>
				 	<tbody>
				 	</tbody>
				</table>
			</div>
	</div>