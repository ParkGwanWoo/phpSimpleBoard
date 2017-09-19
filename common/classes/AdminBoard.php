<?php include "DB.php"; ?>

<?php

	class AdminBoard extends DB {
		var $req;
		function __construct($req) {
			
			$this->req = $req;
			extract($this->req);
			// echo "<script>console.log( 'Debug Objects: " . $this->req . "' );</script>";
			$this->db = $this->connect_db($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
		}
		
		function getPostCount() {
			$sql = "SELECT COUNT(*) FROM BOARD";
			$res = mysqli_query($this->db, "$sql");
			mysqli_query($this->db);
			$result = mysqli_fetch_row($res);
			return $result[0];
		}
		
		/* getPostList */
		function getPostList() {
			$cnt = $this->getPostCount();
			$page = $this->req['page'];
			$list = 10; //get post count

			$limit = ($page - 1) * $list;
			$sql = "SELECT *FROM BOARD order by no desc limit $limit, $list"; //Desending Sort
			
			$result = mysqli_query($this->db, "$sql");
			mysqli_close($this->db);
			
			$dataArr = [];
			while($row = mysqli_fetch_assoc($result)) {
				$data = Array("NO"=>$row["NO"], "TITLE"=>$row["TITLE"], "CONTENTS"=>$row["CONTENTS"], 						 							"DATES"=>$row["DATES"],"HIT"=>$row["HIT"]);
				
				array_push($dataArr, $data);
			}
			return json_encode($dataArr);
		}
	
		function writePost() { /* Write Post */
			/*
			extract($this->req);
			*/
			$inputTitle = $this->req["inputTitle"];
			
			$inputContents = $this->req["inputContents"];
			// 업로드 부분 구현하면됨.
			
			$uploaddir = 'images/';
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
			
			$tempfile =  $_FILES['userfile']['tmp_name'];
			
			move_uploaded_file($tempfile, $uploadfile);
			
			$sql = "INSERT INTO BOARD (TITLE, CONTENTS, DATES, IMG_PATH) VALUES ('$inputTitle','$inputContents',now(),'$uploadfile')";
			
			
			mysqli_query($this->db,"$sql");
			
			mysqli_close($this->db);
			
			return json_encode(Array("title"=>"$inputTitle", "contents"=>"$inputContents", "img_path"=>"$uploadfile"));
		
		 }
		
		function delPost() { /*Delete Post */
			$noArr = explode(",", $this->req["NO"]);
			
			for($i = 0; $i<sizeof($noArr); $i++) {
				$sql = "SELECT IMG_PATH FROM BOARD WHERE NO = $noArr[$i]";
				$row = mysqli_fetch_assoc(mysqli_query($this->db, "$sql"));
				$img_path = $row['IMG_PATH'];
				unlink("$img_path");
				
				$sql = "DELETE FROM BOARD WHERE NO = $noArr[$i]"; // delete post
				mysqli_query($this->db, "$sql");
				
				$sql = "DELETE FROM comment WHERE bid = $noArr[$i]"; //delete comment
				mysqli_query($this->db, "$sql");
				
			}
			
			mysqli_close($this->db);
		}
		
	
		function modifyPost() { /* modifyPost */
			$inputTitle = $this->req["inputTitle"];
			$inputContents = $this->req["inputContents"];
			$num = $this->req["NO"];
		
			$img_path = 'images/'.$_FILES['userfile']['name'];
			$tempfile = $_FILES['userfile']['tmp_name'];
			move_uploaded_file($tempfile, $img_path);
			
			$sql = "UPDATE BOARD SET TITLE = '$inputTitle', CONTENTS = '$inputContents', IMG_PATH = '$img_path' WHERE NO = $num";
			mysqli_query($this->db, "$sql");
			mysqli_close($this->db);
		
			
		}
		
		function writeComment() { /* write Comment */
			$no = $this->req['no'];
			$author = $this->req['author'];
			$comment = $this->req['comment'];
			
			$sql = "INSERT INTO comment values(null,'$no', '$author', '$comment')";
			mysqli_query($this->db, "$sql");
			mysqli_close($this->db);
			
			//수정시작
			return json_encode(Array("author"=>$author, "comment"=>$comment));
		}
		
		function getComment() { /* getComment */
			$b_no = $this->req['no'];
			
			$sql = "SELECT *FROM comment where bid=$b_no";
			$result = mysqli_query($this->db, "$sql");
			$dataArr = [];
			
			while($row = mysqli_fetch_assoc($result)) {
				$data = Array("id"=>$row['id'], "b_id"=>$b_no, "author"=>$row['author'], "comment"=>$row['comment']);
				array_push($dataArr, $data);
			}
			
			mysqli_query($this->db);
			return json_encode($dataArr);
		}
		
		function deleteComment() { /* deleteComment */
			$cid = $this->req['cid'];
			$bid = $this->req['bid'];
			
			$sql = "DELETE FROM comment WHERE id=$cid and bid=$bid";
			
			mysqli_query($this->db, "$sql");
			mysqli_close($this->db);
			
		}

		
	}
?>
<?php
// $obj = new AdminBoard($_REQUEST);
// $obj->modifyPost();
?>