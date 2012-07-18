function submitNewsComment(id, commentField) {
	var comment = {
		'Comment' : {
			'comment' : commentField.find('textarea').val()
		},
		'HasComment' : {
			'news_id' : id
		}
	};
	submitComment(
		id,
		comment,
		'/fragenkatalog/news/addComment.json',
		commentField,
		onNewsCommentSubmitted
	);
}

function onNewsCommentSubmitted(id, comment, element) {
	element.appendTo($('#news_' + id + ' .comments'));
}
