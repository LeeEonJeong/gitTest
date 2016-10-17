<span style="display:none" id="where" >cloudlist</span>
 
<!-- <form class="form-search"> -->
<!--   <input type="text" class="input-medium search-query" placeholder="검색할 서버명"> -->
<!--   <button type="submit"><i class="icon-search"></i></button> -->
<!-- </form> -->
<script>
 
</script>
<!-- 서버검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>서버검색하기</h5>
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
					<a class="btn btn-primary" href="/project1/index.php/orderCloud">서버 생성하기</a> 
			</div> 
			</div>
		</div>
	</div>

<script>
$(
	
		function(){ 
			$('#serverinfodiv').hide();
			$('#servervolumeinfodiv').hide();
			$('#serverinfodiv').prev('span').text('서버를 선택해 주세요.');	

			$('#serverlist_table tbody tr').each(
				function(index){ 
					vmstate = $('#state'+index).text();

					switch(vmstate){
						case 'Running':				
							$('#'+index+'start').button('loading').val('시작');
							$('#'+index+'stop').button('reset');
							$('#'+index+'reboot').button('reset');
							break;
						case 'Stopped':
							$('#'+index+'start').button('reset');
							$('#'+index+'stop').button('loading').val('정지');
							$('#'+index+'reboot').button('loading').val('재부팅');
							break;
						default : //Starting , Stopping
							$('#'+index+'start').button('loading').val('시작');
							$('#'+index+'stop').button('loading').val('정지');
							$('#'+index+'reboot').button('loading').val('재부팅');
							break;
					}
				}
			);
			
			
			$(":button").click(	
				function(){
				    name = $(this)[0].id;
				    formindex = name.replace(/[^0-9]/g,"");
					action = name.substring(1);
					var formData = $("#form"+formindex).serialize();
					alert(formData);
					$('#result').html('통신중...');
					if(action=='start'){
						$.ajax({
								type : "POST",
								url: 'http://localhost/project1/index.php/cloudlist/startVM',
								data : formData,
								success : function(){
									alert(action+'실행성공');
									$('#state'+formindex).html('Running');
								},
								error : function( ){  
									alert(action+'실행실패');
									$('#result').html('통신실패');
								}
						}); 
					}else if(action == 'stop'){
						$.ajax({
								type : "POST",
								url: 'http://localhost/project1/index.php/cloudlist/stopVM',
								data : formData,
								success : function(){ 
									alert(action+'실행성공');
									$('#state'+formindex).html('Stopped');
								},
								error : function( ){ 
									alert(action+'실행실패');
									$('#result').html('통신실패');
								}
						}); 
					}else if(actino == 'reboot'){
						
				}  
		});

		$('#serverlist_table tr').click(
				function(){
					$('#serverinfodiv').show();
					$('#servervolumeinfodiv').hide();
					$('#serverinfodiv').prev('span').empty();
					
					$('#serverinfoMenu').addClass('active');
					$('#diskinfoMenu').removeClass('active');
					
				    formindex =$(this).index();
					formdata = $("#form"+formindex).serializeArray()[0]; //어차피하나(vmid)
					vmid = formdata['value']; 
					
 					$.ajax({
 	 					type:"GET",
 	 					url:"http://localhost/project1/index.php/cloudlist/searchVM/"+vmid,
 	 					dataType:'json',
 	 					success:function(data){
 	 	 					vm = data.virtualmachine;
 	 	 					 
 	 	 					$('#serverinfodiv').prev('span').html("<h5>선택된 서버 : <span id='selectvmid' style='display:none'>"+vm.id+"</span>" + vm.displayname + "</h5>");
 	 						
 	 	 					$('#displayname').html(vm.displayname);
 	 	 					$('#hostname').html(vm.name);
 	 	 					$('#vmid').html(vm.id);
 	 	 					$('#nic_ipaddress').html(vm.nic.ipaddress);
 	 	 					$('#nic_netmask').html(vm.nic.netmask);
 	 	 					$('#templatename').html(vm.templatename);
 	 	 					$('#zonename').html(vm.zonename);
 	 	 					$('#serviceofferingname').html(vm.serviceofferingname);
 	 	 					$('#created').html(vm.created);
 	 	 					$('#state').html(vm.state);
 	 					},
 	 					error:function(){
 	 	 					alert('수행실패');
 	 					}
					});
				}
		);

		$('#serverinfoMenu').click(
				function(){
					$('#serverinfoMenu').addClass('active');
					$('#diskinfoMenu').removeClass('active');
					$('#serverinfodiv').show();
					$('#servervolumeinfodiv').hide();
					//selectserver = $('#serverinfodiv').prev('span').find('#selectvmid').text();
				}
		);
			 

		$('#diskinfoMenu').click(
			function(){
				$('#serverinfoMenu').removeClass('active');
				$('#diskinfoMenu').addClass('active');
				
				$('#serverinfodiv').hide();
				$('#servervolumeinfodiv').show();
				
				selectvmid = $('#serverinfodiv').prev('span').find('#selectvmid').text();

				$.ajax({
	 					type:"GET",
	 					url:"http://localhost/project1/index.php/volumelist/getVolumes/"+selectvmid,
	 					dataType:'json',
	 					success:function(data){
		 					$('#servervolumeinfo_table tbody').empty();
	 	 					count = data.count; 
	 	 					volumes = data.volume;
// 	 	 					$('#result').html(data);
	 	 					
	 	 					for(i=0; i<count;i++){
								volume = volumes[i];
								 
								datadisk = parseFloat(volume.size) / 1073741824 ;
							 
	 	 						$('#servervolumeinfo_table tbody').append($('<tr></tr>'));
	 	 						lasttr = $('#servervolumeinfo_table tbody tr:last');
	 	 						lasttr.append($('<td></td>').html(i+1));
	 	 						lasttr.append($('<td></td>').html(volume.name));
	 	 						lasttr.append($('<td></td>').html(volume.type));
	 	 						lasttr.append($('<td></td>').html(datadisk+' GB'));
	 	 						lasttr.append($('<td></td>').html(volume.created));
	 	 						 
	 	 					} 
 
	 					},
	 					error:function(){
	 	 					alert('수행실패');
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
}); 

 
</script>
<div id='result'></div>
<!-- 서버목록 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12"> 
				<h5>서버목록 (총 <?= $vmcount?>건)</h5>
				<table id="serverlist_table" class="table table-hover" >
					<thead>
						<tr>
							<td>번호</td>
							<td>계정명(displayname)</td>
							<td>운영체제(templatedisplaytext)</td>
							<td>데이터센터(zonename)</td>
							<td>생성시간(created)</td>
							<td>상태(state)</td>
							<td>제어</td>
						</tr>
					</thead>
					<tbody>
		<?php
	 
		for($i = 0; $i < $vmcount; $i ++) {
			if ($vmcount == 1) {
				$vm = $clouds['virtualmachine'];
			} else {
				$vm = $clouds['virtualmachine'][$i];
			}
			 
			echo "<tr><form id='form".$i."' method='post'><td>";
			echo "<input type='hidden' name='vmid' value='" . $vm ['id'] . "'/>";
			echo $i + 1;
			echo "</td><td>";
			echo $vm ['displayname'];
			echo "</td> <td>";
			echo $vm ['templatedisplaytext'];
			echo "</td> <td>";
			echo $vm ['zonename'];
			echo "</td> <td>";
			echo $vm ['created'];
			echo "</td> <td id='state".$i."'>";
			echo $vm ['state'];
			echo "</td> <td>";
			echo "<input class = 'btn' id='".$i."start' type='button' value='시작'/>";
			echo "<input class = 'btn' id='".$i."stop'  type='button' value='정지'/>";
			echo "<input class = 'btn' id='".$i."reboot' type='button' value='재부팅'/>";
			echo "</td></form></tr>";
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