<?php
// Based on: Dolphin CSS Menu
// Source: http://13styles.com/menus_detail.php?slug=dolphin

require_once('Menu/Template.php');

class MenuComponent {
	protected $menuItems = array();
	protected $currentPage = '';

	public function __construct($menuItems, $currentPage) {
		$this->menuItems = $menuItems;
		$this->currentPage = $currentPage;
	}
	
	public function generate() {
		$tmpl = new Template();
		$tmpl->menuItems = $this->menuItems;
		$tmpl->currentPage = $this->currentPage;
		$menuHTML = $tmpl->build('Menu/menu.tmpl');
		
		$cssFile = "Menu/menu_style.css";
		
		$result = array();
		$result['cssFile'] = $cssFile;
		$result['html'] = $menuHTML;
		
		return $result;
	}

}
?>