<?php
/**
 * ExamHelper.php
 *
 * @version	0.1
 * @author	colchizin
 */

class ExamHelper extends AppHelper {
	public function classByPercentage($percent) {
		if ($percent >= 90)
			return "very_good";
		else if ($percent >=80)
			return "good";
		else if ($percent >= 70) {
			return "average";
		} else if ($percent >= 60) {
			return "sufficient";
		} else {
			return "failed";
		}
	}
}

?>
