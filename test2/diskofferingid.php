<?php
	function getDiskOfferingId($capacity){
		/*
		 * usageplantype(약정정보 파라미터)에 따른 각 상품의 가격 정보는 ucloudbiz site 에서 확인 가능하다.   
		 */
		//[10GB 단위 용량] : standard, premium 공통으로 적용 가능
		$diskofferingidArray = array('10'=>'1539f7a2-93bd-45fb-af6d-13d4d428286d', 
				'20' => '64ba2191-b22a-42a2-aaab-075b0235ac18',
				'30' => 'd4fc0ff3-91ee-40af-a2f3-9ec0eb4773f8',
				'40' => 'a7bbe834-c195-45ed-a668-2e4aadf0adb7',
				'50' => '277d1cea-d51a-4570-af16-0b271795d2a0',
				'60' => '2791cad6-b68a-4412-8867-ca07e5d64ae4',
				'70' => '698adf24-7ae2-4100-af56-a35ecd7bd67c',
				'80' => '78fe5777-8903-4193-bada-ee8686bc543a',
				'90' => '4df2364f-1548-4d42-9d66-25fc3a195c5c',
				'100' => 'ef334e6f-f197-4988-9781-86c985e82591',
				'110' => 'e91d8b54-28c3-43a7-b3a4-439ced6fe282',
				'120' => 'b67fea21-0360-4072-8877-815e9254ab73',
				'130' => 'b825b79c-7f31-47f8-b886-ed355253c9e9',
				'140' => '40f5cd46-ec3e-4ca3-9df5-f55d590149a1',
				'150' => 'dc4ec8a0-c0f6-46af-a475-9fcec21bc2fa',
				'160' => '227ad57a-336f-48dd-8338-68094e6bdef9',
				'170' => '2b034310-4309-4f43-8e78-c94445c70783',
				'180' => 'd02fc827-2c52-423d-9a6c-d324e0fbb021',
				'190' => 'ec59a93f-36bd-43d0-abe7-af70d97d8b1b',
				'200' => 'cbe4ccad-be3a-43f6-9abd-d2b6d7097e40',
				'210' => 'dc467090-6649-43b2-abd0-4d8ea52d5f49',
				'220' => '2527cce9-1b7a-4b4e-b6df-568c4a67678c',
				'230' => '95da4d30-f215-47ad-b7b8-11ae3a055e03',
				'240' => 'a70e745c-ef31-4fbb-a62b-ff5af031f8a1',
				'250' => 'e3782b90-3780-4c2c-85a1-48ccf304590e',
				'260' => '600a22dc-8955-4fc6-a9d6-516c8db1ac5a',
				'270' => 'bb0227cf-9ef6-4005-bd27-666f49481003',
				'280' => 'c96b005c-81a3-46ca-ad63-96cd271faf6b',
				'290' => '1c7521b1-8753-427b-874b-a740e6e0184d',
				'300' => '03ee7edf-a91f-4910-9e1c-551222bc6e94'
		);
		
		return $diskofferingidArray[$capacity];
	}
	
	echo getDiskOfferingId('60');
?>