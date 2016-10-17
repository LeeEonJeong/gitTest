
<span style="display:none" id="where" >diskvolume</span>
<!--  네트워크검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>디스크 검색하기</h5>
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
							placeholder="검색할 디스크명을  입력해 주세요." />
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
					<a class="btn btn-primary" href="/project1/index.php/orderVolume">Disk 추가 신청</a> 
			</div> 
			</div>
		</div>
	</div>

<script>
$( 
//-----------------------------
		function (){ 
			$('#volumeinfodiv').hide();
			$('#volumeinfodiv').prev('span').text('디스크를 선택해 주세요.');		

			$('#volumelist_table tr').click(
					function(){ 
						$('#volumeinfodiv').show();
						$('#volumeinfodiv').prev('span').remove();
						$('#volumeinfoMenu').addClass('active');
						$('#selectvolume').html($(this).find('#volumename').text());

						volumeid = $(this).find('span').text(); 
						$.ajax({
							type:"GET",
	 	 					url:"http://localhost/project1/index.php/volumelist/searchVolume/"+volumeid,
	 	 					dataType:'json',
	 	 					success:function(data){
	 	 	 					volume = data.volume; 
	 	 	 					$('#name').html(volume.name);
	 	 	 					$('#volumeinfo_table #volumeid').html(volume.id);
	 	 	 					$('#disksize').html(volume.size / 1073741824 + ' GB');
	 	 	 					$('#created').html(volume.created);
	 	 	 					$('#state').html(volume.state);  //Allocated(분리?) Ready(붙어있는거?)
	 	 	 					if(volume.state == 'Ready')
	 	 	 						$('#vmdisplayname').html(volume.vmdisplayname);
	 	 	 					else
		 	 	 					$('#vmdisplayname').html('분리');
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
}
//-----------------------------			
);  
</script>
<div id='result'></div>
<!-- 네트워크목록-->
 
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" >
				<h5>디스크목록 (총 <?= $volumeCount?>건)</h5>
				<table class="table table-hover" id="volumelist_table">
					<thead>
						<tr>
							<td></td>
							<td>Disk명</td>
							<td>용량</td>
							<td>위치</td>
							<td>상태</td>
							<td>적용서버</td>
						</tr>
					</thead>
					<tbody>
						<?php
					 
						for($i = 0; $i < $volumeCount; $i ++) {
							if ($volumeCount == 1) {
								$volume = $volumes['volume'];
							} else {
								$volume = $volumes['volume'][$i];
							}
							
							$disksize = $volume['size'] / 1073741824;
					 
							echo "<tr><td>";
							echo "<span style='display:none' id='volumeid'>" . $volume ['id'] . "</span>";
							echo $i + 1;
							echo "</td><td id='volumename'>";
							echo $volume ['name'];
							echo "</td> <td>";
							echo $disksize.'GB';
							echo "</td> <td>";
							echo $volume ['zonename'];
							echo "</td> <td>";
							echo $volume ['state'];
							echo "</td> <td>";		 
							if($volume['state'] == 'Ready'){ 				
								echo $volume ['vmdisplayname']; 
							}else{
								 
							}
							echo "</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<!-- 볼륨상세 정보 -->
<div class="container-fluid">
	 <div class="row-fluid"> 