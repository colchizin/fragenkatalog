
<?php echo $this->Html->script('parse');?>

<div class='info'>
<h2>Anleitung</h2>
<p>Um eine Klausur aus dem Mediwiki hier einzufügen musst du:</p>
<ol>
	<li>Die Klausur im Mediwiki aufrufen</li>
	<li>In die Druckversion der Klausur wechseln (Schaltfläche am linken Rand)</li>
	<li>Dir den Quelltext der Klausur anzeigen lassen (Rechtsklick → Seitequelle/Quelltext/...)</li>
	<li>Den gesamten Quelltext markieren: <span class='keyboard'>Strg</span>+<span class='keyboard'>a</span></li>
	<li>Den Quelltext kopieren: Rechtsklick → Kopieren bzw. <span class='keyboard'>Strg</span> + <span class='keyboard'>c</span></li>
	<li>Den Quelltext in das Textfeld hier einfügen</li>
	<li>Mit einem klick auf die Schaltfläche <em><?php echo __('Go');?></em> die Klausur auslesen</li>
	<li>Die ungültigen Fragen am Ende entfernen</li>
	<li>Die restlichen Angaben (Titel, Semester, etc) ergänzen</li>
	<li>Abschicken!</li>
</ol>
<p>Klingt komplizierter als es ist. Bitte prüfe vor dem Speichern der Klausur, ob alles in Ordnung aussieht</p>
</div>

<textarea id='input_code'>
</textarea>

<button
	onclick="parseCode($('#input_code').attr('value'))"
>
	<?php echo __('Go');?>
</button>

<?php /*$this->Js->buffer("parseCode($('#input_code').attr('value'));");*/ ?>

<?php
	echo $this->Form->create('Exam');
?>

<div id='div_output'>

</div>
<?php
echo $this->Form->input('subject_id');
echo $this->Form->input('title', array('value'=>__('Exam')));
echo $this->Form->input('year',array('min'=>2000,'value'=>'2000'));
echo $this->Form->input('term',	array(
	'type'=>'select',
	'options'=>array(
		'0'=>__('Summer'),
		'1'=>__('Winter')
	),
	'empty'=>__('No Specific Term'),
));
echo $this->Form->input('semester');
echo $this->Form->end(__('Submit'));

?>
<div id='div_output_2'></div>
