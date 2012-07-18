	function limitExams(lower, upper, subject_id) {
		console.log("lower: " + lower + " upper: " + upper);
		var lis = $('#exams [data-role="exams-finished"]');
		lis.each(function(idx,elem) {
			var e = $(elem);
			var value = parseInt(e.attr('data-value'));
			var sub = e.attr('data-subject');
			elem = $(elem);

			if (value < lower || value > upper || (subject_id != "" && sub != subject_id)) {
				elem.fadeOut('slow');
			} else {
				elem.fadeIn('slow');
			}
		});
	}

	$(document).ready(function() {
		$('#slider-percentage-lower').change(function() {
			var val = $('#slider-percentage-lower').val();
			limitExams(
				val,
				$('#slider-percentage-upper').val(),
				$('#subject_id').val()
			);	
			$('#slider-percentage-lower-value').text(val + "%");
			
			$('#slider-percentage-upper').attr('min', val);
		});

		$('#slider-percentage-upper').change(function() {
			var val = $('#slider-percentage-upper').val();
			limitExams(
				$('#slider-percentage-lower').val(),
				val,
				$('#subject_id').val()
			);	
			$('#slider-percentage-upper-value').text(val + "%");

			$('#slider-percentage-lower').attr('max', val);
		});

		$('#subject_id').change(function() {
			var val = $('#subject_id').val();	
			limitExams(
				$('#slider-percentage-lower').val(),
				$('#slider-percentage-upper').val(),
				val
			);
		});
	});
