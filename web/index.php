
<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/web/header.php"; ?> <!-- header.php 추가 -->
<?php include $_SERVER["DOCUMENT_ROOT"]."/phpBoard/common/classes/AdminBoard.php"; ?> <!-- AdminBoard.php 추가 -->

<?php
	$page = ($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$_REQUEST['page'] = $page;
	$obj = new AdminBoard($_REQUEST);
	$cnt = $obj->getPostCount();
	$list = 10; // 페이지당 가져올 게시글의 수
	$b_list = 10;
	$block = ceil($page / $b_list);

	$b_start_page = (($block - 1) * $b_list) + 1;
	$b_end_page = $b_start_page + $b_list - 1;
	$total_page = ceil($cnt / $list);
	$total_block = ceil($total_page/$b_list);

	if($b_end_page > $total_page) {
		$b_end_page = $total_page;
	}
	$postList = json_decode($obj->getPostList());

?>



		<!-- striped - 홀수짝수다르게 보이게하는 클래스, bordered- 라인칠하는 클래스, hover- 호버시 하이라이트 -->
		<div class="container">
			<h1>SimpleBoard</h1>
			<table class="table table-striped table-bordered table-hover"> 
				<thead>
					<tr>
						<th class="text-center"><input type="checkbox" name="check_all"></th>
						<th class="text-center">글번호</th>
						<th class="text-center">제목</th>
						<th class="text-center">등록일</th>
						<th class="text-center">조회수</th>
					</tr>
				</thead>

				<tbody class="text-center">
					<?php
					for($i=0; $i<sizeof($postList); $i++) {
						$row = $postList[$i];
					?>		
					<tr>
						<td><input type="checkbox" class="chk_no" name="check_row" value="<?=$row->NO?>"></td>
						<td><?=$row->NO?></td>
						<td style="width: 60%;"><a href="/phpBoard/admin/board/boardView.php?no=<?=$row->NO?>"><?=$row->TITLE?></a></td>
						<td><?=date("y-m-d H:i",strtotime($row->DATES))?></td>
						<td><?=$row->HIT?></td>
					</tr>
					<?php } ?>
				</tbody>

			</table>
				
			<!-- Pagination -->
			<input type="button" class="btn btn-danger btn-style btn-delete" style=""value="Delete Post">
			<input type="button" class="btn btn-primary btn-style btn-write" value ="Write Post">
			<div class="justify-content-center" style="display:inline;">
				<ul class="pagination justify-content-center">
					<?php if($block >= 2) { ?>
					<li class="page-item">
						<a class="page-link" href="/phpBoard/web/index.php?page=<?=$b_start_page-1?>" tabindex="-1">Previous</a> 
					</li>
					<?php } ?>
					<?php for($i=$b_start_page; $i<=$b_end_page; $i++) {?>
						<li class="page-item"><a class="page-link" href="/phpBoard/web/index.php?page=<?=$i?>"><?=$i?></a></li>
					<?php } ?>
					<li class="page-item">
						<?php if($block < $total_block){?>
						<a class="page-link" href="/phpBoard/web/index.php?page=<?=$b_end_page+1?>">Next</a> <?php }?>
					</li>
				</ul>

			</div>
			
		</div>

<?php include $_SERVER["DOCUMENT_ROOT"]."phpBoard/web/footer.php"; ?> <!-- footer.php 추가 --!>