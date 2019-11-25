<?php if(isset($data['pagination']['total']) && $data['pagination']['total'] > 1): ?>
	<nav aria-label="Page navigation" class="mt-4">
		<ul class="pagination justify-content-center">
			<li class="page-item <?php if(!$data['pagination']['previous']['state']): ?> disabled <?php endif; ?>">
				<a class="page-link" href="<?php echo $data['pagination']['previous']['link']; ?>" tabindex="-1" aria-disabled="true">Previous</a>
			</li>

			<?php foreach($data['pagination']['pages'] as $key => $val): ?>
				<li class="page-item <?php if($data['pagination']['current'] == $key): ?> active <?php endif;?>"><a class="page-link" href="<?php echo $val?>"><?php echo $key ?></a></li>
			<?php endforeach; ?>

			<li class="page-item <?php if(!$data['pagination']['next']['state']): ?> disabled <?php endif; ?>">
				<a class="page-link" href="<?php echo $data['pagination']['next']['link']; ?>">Next</a>
			</li>
		</ul>
	</nav>
<?php endif; ?>