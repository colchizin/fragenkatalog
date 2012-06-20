<div class="materials form">
<?php
	$this->Html->script('jquery.wysiwyg', array('inline'=>false));
//	$this->Html->script('jquery.wysiwyg.image', array('inline'=>false));

	$this->Js->buffer("
	$('#MaterialText').wysiwyg({
		'height':'500px',
		'controls' : {
			'insertImage' : {
				exec : function() {
					$('#dialog-insert-image').dialog({modal:true, height:400, width:650});
					/*window.open(
						'" . Router::url(array('action'=>'pick_image', 'layout_once'=>'dialog')) . "',
						'imagedialog',
						'width=700,height=300'
					);*/
				}
			}
		}
	});
	");
?>
<script language='javascript'>
	function insertImageIntoWYSIWYG() {
		var tf = $('#insert-image-filename');
		var img = tf.val();
		alert(img);
		$('#MaterialText').wysiwyg('insertImage', img);
		tf.val("");
		$('#dialog-insert-image').dialog('destroy');
	}
</script>
<?php echo $this->Form->create('Material');?>
	<a href='javascript:insertImage($("#MaterialText"),"/fragenkatalog/img/materials/Dermatomerumpf.JPG");'>Bild einfügen</a>
	<fieldset>
		<legend><?php echo __('Edit Material'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('type'=>'text'));
		echo $this->Form->input('text', array('style' => 'height:500px'));
	?>
		<a href='javascript:$("#MaterialText").wysiwyg("destroy");'>Quellcode bearbeiten</a>
	<?php
		echo $this->Form->input('subject_id');
//		echo $this->Form->input('Question', array('multiple'=>'checkbox'));
	?>
	<fieldset data-role='controlgroup'>
<?php
		echo $this->Form->submit(__('Save'),array('data-theme'=>'b'));
		echo $this->Html->link(
			__('Cancel'),
			array('action'=>'view',$this->request->data['Material']['id']),
			array('data-role'=>'button','class'=>'button','data-theme'=>'b')
		);
?>
	</fieldset>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<div class='dialog' id='dialog-insert-image' title='<?php echo __('Insert image');?>' style='display:none'>
	<div>
		<iframe style='width:99%;height:300px' src='/fragenkatalog/materials/pick_image/layout_once:dialog'></iframe>
	</div>
	<div>
		<input type='text' id='insert-image-filename'>
		<button onclick='insertImageIntoWYSIWYG();return false;'>
			<?php echo __('Insert Image');?>
		</button>
	</div>
 </div>
