<?php if (!empty($programme['Programme']['description'])):?>
	<div class='info'>
		<?php echo $programme['Programme']['description'];?>
	</div>
<?php endif;?>
<div class="related">
		<table class='full-width'>
			<tr>
				<th><?php echo __('Subject');?></th>
				<th><?php echo __('Exams');?></th>
				<th><?php echo __('Actions');?></th>
			</tr>
	<?php
		foreach ($semesters as $semester=>$subjects):
	?>
		<tr>
			<td class='separator' colspan=5>
				<?php echo __('%sth semester', $semester);?>
			</td>
		</tr>
			<?php
				foreach($subjects as $subject):
			?>
				<tr>
					<td>
						<?php echo $this->Html->link($subject['Subject']['name'], array(
							'controller'=>'subjects',
							'action'=>'view',
							$subject['Subject']['id']));
						?>
					</td>
					<td>
						<?php echo $subject['Subject']['exam_count'];?>
					</td>
					<td>
						<?php echo $this->Html->link(__('View'),
							array(
								'controller'=>'subjects',
								'action'=>'view',
								$subject['Subject']['id']
							),
							array(
								'data-role'=>'button'
							)
						);
						?>
					</td>
			<?php
				endforeach;
			?>
	<?php
		endforeach;
	?>
		</table>
</div>

<div class="programmes view">
	<dl>
		<dt><?php echo __('University'); ?></dt>
		<dd>
			<?php echo $this->Html->link(
				$programme['University']['name'],
				array(
					'controller' => 'universities',
					'action' => 'view',
					$programme['University']['id']
				),
				array(
					'data-role'=>'button'
				)
			); ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul data-role='listview' data-inset='true' data-theme='b'>
		<li><?php echo $this->Html->link(__('Edit Programme'), array('action' => 'edit', $programme['Programme']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Universities'), array('controller' => 'universities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subject'), array('controller' => 'subjects', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php if (isset($ask_programme) && $ask_programme == true): ?>
	<script language='javascript'>
		$(document).ready(function() {
			var res = confirm(
					'<?php echo __('Set Programme %s as your default?', $programme['Programme']['name']);?>'
			);
			if (res) {
				location.href = '<?php echo $this->Html->url(
					array(
						'controller'=>'users',
						'action'=>'setProgramme',
						$programme['Programme']['id']
					)
				);?>';
			}
		});
	</script>
<?php endif;?>
