<?php

	class BreadcrumbHelper extends AppHelper {
		public $helpers = array('Html');
		public $print_homepage = true;
		public $separator = " &rarr; ";

		public function display($crumbs) {
			$result = "";

			if (!is_array($crumbs)) {
				return "";
			}

			if ($this->print_homepage) {
				$result .= $this->_displayCrumb(array('title'=>__('Home'), 'link' => Router::url("/", true)));
				if (count($crumbs) > 0) {
					$result .= $this->separator;
				}
			}

			for($i=0;$i<count($crumbs);$i++) {
				$result .= $this->_displayCrumb($crumbs[$i]);
				if ($i<count($crumbs)-1)
					$result .= $this->separator;
			}
			return $result;
		}

		private function _displayCrumb($crumb) {
			$result = "";

			$result = $this->Html->link($crumb['title'], $crumb['link']);

			return $result;
		}
	}
?>
