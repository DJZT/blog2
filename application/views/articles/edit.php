<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-body">
			<form role="form" method="POST" action="">
				<div class="form-group">
					<label>Title</label>
					<input class="form-control" type="text" name="title" placeholder="Title" value="<?=$Article->title?>" required>
				</div>
				<div class="form-group">
					<label>Text</label>
					<textarea class="form-control" name="text" placeholder="Text" required><?=$Article->text?></textarea>
				</div>
				<div class="form-group pull-right">
					<input class="btn btn-success" type="submit" name="edit" value="Edit">
				</div>
			</form>
		</div>
	</div>
</div>