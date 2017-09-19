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
		
	//write Post
	$(".btn-write").click(function() {
		location.href = "/phpBoard/admin/board/boardView.php";
	});
	
	//delete Post
	$(".btn-delete").click(function() {
		var noArr = [];
		var noCount = $("[name='check_row']:checked").length;
		
		if(noCount === 0) {
			alert('삭제하실 항목을 선택해주세요');
			return;
		}
		
		if(confirm("Delete it?")) {
			for(var i = 0; i < noCount; i++) {
				noArr[i] = $(".chk_no:checked:eq(" + i + ")").val();
			}
			deletePost(noArr);
		}
	});
	
	function deletePost(no) {
		console.log("Try delete BoardNumber : " + no);
		
		$.ajax({
			url: "/phpBoard/action_front.php?cmd=AdminBoard.delPost",
			async : false,
			cache : false,
			data: {
				"NO" : no.toString()
			},
			success: function(data) {
				alert('Delete Complete');
				location.reload();  
			}
		});
	}
	

});