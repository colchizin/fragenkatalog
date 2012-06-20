<?php
	echo $this->Html->css('dialog');
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
	echo $this->Html->script('jquery.wysiwyg.image');
	$this->Html->script('pick-image', array('inline'=>false));
	$cellcount = 0;
?>

<table class='table-images'>

<?php foreach ($images as $image):
	if ($cellcount % 4 == 0): ?>
		<tr>
	<?php endif;?>
		<td>
			<a href="javascript:returnImage('<?php echo $image['name'];?>', '/fragenkatalog/img/materials/')">
			<?php echo $this->Html->image($image['file']);?>
			</a>
		</td>
	<?php if($cellcount %4 == 3):?>
		</tr>
	<?php endif;?>
<?php
	$cellcount++;
	endforeach;?>

</table>
