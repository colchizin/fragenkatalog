var questions = new Array();

/*
 * Nimmt eine URL zu einer Klausur entgegen, lädt die Klausur und übergibt
 * sie an parse()
 */

/*
 * Nimmt HTML-Code entgegen, tütet Ihn in ein Jquery-Objekt ein und übergibt
 * dieses an parse()
 */
function parseCode(code) {
	var html = code.replace(/\<script.*\<\/script\>/im, "");
	var c = $(html);
	
	parse(c);
}

/*
 * Nimmt ein JQuery-Objekt,welches eine Seite enthält, entgegen und parst sie
 */
function parse(c) {
	c.find('script').remove();

	$('#div_output').empty();
	$('#div_output_2').empty();
	var temp = $('<div></div');

/* 
 * hier werden die Fragen erstmal in div's eingetütet
 */
	c.find('h5').each(function (i,v) {
		children = $(v).nextUntil('h5, div.printfooter');
		lis = children.children('li');
		lis = children;

		var div = $('<div class="question"></div>');
		div.append(v);
		div.append(lis);
		temp.append(div);	
	});
//	$('#div_output_2').append(temp.clone());
/*
 * Anschließend wird fragenweise weitergeparst. Die Fragen werden in einem
 * Array gesammelt. Fragen sind Objekte mit einem Titel und einem Array
 * an Antworten.
 */
	questions = new Array();	// Array der Fragen
	temp.children('div.question').each (function(i,v) {	// Wir gehen jeden Fragen-Div durch
		var question = {
			answers : new Array(),
			title:'',
			comment : '',
			materials : new Array() };

		// Den Source-Tag von Bildern so anpassen, dass die Bilder trotzdem
		// vom Mediwiki geladen werden
		$(v).find('img').each(function (idx,img) {
			img = $(img);
			$(img).attr('src', 'http://www.myencephalon.de' + img.attr('src'));
		});

		$(v).find('a.image').each(function (idx,a) {
			a = $(a);
			a.attr('href', 'http://www.myencephalon.de' + a.attr('href'));
		});

		// Das lästige Vergößern-Icon entfernen
		$(v).find('div.magnify').remove();
	
		// Anhänge zu Fragen (insbesondere Bildmaterial, z.B. Augenheilkunde)	
		question.attachment = $(v).children('h5').next('p').remove().html();
		if (question.attachment == null)
			question.attachment = "";
		var ol = $(v).children('h5').next('ol');
		if (ol.get().length > 0) {
			console.log('Auflistung gefunden');
			question.attachment = "<ol>" + ol.remove().html() + '</ol>';
		}

		// Der Titel der Fragae
		question.title = $(v).children('h5').remove().text();
		// Führende Nummerierung entfernen
		question.title = question.title.replace(/^\s?\d{1,3}\. /, "");

		// Mind-Maps suchen
		$(v).find('a').each(function (idx, a) {
			if (a.href.match(/mm$/)) {
				a = $(a);

				var material = {};
				material.title = $(a).text();
				material.text = 'http://www.myencephalon.de' + $(a).attr('href');
				material.type = "mindmap";
				question.materials.push(material);
				console.log('Mindmap gefunden: ' + a.attr('href'));
				a.closest('table').remove();
			}
		});

		// Tabellen als Zusatzmaterial speichern
		$(v).find('table').remove().each(function(idx,table) {
			var material = {};
		
			table = $(table);
			material.title = $.trim(table.find('th').text());
			if (material.title == "") 
				material.title = $.trim(table.find('td:first').text());

			material.text = "<table>" + table.html() + "</table>";
			material.type= "table";
			question.materials.push(material);
			console.log('Tabelle gefunden: ' + material.title);
		});

		// Bilder als Zusatzmaterial speichern
		$(v).find('img').remove().each(function(idx, img) {
			var material = {};
			img = $(img);
			material.title = $.trim(img.attr('alt'));
			if (material.title == "") {
				material.title = img.attr('src');
			}
			material.type = "image";
			material.text = img.attr('src');
			question.materials.push(material);
			console.log('Bild gefunden: ' + material.title);
		});

		// jedes LI wird durchgegegangen und die Inhalte im Antwort-Array gespeichert.
		// wenn die Antwort fett markiert ist, dann wird sie als richtige Antwort
		// interpretiert. Wenn in dieser Antwort dann noch mehr steht, wird das als
		// Kommentar interpretiert
		$(v).find('li').each(function(a,b) {
			var answer = {text:'',correct:false, comment:''};
			var par = $(b).parent();
			var next = $(b).next();
			b = $(b).remove().get();	// jetzt das LI entfernen
			answer.text = $.trim($(b).html());
			answer.raw = $(b).html();
			if (next.get().length == 0) {
				par.nextUntil('ul, div').each(function(c,d) {
					answer.comment += $.trim($(d).remove().html());
				});
				//answer.comment = par.nextUntil('ul').html();
			}
			var bold = $(b).find('b');
			if (bold.get().length>0) {
				answer.correct = true;
				answer.text = bold.remove().text();
				answer.comment += $.trim($(b).text());
				/*if (bold.next().get().length > 0)
					answer.comment = $(b).text();*/
			} 
			question.answers.push(answer);
		});
		$(v).children('ul, br').remove();
		question.comment = $.trim($(v).html());
		questions.push(question);
	});

/*
 * Nun kann man das ganze, wenn man will, auch noch ausgeben.
 */

	for (var j=0;j<questions.length;j++) {
		var question = questions[j];
		if ($.inArray(question.title, new Array(
				'Suche',
				'Werkzeuge',
				'Navigation',
				'Persönliche Werkzeuge',
				'Ansichten'
		)) != -1) {
			continue;
		}
		var namebase = "data[Question]["+j+"]";
		var id = "question_" + j;
		var dellink = $('<a>Löschen</a>');
		dellink.attr('href', 'javascript:$("#'+id+'").remove(); questions['+j+'] = null;');

		// Div für die Frage sowie das input mit der ID
		var div = $('<div class="question" id="' + id +'"><h2>Frage '+(j+1)+'</h2></div>');
		div.append('<input type="hidden" name="'+namebase+'[id]" value="0" />')

		// UL für die Antwortmöglichkeiten
		var ul = $('<ol class="answers"></ol>');

		// Div für die Materialien
		var mats = $('<div class="materials"><h3>Materialien</h3></div>');

		for (var i=0;i<question.answers.length;i++) {
			var answer = question.answers[i];
			var id = 'answer_' + j + '_' + i;
			var namebase2 = namebase + "[Answer]["+i+"]";
			var li = $('<li class="answer"></li>')
				.append($('<input type="hidden" name="'+namebase2+'[id]" value="0"/>'))
				.attr('id',id)
			;
			var label = $('<label></label');
			var checkbox = $('<input type="checkbox" name="'+namebase2+'[correct]" />');
			if (answer.correct) {
				li.attr('data-correct','true');
				checkbox.attr('checked','checked');
			}

			label.append(checkbox);
			label.append($('<input type="text" name="'+namebase2+'[answer]" /></li>')
				.val(answer.text)
			);

			li.append(label);
			li.append($('<a>Löschen</a>')
				.attr('href','javascript:$("#'+id+'").remove()')
			);

			if (answer.comment && answer.comment != '') {
				li.append($('<div class="comment"><textarea name="'+namebase2+'[Comment][0][comment]">' + answer.comment + '</textarea></div>'));
			}
			ul.append(li);
		}


		// Materialien (Tabellen, Bilder, etc.)
		for (var i=0;i<question.materials.length;i++) {
			var material = question.materials[i];
			var namebase2 = namebase + '[Material]['+i+']';
			var mat = $('<div class="material"></div>');
			mat.append($('<input type="hidden" name="'+namebase2+'[id]" value="0" />'));
			mat.append($('<h4>' + material.title + '<h4>'));
			mat.append($('<input type="hidden" name="'+namebase2+'[title]" />')
				.val(material.title)
			);
			mat.append($('<input type="text" name="' + namebase2+'[type]" value="'+material.type+'" />'));
	//		mat.append($(material.text));
			mat.append($('<textarea rows=4 name="'+namebase2+'[text]"></textarea>').text(material.text));

			mats.append(mat);
		}

		// Link zum Löschen der Frage
		div.append(dellink);
		// Textfeld mit der Frage
		div.append($('<textarea name="'+namebase+'[question]">'+question.title+'</textarea>'));
		// Textfeld mit dem beigefügten Inhalt (z.B. Bild)
		div.append($('<textarea></textarea>')
			.attr('name', namebase + '[attachment]')
			.text(question.attachment)
		);
		// Liste der Antworten
		div.append(ul);

		if (question.comment) {
			div.append($('<div class="comment"><textarea name="'+namebase+'[Comment][0][comment]' + question.comment + '</textarea></div>'));
		}

		if (question.materials.length >0) {
			div.append(mats);
		}
		$('#div_output').append(div);
	}
}

