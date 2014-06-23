<?php

class Ship_Controller extends Controller {
	private static $url_handlers = array(
		'$Slug' => 'handleShipRequest',
	);
	private static $allowed_actions = array(
		'handleShipRequest',
	);

	public function init() {
		parent::init();

		// also load requirements included in page (eg jquery)
		Page_Controller::requirements();

		Requirements::css("assets/iView/css/styles.css");
		Requirements::css("assets/iView/css/iview.css");
		Requirements::css("assets/iView/css/skin 1/style.css");

		Requirements::set_force_js_to_bottom(true);
		Requirements::javascript("assets/iView/js/jquery.easing.js");
		Requirements::javascript("assets/iView/js/raphael-min.js");
		Requirements::javascript("assets/iView/js/iview.js");
		Requirements::javascript("assets/ShipPage.js");
	}

	/**
	 * @param SS_HTTPRequest $r
	 * @return HTMLText|SS_HTTPResponse
	 */
	public function handleShipRequest(SS_HTTPRequest $r) {
		$slug = Convert::raw2sql($r->param('Slug'));
		$ship = Ship::get_by_url_segment($slug);
		if ($ship && $ship->exists()) {
			$data = $ship->customise(array(
				// ad SiteConfig to be able to use it in template
				'SiteConfig' => SiteConfig::current_site_config(),
				// put in some more data here, eg:
				// 'Content' => '<h1 style="font-size: 160px">Zauberfisch is super awesome</h1>',
			));
			return $data->renderWith(array('Ship', 'Page'));
		}
		// no ship found, return a 404 error page
		return ErrorPage::response_For(404);
	}
}
