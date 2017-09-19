<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/common/classes/AdminBoard.php" ?>

<?php
	extract($_REQUEST);

	$arr = explode(".", $cmd);
	
	/* CMD Check */
	if(sizeof($arr) != 2)
		echo "CMD format is incorrect";
	else {
		
		$clsNm = $arr[0];
		$mtdNm = $arr[1];
		
		//클래스 생성 / 인스턴스 생성 / REQUEST 전달
		$obj = new ReflectionClass($clsNm);
		$obj = $obj->newInstance($_REQUEST);
		

		//생성된 메소드 실행
		$method = new ReflectionMethod($clsNm, $mtdNm);
		
		echo $method->invoke($obj);
		
	}

	
?>

