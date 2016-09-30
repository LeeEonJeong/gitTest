<?php
	include('../printArray.php');
	include('../refer/callAPI.php');
	include('../api_constants.php');
	
	function getListAvailableProductTypes(){
		$cmdArr = array(
				"command" => "listAvailableProductTypes",
				"apikey" => API_KEY
		);
		 
		$result = callCommand(URL, $cmdArr, SECERET_KEY);
	 	 
		//myPrint($result); //x : count, producttypes
		
		return $result;
	}
	
	
	//condition(ex. templateid)별로 구별하기 (os종류 구별)
	function sortProductTypes($condition){
		$listProductTypes = getListAvailableProductTypes();		
		$count= $listProductTypes['count'];
		
		$result = array(); //condition별로 구별 (x : condition, x_value : producttype)
		 
		$oldValue="";
		$index=0;
		
		for($i=0; $i<$count; $i++){ //종류별로 구별되어 순서데로 나타난다는 가정
			$productType = $listProductTypes['producttypes'][$i];
	
			$currentValue = $productType[$condition];
	
			if($currentValue != $oldValue){
				$index=0;
			}
			$oldValue = $currentValue;
			$result[$currentValue][$index++] = $productType;
		}
		
		return $result;
	}
	
	
	function  getProductTypes($condition, $value){ //condition이 value인 값을 가진 productType들 가져오기
		$listProducts = sortProductTypes($condition); //condition에 따라 일단 구분
		
		foreach($listProducts as $conditionValue => $productTypes){
			if($conditionValue == $value)		
				return $productTypes;
		}
	}
	
	function sortArray($condition, $array){ //파라미터로 온 배열 중에서 해당 condition에 따라 구별하기 //???depth에 따라 다름
		$result = array(); //condition별로 구별 (x : condition, x_value : producttype)
			
		$oldValue="";
		$index=0;
		
		
		foreach($array as $x => $x_value){
			foreach($x_value as $y => $y_value){
				$productType = $y_value; //여기서는 일단 productType
				
				$currentValue = $productType[$condition];
				
				if($currentValue != $oldValue){
					$index=0;
				}
				$oldValue = $currentValue;
				$result[$currentValue][$index++] = $productType;
			}
		} 
		return $result;
	}
	
	function getProduct($templateid, $zoneid, $serviceofferingid){
		$productTypes = getProductTypes('templateid',$templateid);
// 		myPrint($productTypes);
// 		echo'<br>======<br>';
		
		foreach($productTypes as $index => $productType){
			if($productType['zoneid'] == $zoneid && $productType['serviceofferingid'] == $serviceofferingid){
				return $productType;
			}
		}
	}
	
	//myPrint( getProductTypes('templateid','b0e51172-fb70-467e-a1f8-e9659fb3eaaf'));
	//myPrint(getProduct('b0e51172-fb70-467e-a1f8-e9659fb3eaaf','eceb5d65-6571-4696-875f-5a17949f3317','6e61c63c-6204-4522-ad23-6894512083c4'));
	//myPrint(getListAvailableProductTypes());
	// myPrint(getProductTypes('templateid','a57d10ec-9588-436f-bbb5-8a68eadf2254'));
?>