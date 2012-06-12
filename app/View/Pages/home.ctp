<p>Dies ist die Startseite des Fragenkataloges.</p>
<p>Diese Seite befindet sich noch in der Entwicklung. Sämtliche Funktionalität erfolgt ohne Gewähr, ich kann für <em>nichts</em> garatieren.</p>
<p>Diese Seite lebt von ihren Inhalten und von der Bereitschaft ihrer Nutzer, neue Inhalte hinzuzufügen. Bitte beiteilige dich daran, diese Fragendatenbank so vollständig wie möglich zu machen!</p>
<h2>Hinweis</h2>
<p>Um auf Fehler hinzuweisen oder Verbesserungsvorschläge zu machen rufe bitte einfach die entsprechende Seite/Frage/Klausur/etc. auf und betätige dann den Link <b><?php echo __('Report an Error');?></b> in der linken Menüleiste.</p>
<hr>

<?php if (isset($default_programme)): ?>

<p>Dein Studiengang:
<?php echo $this->Html->link(
	$default_programme['Programme']['name'],
	array(
		'controller'=>'programmes',
		'action'=>'view',
		$default_programme['Programme']['id']
	),
	array('data-role'=>'button','class'=>'button')
);?>
</p>

<?php endif; ?>

<p>Als Einstieg in den Fragenkatalog wählst du hier deine Universität:
<?php echo $this->Html->link(
__('Universitites'),
array(
	'controller'=>'universities'
),
array(
	'data-role'=>'button'
));
?>
</p>

<p>Wenn du weitere Leute in einladen möchtest, hier mitzumachen...:</p>
<?php echo $this->Html->link(
__('Invitation'),
array(
	'controller'=>'invitations',
	'action'=>'add'
),
array(
	'data-role'=>'button'
));
?>
</p>
