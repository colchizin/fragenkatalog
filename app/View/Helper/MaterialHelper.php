<?php

class MaterialHelper extends AppHelper {
	public $model = "Material";

	/**
	 * Standard-Methode zum Ausgeben von Material-Inhalt 
	 * 
	 * @param mixed $material 
	 * @access public
	 * @return void
	 */
	public function write($material) {
		if (isset($material[$this->model]))
			$data = $material[$this->model];
		else if(is_array($material)) {
			$data = $material;
		} else {
			return null;
		}

		if (!empty($data['type'])) {
			$type = Inflector::camelize($data['type']);
		} else {
			$type = "Text";
		}

		if (method_exists($this, "write" . $type)) {
			return $this->{'write'.$type}($data);
		} else {
			return $data['text'];
		}
	}

	/**
	 * Mind-Map ausgeben 
	 * 
	 * @param mixed $data 
	 * @access public
	 * @return void
	 */
	public function writeMindmap($data) {
		$base = Router::url('/');
		$result = '<embed type="application/x-shockwave-flash" src="' . $base . '/flash/visorFreemind.swf" id="visorFreeMind" align="middle" quality="high" bgcolor="#ffffff" flashvars="initLoadFile=' . $base . '/flash/mindmaps/' . $data['text'] . '&amp;startCollapsedToLevel=1&amp;openUrl=_blank" class="mindmap" style="display: none !important; ">';
		$result .= '<p><a href="http://freemind.sourceforge.net/wiki/index.php/Flash_browser">Freemind Flash Browser</a> Licensed under <a href="http://www.google.de/url?sa=t&rct=j&q=gpl&source=web&cd=1&ved=0CG4QFjAA&url=http%3A%2F%2Fde.wikipedia.org%2Fwiki%2FGNU_General_Public_License&ei=413KT__OGoTfsgaPo7jPBg&usg=AFQjCNHfbsjnDbseaZyO0L8-J85jRgzZCA">GPL</a></p>';
		return $result;
	}

	/**
	 * Bild ausgeben 
	 * 
	 * @param mixed $data 
	 * @access public
	 * @return void
	 */
	public function writeImage($data) {
		return "<img src='" . $data['text'] . "' title='" . $data['title'] . "' />";
	}

}
