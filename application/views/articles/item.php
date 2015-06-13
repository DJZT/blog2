<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-body">
			<h2><?=$Article->title?></h2>
			<div class="row" style="color: grey">
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
			<hr>
			<?=$Article->text?>
		</div>
	</div>
</div>