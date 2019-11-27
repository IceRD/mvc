<div class="input-group mb-3">
	<div class="input-group-prepend">
		<label class="input-group-text" for="inputGroupSelect01">Sort By:</label>
	</div>
	<select class="custom-select" id="sort" onchange="location = this.value;">
		<?php foreach ($data['sort']['url'] as $sort) : ?>
			<option value="<?php echo $sort['link']; ?>" <?php if (isset($data['sort']['current']) &&  $data['sort']['current'] == $sort['link']) {
																	echo 'selected="selected"';
																} ?>>
				<?php echo $sort['label']; ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>