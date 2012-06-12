Lieber Admin,

es wurde ein neues Ticket eröffnet:

Autor: <?php echo $ticket['User']['username'];?> 
Zeit/Datum: <?php echo $ticket['HasTicketstatus'][0]['created'];?> 
Url: <?php echo $ticket['Ticket']['url'];?> 
Titel: "<?php echo $ticket['Ticket']['title'];?>"
Beschreibung:
<?php echo $ticket['Ticket']['description'];?>


Link zum Ticket:
<?php echo Router::url(array('controller'=>'tickets','action'=>'view',$ticket['Ticket']['id']),true);?>
