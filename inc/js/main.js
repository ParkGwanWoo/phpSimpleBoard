$(document).ready(function(){
	//checkbox toggle
	$("[name='check_all']").click(function() {
		var toChcked = this.checked;
		$("[name='check_row']").each(function(i) {
			this.checked = toChcked;
		});
	});
	
	//search-text "" check
	$(".search-btn").click(function() {
		if($(".search-text").val() === "") {
			alert('제목을 입력해주세요');
			return;
		}
	});
	
	$(".btn-write").click(function() {
		location.href = "/phpBoard/admin/board/boardView.php";
	});
	
	//BACK
	$(".go-list").click(function() {
		location.href = "/phpBoard/web/index.php";
	});
	
	$("#btn-comment").click(function() {
		var author = $("[name='author']").val();
		var comment = $("[name='comment']").val();
		
		if(author === "" || comment === "") {
		 	alert('값을 입력해주세요');
			return;
		}
		
		if(confirm("Save Comment?")) {
			var params = $("#comment_fm").serialize();
			$.ajax({
				url: "/phpBoard/action_front.php",
				type: "POST",
				data: params,
				dataType: "json",
				success: function(data) {
					alert('Save Complete');
					var rep_comment = data.comment;
					location.href =location.href + "&ref=1";
				}
			});
		}
	});
	
	$(".btn-del").click(function() {
		var commentId = $(this).attr("id");
		if(confirm("Delete it?")) {
			var bid = $("[name=bid]").val();
			
			$.ajax({
				url: "/phpBoard/action_front.php",
				type: "POST",
				data: {
					cmd : "AdminBoard.deleteComment",
					cid : commentId,
					bid : bid
				},
				success: function(data) {
					alert('Delete Complete');
					location.reload();
				}
			});
			
		}
	});
	

});