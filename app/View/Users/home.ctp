<?php
	$this->Html->css('news',null, array('inline'=>false));
?>	
<p>
	Wilkommen in der Desktop-Version des <strong>Fragenkataloges</strong>.
	Hier kannst du den vollen Funktionsumfang des Fragenkataloges nutzen.
</p>
	<div class='news-entry info news'>
		<span style='float:right'><?php echo $this->Html->link(__('All news entries'), array(
			'controller'=>'news',
			'action'=>'index'
		));?></span>
		<h3><?php echo h($news['News']['title']);?></h3>
		<p class='news-metadata'>
			<?php echo __('created by');?>
			<?php echo $this->Html->link($news['User']['username'], array(
				'controller' => 'users',
				'action' => 'view',
				$news['User']['id']
			));?>
			<?php echo __('on');?>
			<?php echo $news['News']['created'];?>
		</p>
		<div class='news-content'>
			<?php echo $news['News']['description'];?>
		</div>
	</div>
<p>
	Dein Einstig in den Fragenkatalog ist dein Studiengang. Wenn du noch keinen Studiengang angegeben hast, dann such zunächst unter
	<?php echo $this->Html->link(__('Universities'),array(
		'controller'=>'universities',
		'action'=>'index'
	), array('data-role'=>'button'));?>
	deine  Universität und da dann deinen Studiengang heraus. Anschließend kannst du immer unter
	<?php if (!empty($user['User']['programme_id'])):?>
		<?php echo $this->Html->link(__('My Programme'), array(
			'controller'=>'programmes',
			'action'=>'view',
			$user['User']['programme_id']
		), array('data-role'=>'button'));?>
	<?php else:?>
		<strong><?php echo __('My Programme');?></strong>
	<?php endif;?>
	direkt auf deinen Studiengang zugreifen.
</p>

<p>
	Unter
	<?php echo $this->Html->link(__('My Exams'),array(
		'controller'=>'examsessions',
		'action'=>'my_sessions'
	), array('data-role'=>'button'));?>
	findest du eine Liste aller Prüfungen, mit denen du gerade beschäftigt bist und die du schon abschlossen hast.
</p>

<p>
	Wenn dir ein Fehler oder eine Problem auffält, dann kannst du das unter
		<?php echo $this->Html->link(__('Report an error'), array(
			'controller'=>'tickets',
			'action'=>'add'
		), array('data-role'=>'button'));?>
	melden.
</p>

<p>
 In der Desktop-Version kannst du neue Fachgebiete und Klausuren erstellen, Klausuren aus dem Mediwiki importieren und innerhalb einer Klausur Fragen kommentieren. Fühle dich ermutigt, davon ausgiebig Gebrauch zu machen, denn davon lebt diese Plattform.
</p>

<p>
	Wenn du mich beim Betrieb dieser Plattform unterstüzen möchtest, so sei dir die
		<?php echo $this->Html->link(__('Donate'), array(
			'controller'=>'pages',
			'action'=>'display',
			'donate'
		), array('data-role'=>'button'));?>
	-Schaltfläche ans Herz gelegt.
</p>

<div class='info'>
<h2>Hinweise</h2>
<h3>Prüfungssitzungen</h3>
<p>Wenn du eine Klausur kreuzt, dann werden automatisch deine Antworten gespeichert, sodass du das Kreuzen jederzeit unterbrechen und später sowohl auf dem Desktop als auch auf deinem Smartphone fortsetzen kannst.</p>

<h3>Einladungen</h3>
<p>Wenn du Komilitonen hast, die ebenfalls gerne hier kreuzen möchten, dann kannst du sie unter
		<?php echo $this->Html->link(__('Invite someone'), array(
			'controller'=>'invitations',
			'action'=>'add'
		), array('data-role'=>'button'));?>
 hier einladen.</p>
</div>
