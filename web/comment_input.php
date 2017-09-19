<br>
<div class="container">
	<form id="comment_fm">
		<input type="hidden" name ="cmd" value="AdminBoard.writeComment"/>
		<input type="hidden" name="no" value="<?=$_REQUEST['no']?>"/>
	  <div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="author">
	  </div>

	  <div class="form-group">
		<label for="comment">Comment</label>
		<textarea class="form-control" rows="4" name="comment"></textarea>
	  </div>
	
	<input type="button" class="btn btn-primary btn-style" id="btn-comment" value ="Comment">
	</form>
</div>