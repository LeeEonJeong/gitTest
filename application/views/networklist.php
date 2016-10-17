
<span style="display:none" id="where" >network</span>

<!--  네트워크검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>네트워크 검색하기</h5>
				<form>
					<div id="custom-search-input">
						<select>
							<option>전체</option>
							<option>KOR-Central A</option>
							<option>KOR-Central B</option>
							<option>KOR-HA</option>
							<option>KOR-Seoul M</option>
							<option>JPN</option>
						</select> <input type="text" class="input-medium search-query"
							placeholder="검색할 서버명을  입력해 주세요." />
						<span class="input-group-btn">
							<button type="submit">
								<i class="icon-search fa-10x"></i> 검색
							</button>
						</span> 
					</div> 
				</form>
			</div>
			<div class="span5" >
			<div class="nav pull-right">
				<br><br> 
					<a class="btn btn-primary" href="/project1/index.php/orderCloud">IP 추가 신청</a> 
			</div> 
			</div>
		</div>
	</div>

<script>
$( 
//-----------------------------
		function (){
			$('#firewallinfo').hide();
		 	$('#portforwardinginfo').hide();
		 	$('#publicipinfo').hide();
		  
		  
			$("#networklist_table tr").click(function(){
				 	//publicip = $(this).find('form').val();
				 	$('#firewallinfo').hide();
				 	$('#portforwardinginfo').hide();
				 	$('#publicipinfo').show(); 
				 	
				 	$('#firwallMenu').removeClass('active');
				 	$('#portforwardingMenu').removeClass('active');
				 	
				 	
				 	form = $(this).find('form');
				 	var formData = form.serialize(); 
				 	$.ajax({
						type : "POST",
						url: 'http://localhost/project1/index.php/networklist/getPublicIpInfo',
						data : formData,
						dataType:'json',
						success : function(publicip){
							$('#selectipaddress').html(publicip.ipaddress);
							$('#selectipaddressid').html(publicip.id);
							$('#zoneid').html(publicip.zoneid);
							$('#publicipinfo #ipaddress').html(publicip.ipaddress);
							$('#publicipinfo #id').html(publicip.id);
							$('#publicipinfo #allocated').html(publicip.allocated);
							$('#publicipinfo #state').html(publicip.state);
						},
						error : function( ){  
							alert('실행실패');
						}
				 	});
				});

			$('#firwallMenu').click(function(){
			 	$('#portforwardinginfo').hide();
			 	$('#publicipinfo').hide();
			 	$('#firewallinfo').show();
			 	$('#firewallinfo_table tbody').remove(); 
				$('#firwallMenu').addClass('active');
				$('#portforwardingMenu').removeClass('active');
			 	
				selectipaddressid = $('#selectipaddressid').text(); 
				
				$.ajax({
					type:"POST",
					url: 'http://localhost/project1/index.php/networklist/getlistFireWallInfoByIpAddress',
					data : {'ipaddressid' : selectipaddressid},
					dataType:'json',
					success : function(firewallrules){
// 						alert(firewallrules.count);
// 						alert(firewallrules.firewallrule[0].id);
					 
						$('#firewallinfo_table').append('<tbody></tbody>');
							
						for(i=0; i<firewallrules.count; i++){
							firewallrule = firewallrules.firewallrule[i];
							$('#firewallinfo_table tbody').append(
									$('<tr></tr>').append(
										$('<td></td>').html(firewallrule.cidrlist)).append(
										$('<td></td>').html(firewallrule.protocol)).append(
										$('<td></td>').html(firewallrule.startport)).append(
										$('<td></td>').html(firewallrule.endport)).append(
										$('<td></td>').html("<a href=''>수정</a>  |  <a href='' style='color:red'>삭제</a>")
									)
							);
												
						}
					},
					error : function( ){  
						alert('실행실패');
					}
				});
			});


			$('#portforwardingMenu').click(function(){
					$('#firewallinfo').hide();
				 	$('#publicipinfo').hide();
				 	$('#portforwardinginfo').show();
				 	$('#portforwardinginfo_table tbody').remove(); 
				 	$('#serverlist').children().remove(); 
				 	$('#portforwardingMenu').addClass('active');
					$('#firwallMenu').removeClass('active');


					selectipaddressid = $('#selectipaddressid').text();
					zoneid = $('#zoneid').text();
				 
					$.ajax({
						type:"POST",
						url: 'http://localhost/project1/index.php/networklist/getlistPortForwardingRulesByIpAdress',
						data :  { "ipaddressid": selectipaddressid},
						dataType:'json',
						success : function(portforwardingrules){
	 						//alert(portforwardingrules.count);
//	 						alert(portforwardingrules.firewallrule[0].id);
						 	 
							$('#portforwardinginfo_table').append('<tbody></tbody>');
								
							for(i=0; i<portforwardingrules.count; i++){
								portforwardingrule = portforwardingrules.portforwardingrule[i];
							 
								$('#portforwardinginfo_table tbody').append(
										$('<tr></tr>').append(
											$('<td></td>').html(portforwardingrule.virtualmachinedisplayname)).append(
											$('<td></td>').html(portforwardingrule.publicport+' - '+portforwardingrule.publicendport)).append(
											$('<td></td>').html(portforwardingrule.privateport+' - '+portforwardingrule.privateendport)).append(
											$('<td></td>').html(portforwardingrule.protocol)).append(
											$('<td></td>').html('')).append(		
											$('<td></td>').html("<a href=''>수정</a>  |  <a href='' style='color:red'>삭제</a>")
										)
								);
													
							}
						},
						error : function( ){  
							alert('실행실패');
						}
					});

					$.ajax({
						type:'GET',
						url:'http://localhost/project1/index.php/cloudlist/getVMsByZoneId/'+zoneid,
						dataType: 'json',
						success : function(vms){
							for(i=0; i<vms.length; i++){
								vm=vms[i];
								$('#serverlist').append(
										$('<option>/option').attr({
											'value' : vm.displayname,
											'id' : vm.id
										}).html(vm.displayname)
								);
							}
						},
						error : function( ){  
							alert('실행실패');
						}
					});
				 	
			});


		$('#createportforwardingbtn').click(
			function(){
				selectipaddressid = {name : 'ipaddressid', value : $('#selectipaddressid').text()};
				virtualmachineid = {name : 'virtualmachineid', value : $('#serverlist option:selected').attr('id')};
				protocol = {name : 'protocol', value : $('#protocol option:selected').val() };
 
				form = $('#createportforwardingform');
			 	var formData = form.serializeArray(); 
	
			 	formData.push(selectipaddressid,virtualmachineid,protocol);

// 				for(i=0; i<formData.length; i++){
//  				showObj(formData[i]);
// 				} 
 
				$.ajax({
					type:'POST',
					url: 'http://localhost/project1/index.php/networklist/createPortForwarding',
					data : formData,
					dataType:'json',
					success : function(publicip){
						alert('실행성공');
						$('#result').text(publicip);
					},
					error : function( ){  
						alert('실행실패');
					}
				});
			}

			
		);
		
		function showObj(obj){
			var str="";
			for(key in obj){
				str  += key+"="+obj[key]+"\n";
			}
			alert('showObj\n'+str);
			return;
		}
}
//-----------------------------			
);  
</script>
<div id='result'></div>
<!-- 네트워크목록-->
 
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" >
				<h5>네트워크목록 (총 <?= $publicIpCount?>건)</h5>
				<table class="table table-hover" id="networklist_table">
					<thead>
						<tr>
							<td>번호</td>
							<td>공인IP</td>
							<td>위치</td>
							<td>설명</td>
						</tr>
					</thead>
					<tbody>
		<?php
	 
		for($i = 0; $i < $publicIpCount; $i ++) {
			if ($publicIpCount == 1) {
				$publicIp = $publicIps['publicipaddress'];
			} else {
				$publicIp = $publicIps['publicipaddress'][$i];
			}
			 
			echo "<tr><form><td>";
			echo "<input type='hidden' name='publicip' value='" . $publicIp ['id'] . "'/>";
			echo $i + 1;
			echo "</td><td>";
			echo $publicIp ['ipaddress'];
			echo "</td> <td>";
			echo $publicIp ['zonename']; 
			echo "</td><td></td></form></tr>";
			 
		}
		?>
		</tbody>
				</table>
			</div>
		</div>
</div>

<!-- 서버관리메뉴 와 서브정보 -->
<div class="container-fluid">
	 <div class="row-fluid"> 