<?php 
	$no = $_REQUEST['no'];
	$obj = new AdminBoard($_REQUEST);
	
	$result = $obj->getComment();
	$commentList = json_decode($result);


?>
<link rel="stylesheet" href="/phpBoard/web/inc/css/comment.css">
<div>
	

<div class="container">
	<div class="row" style="display:block; padding-top:20px;">
		<input type="hidden" name="check" value="<?=$no?>">
		<?php for($i=0; $i<sizeof($commentList); $i++) {  $row = $commentList[$i]; $comment = str_replace("\r\n", "<br>", $row->comment); ?>
		 <div class="media comment-box" style="width: 100%;">
            <div class="media-left">
                <a href="#">
                    <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?=$row->author?><span style="float:right;">
					
					<input type="button" id="<?=$row->id?>" class="btn btn-defualt btn-del" value="del"
					style="padding-top: 0px; padding-bottom: 0px;" />
					
					</span></h4>
				<input type="hidden" name="cid" value="<?=$row->id?>">
				<input type="hidden" name="bid" value="<?=$row->b_id?>">
                <p id="commId"><?=$comment?></p>
            </div>
        </div>
		
		<?php } ?>
		
		
	</div>
</div>
	
	</div>