<?php

	class BreadcrumbComponent extends Component {
		protected $breadcrumbs = array();

		public function addBreadcrumb($crumb) {
			if (is_array($crumb)) {
				$this->breadcrumbs[] = $crumb;
			}
		}

		public function getBreadcrumbs() {
			return $this->breadcrumbs;		
		}
	}

?>
