<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/inc/php/header.php"; ?> <!-- header.php 추가 -->
<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/common/classes/AdminBoard.php"; ?> <!-- AdminBoard.php 추가 -->

<?php
	/* no 인자 받을시, 해당 no의 결과값을 받아옴 */

	$obj = new AdminBoard($_REQUEST);
	$no = $obj->req["no"];

	$ref = $obj->req['ref']; // 댓글작성시 ref 체크해서 조회수버그 방지
	// 조회수 올리는 쿼리
	if(!isset($ref)) {
		if(isset($no)) {
			$sql = "UPDATE BOARD SET HIT = HIT+1 WHERE NO = $no";
			mysqli_query($obj->db, "$sql");

		}
	}

	$sql = "SELECT *FROM BOARD WHERE NO= $no";
	$result = mysqli_query($obj->db, "$sql");
	
	$row = mysqli_fetch_assoc($result);
	$img = '/phpBoard/'.$row['IMG_PATH'];
	mysqli_close($obj->db);

?>
<script>
	$(document).ready(function() {
		$("#btn-write").click(function() {
			  if(confirm("Save it?")) {		  
				  $("#fm").ajaxSubmit({
					 url: '/phpBoard/action_front.php',
					 type: 'POST',
					 success: function(data) {
						 alert('saveComplete');
						 location.href = "/phpBoard/web/index.php";
					 }
				  });
			  }
		});
		
		$("#btn-modify").click(function() {
			
			if(confirm("Modify it?")) {
				$("[name='cmd']").val("AdminBoard.modifyPost");
				
				$("#fm").ajaxSubmit({
					url: "/phpBoard/action_front.php",
					type: "POST",
					success: function(data) {
						alert('Complete.');
						location.href = "/phpBoard/web/index.php";
					}
				});
			}
		});
		
	});
	
</script>
		<div class="container">
			<form enctype="multipart/form-data" id="fm"  method="POST">
				<input type="hidden" name="MAX_FILE_SIZE" value="9999999">
				<input type="hidden" name="cmd" value="AdminBoard.writePost" >
				<input type="hidden" name="NO" value="<?=$no?>">
				<div class="form-group">
					<label for="inputTitle">Title</label>
					<input type="text" class="form-control" id="inputTitle" name="inputTitle" placeholder="Enter Title" 							value= "<?=$row['TITLE']?>">

				</div>

				<div class="form-group">
					<label for="InputContents">Contents</label>		
					<textarea class="form-control" id="inputContents" name="inputContents" rows="10" placeholder="Enter Contents" spellcheck="false"><?=$row['CONTENTS']?></textarea><?php echo '<img class="img-responsive" src="'.$img.'">'; ?>
					
					
					
				</div>
				
				<div class="form-group">
					<input type="file" name="userfile">
					<input type="button" class="btn btn-info go-list btn-float" value="BACK">
					<?php if($no === NULL) {?>
					<input type="button" class="btn btn-primary btn-float" id="btn-write" value="Write Post">
					<?php }else { ?>
					<input type="button" class="btn btn-warning btn-float" id="btn-modify" value="Modify Post">
					<?php } ?>
					
				</div>
				
			</form>
			
		</div>
			
			<?php if($no != NULL) { ?>
			<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/web/comment.php"; ?> <!-- Comment.php 추가 -->
			<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/web/comment_input.php"; ?> <!-- Comment_input.php 추가 -->
			<?php } ?>


<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/inc/php/footer.php"; ?> <!-- footer.php 추가 -->