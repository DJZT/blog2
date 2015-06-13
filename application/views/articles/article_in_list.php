<div class="panel panel-default">
	<div class="panel-heading"><a href="<?=base_url("article/$Article->id")?>"><?=$Article->title?></a></div>
	<div class="panel-body"><?=$Article->text?></div>
	<div class="panel-footer">
		<div class="row">
			<div class="col-md-5">
				Date: <?=$Article->date?>
			</div>
			<div class="col-md-5">
				Author: <?=$Article->get_author()->last_name." ".$Article->get_author()->first_name?>
			</div>
			<div class="col-md-2">
				<?php if ($User->is_logged()): ?>
					<a class="btn btn-link btn-xs" href="<?=base_url("articles/list?delete=$Article->id")?>">Delete</a>
					<a class="btn btn-link btn-xs" href="<?=base_url("articles/edit/$Article->id")?>">Edit</a>
				<?php endif ?>
			</div>
		</div>
		
	</div>
</div>