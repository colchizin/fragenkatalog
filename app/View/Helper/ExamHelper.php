<?php
/**
 * ExamHelper.php
 *
 * @version	0.1
 * @author	colchizin
 */

class ExamHelper extends AppHelper {
	public function classByPercentage($percent) {
		$res = "examresult";
		if ($percent >= 90)
			return "$res very_good";
		else if ($percent >=80)
			return "$res good";
		else if ($percent >= 70) {
			return "$res average";
		} else if ($percent >= 60) {
			return "$res sufficient";
		} else {
			return "$res failed";
		}
	}
}

?>
