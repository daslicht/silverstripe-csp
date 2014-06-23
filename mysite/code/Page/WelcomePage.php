<?php

class WelcomePage extends Page {
	/**
	 * @return DataList
	 */
	public function Images() {
		return ShipImage::get()->filter(array('featured' => 1))->sort('RAND()')->limit(5);
	}
}

class WelcomePage_Controller extends Page_Controller {
	public function init() {
		parent::init();
		Requirements::css("assets/iView/css/styles.css");
		Requirements::css("assets/iView/css/iview.css");
		Requirements::css("assets/iView/css/skin 1/style.css");

		Requirements::set_force_js_to_bottom(true);
		Requirements::javascript("assets/iView/js/jquery.easing.js");
		Requirements::javascript("assets/iView/js/raphael-min.js");
		Requirements::javascript("assets/iView/js/iview.js");
		Requirements::javascript("assets/ShipPage.js");
	}
}





