<?php
	
	
	
	$type = $_GET['Type'];
	
	if($type == 1){
		
		$inputVar = $_GET['InputVar']; 
		$xmlurl="http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$inputVar;
		$xml=simplexml_load_file($xmlurl);
		
		foreach($xml->children() as $inputValue)
		{
			$symbolName = (string)$inputValue->Symbol . " - " . (string)$inputValue->Name;
			$values[]= array('value' => (string)$symbolName); 
		}       
		echo json_encode($values);
	
	}
	
	if($type == 0){
		$inputFixed = $_GET['InputFixed'];
		$xmlurl= "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=" . $inputFixed;
		$var_array =(json_decode(file_get_contents($xmlurl)));
	    $StockData = array();
		
		$StockData['Name'] = $var_array->Name;
		$StockData['Symbol'] = $var_array->Symbol;

		if($var_array->LastPrice)
			$StockData['LastPrice'] = round($var_array->LastPrice,2);
		else
			$StockData['LastPrice'] = $var_array->LastPrice;
		
		if($var_array->Change)
			$StockData['Change'] = round($var_array->Change,2);
		else
			$StockData['Change'] = $var_array->Change;
		
		if($var_array->Change > 0)
			$StockData['ChangeType'] = 0;
		else
			$StockData['ChangeType'] = 1;
			
		if($var_array->ChangePercent)
			$StockData['ChangePercent'] = round($var_array->ChangePercent,2);
		else
			$StockData['ChangePercent'] = round($var_array->ChangePercent,2);
			
		if($var_array->Timestamp)
			$realTime =  date('Y-m-d H:i A',strtotime($var_array->Timestamp));
		else 
			$realTime = " ";
		$StockData['Timestamp'] = $realTime;
		
		if($var_array->MarketCap){
			$disp_MarketCap = $var_array->MarketCap/(1000000000);
			
			if($disp_MarketCap < 0.01)
				$realMarketCap = round(($var_array->MarketCap/(1000000)),2);
			else
				$realMarketCap = round(($var_array->MarketCap/(1000000000)),2);
		}
		else
			$disp_MarketCap = " ";
		
		$StockData['MarketCap'] = $realMarketCap;
		if($disp_MarketCap < 0.01)
			$StockData['MarketType'] = "Million";
		else
			$StockData['MarketType'] = "Billion";
			
		$StockData['Volume'] = $var_array->Volume;

		if($var_array->ChangeYTD)
			$StockData['ChangeYTD'] = round($var_array->ChangeYTD,2);
		else
			$StockData['ChangeYTD'] = $var_array->ChangeYTD;

		if($var_array->ChangePercentYTD)
			$StockData['ChangePercentYTD'] = round($var_array->ChangePercentYTD,2);
		else
			$StockData['ChangePercentYTD'] = $var_array->ChangePercentYTD;

		if($var_array->High)
			$StockData['High'] = round($var_array->High,2);
		else
			$StockData['High'] = $var_array->High;

		if($var_array->Low)
			$StockData['Low'] = round($var_array->Low,2);
		else
			$StockData['Low'] = $var_array->Low;

		if($var_array->Open)
			$StockData['Open'] = round($var_array->Open,2);
		else
			$StockData['Open'] = $var_array->Open;

		$FinalData=json_encode($StockData);
		
		echo $FinalData;
	}
	
?>