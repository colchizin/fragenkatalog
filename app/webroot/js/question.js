function addAnswer(obj) {
	var id = obj.id;
	var answer = obj.answer;
	var correct = obj.correct;
	var comments = obj.Comment;

	var prevPos = $("#answers .answer:last").attr('data-pos');
	var pos;
	if (prevPos) {
		pos = parseInt(prevPos) + 1;
	} else {
		pos = 0;
	}

	var namebase = "data[Answer]["+pos+"]";
	
	var checked = (correct==true) ? 'checked' : '';

	// Antwort-div
	var d = $("<div></div>")
		.addClass('answer ui-grid-a')
		.attr('data-role','controlgroup')
		.attr('data-pos',pos)
	;	

	// Grid-View Block a (links):
	// Antwort-ID und Antworttext
	var ba = $("<div class='ui-block-a'></div>")
		.append($("<input></input>")
			.attr('name',namebase + "[id]")
			.attr('type','hidden')
			.attr('value',id)
		)
		.append($("<textarea>" + answer + "</textarea>")
			.attr('data-mini',true)
			.attr('name', namebase + '[answer]')
		)
	;

	// Grid-View Block b (rechts)
	// Richtige Antwort und Antwort löschen
	var bb = $("<div class='ui-block-b' data-role='controlgroup'></div>")
		.addClass('ui-block-b')
		.attr('data-role','controlgroup')
		.append($('<input />')	// Checkbox richtige Antwort
			.attr('type','checkbox')
			.attr('id', 'answer_' + id + '_' + pos)
			.attr('name',namebase + '[correct]')
			.attr('checked',correct)
		)
		.append($('<label>Richtige Antwort</label>') // Label Richtige Antwort
			.attr('for','answer_' + id + '_' + pos)
		)
		.append($('<button>Löschen</button>')	// Button Antwort löschen
			.click(function() {
				if (confirm("Antwort Wirklich löschen? (kann nicht rückgängig gemacht werden)")) {
					if (id!=0) {
						$.ajax({
							url: '/fragenkatalog/answers/delete/' + id,
							type: 'POST'
						});
					}
					d.remove();
				}
				return false;
			})
		)
	;

	d.append(ba).append(bb);

	// Kommentare (Div Comments => dc);
	var dc = $('<div class="comments"><h4>Kommentare</h4></div>');
	d.append(dc);

	// Button zum hinzufügen eines neuen Kommentares
	dc.append($('<button>Neuen Kommentar hinzufügen</button>')
		.addClass('btn-add-comment')
		.click(function() {
			addComment(dc);
			return false;
		})
	);

	// Wenn es schon Kommentare gibt, dann dises Kommentare hinzufügen
	if (comments) {
		for (var i=0;i<comments.length;i++) {
			addComment(dc,comments[i], comments[i].user_id);
		}
	}

	// Neue Antwort vor dem Hinzufügen-Button einfügen
	$("#answers #add_answer").before(d);
	d.trigger("create");
}

function addComment(dc,obj, readOnly) {
	if (!obj) {
		obj = {comment:'',id:0};
	}

	if (!readOnly)
		readOnly = false;

	var apos = dc.parent().attr('data-pos');
	var id = dc.parent().attr('data-id');
	var prevPos = dc.children('.comment:last').attr('data-pos');
	var pos;
	if (prevPos)
		pos = parseInt(prevPos)+1;
	else
		pos = 0;
	
	var namebase = 'data[Answer][' + apos + '][Comment][' + pos + ']';

	var comment = $('<div class="comment"></div>')
		.attr('data-pos',pos)
		.attr('id', 'comment_' + apos + '_' + pos)
		// Textfeld für den Kommentar
		.append($('<textarea>' + obj.comment + '</textarea>')
			.attr('name',namebase + '[comment]')
			.attr('readonly', readOnly)
		)
		// Verstecktes Feld mit ID des Kommentares
		.append($('<input type="hidden"></input>')
			.attr('name',namebase + '[id]')
			.attr('value',obj.id)
		)
		// Button zum löschen des Kommentares
		.append($('<button>Kommentar löschen</button>')
			.attr('disabled', readOnly)
			.click(function () {
				if (confirm("Kommentar wirklich löschen? (kann nicht rückgängig gemacht werden)")) {
					if (id!=0) {
						$.ajax({
							url: '/fragenkatalog/comments/delete/' + obj.id,
							type: 'POST'
						});
					}
					$(this.parentNode).remove();
				}
				return false;
			})
		)
	;
	dc.find('.btn-add-comment').before(comment);
}

function resetQuestions() {
	$('.question input[type=radio]').attr('checked','off');
}

function checkQuestion(id) {
	var q = $('#question_'+id);
	var aws = q.children('.answer');	
	aws.each(function(key,value) {

	});
}
