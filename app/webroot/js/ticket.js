function addTicketcomment(ticket_id, user_id) {
	var comment = $('#TicketcommentComment').attr('value');
	$.ajax({
		url: '/fragenkatalog/ticketcomments/add/useRH:true.json',
		data: { 'Ticketcomment' : {
			'ticket_id' : ticket_id,
			'comment' : comment
		}},
		type: 'POST',
		success: function(data,textStatus, jqXHR) {
			$('#TicketcommentComment').wysiwyg('clear');
			console.log(data);
			insertTicketcomment(data,user_id,$('#TicketcommentComment'));
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus + ": " + errorThrown);
		}
	});
}

function insertTicketcomments(comments, user_id,target) {
	for(var i=0;i<comments.length;i++) {
		insertTicketcomment(comments[i], target);
	}
}

function insertTicketcomment(comment, user_id,target) {
	if (!comment.Ticketcomment)
		comment.Ticketcomment = comment;
	
	var c = $("<div class='comment'></div>")
		.attr('id', 'Ticketcomment_' + comment.Ticketcomment.id)
		.append($("<div class='comment-metadata'></div>")
			.append($("<span class='username'></span>")
				.text(comment.User.username))
			.append($("<span class='timestamp'><span>")
				.text(comment.Ticketcomment.created))
		)
		.append($("<p></p>")
			.html(comment.Ticketcomment.comment)
		)
	;
	if (comment.Ticketcomment.user_id == user_id) {
		c.append($("<button class='btn-delete'>Löschen</button>")
			.click(function() {
				deleteTicketcomment(comment.Ticketcomment.id);
			})
		)
	}
	c.hide()
	 .insertBefore($('#TicketcommentAddForm'))
	 .slideDown('fast');
	;

}

function deleteTicketcomment(id) {
	deactivateElement($('#Ticketcomment_' + id));
	$.ajax({
		type:'POST',
		url:'/fragenkatalog/ticketcomments/delete_mine/' + id,
		success : function() {
			removeTicketcomment(id);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus + ": " + errorThrown);
			reactivateElement($('#Ticketcomment_' + id));
		}
	});
}

function removeTicketcomment(id) {
	var comment = $('#Ticketcomment_' + id);
	comment.slideUp('fast', function() {
		comment.remove();
	});
}
