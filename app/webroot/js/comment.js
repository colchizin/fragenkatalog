var commentFieldNamePrefix = "#comment-field-";
var commentFieldClass = "comment-field";

function submitComment(id, comment, url, commentField, callback) {
	if (comment.Comment.comment == "") {
		return;
	}

	deactivateElement(commentField);

	$.ajax({
		'url' : url,
		'type' : 'POST',
		'data' : comment,
		success : function(data) {
			onCommentSubmitted(id, data, commentField, callback)
		},
		error: function(jqXHR, textStatus, errorThrown) {
			if (jqXHR.status == 403) {
				alert(__('info session expired'))
				location.reload();
			} else {
				alert(textStatus + ": " + errorThrown);
			}
		}
	});
}

function onCommentSubmitted(id, data, commentField, callback) {
	console.log(data);
	addComment(id,data,callback);
	commentField.find('textarea').val('');
	reactivateElement(commentField);
}

function addComment(id, comment, callback) {
	var user = comment.User;
	if (comment.Comment) {
		comment = comment.Comment;
		comment.User = user;
	}

	callback(id, comment,
		$("<p class='comment'></p>")
			.attr('id', 'comment_' + comment.id)
			.html(comment.comment + " ")
			.append($('<span class="comment-author"></span>')
				.text(user.username)
			)
	);
}

$(document).ready(function() {
	$('.comment-field').keydown(function (ev) {
		var elem = $(ev.target);
		switch (ev.which) {
		  case 13:
			// Eingabetaste gedrückt
			// wenn NICHT zusätzlich die shift-Taste gedrückt wird, dann den
			// Kommentar abschicken
			console.log(ev);
			if (ev.ctrlKey) {
				elem.parent().find('.btn-comment-submit').click(); return false;
			}
			break;
		}
	});
});
