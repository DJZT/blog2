<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-body">
			All <?=count($Articles) ?> articles <?php if ($User->is_logged()): ?>
				<div class="pull-right"><a href="<?=base_url('articles/add')?>">Add article</a> </div>
			<?php endif ?>
			<hr>
			<?php foreach ($Articles as $key => $Article): ?>
				<?php $this->load->view('articles/article_in_list', array('Article' => $Article)); ?>
			<?php endforeach ?>
		</div>
	</div>
</div>