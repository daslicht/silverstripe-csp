<?php

class Ship_Controller extends Controller {
	private static $url_handlers = array(
		'' => 'index',
		'Search' => 'Search',
		'$Slug' => 'handleShipRequest'
	);
	private static $allowed_actions = array(
		'handleShipRequest',
		'Search',
	);

	public function Link($action = null) { 

	

		return Controller::join_links('/shipdb', $action); 
	}

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
	
	/**
	 * @param SS_HTTPRequest $r
	 * @return HTMLText
	 */
	public function index() {
		return $this->customise(array(
			'Title' => 'Search for them Ships',
			'Form' => $this->Search(),
		))->renderWith(array('ShipSearch', 'Page'));
	}
	

	/**
	 * @return Form
	 */
	public function Search() {
		// TODO you should use _t() for translations here
		$fields = FieldList::create(array(	
			$keyword = TextField::create('Keyword',''),
			$artnr = TextField::create('ArticleNumber',''),
			$producer = DropdownField::create('Producer', '', Producer::get()->sort('Name', 'ASC')->map('ID', 'Name') )->setEmptyString('- Producer -'),			
			$shipType = DropdownField::create('ShipType', '', ShipType::get()->sort('Name', 'ASC')->map('ID', 'Name') )->setEmptyString('- Ship Type -'),
			//$country = CountryDropdownField::create('Country')->setEmptyString('- Country -'),
			$country = DropdownField::create('Country','', Country::get()->sort('Name', 'ASC')->map('ID', 'Name'))->setEmptyString('- Country -'),
			//$country = DropdownField::create('Country', ShipPage::get()->sort('Country', 'ASC')->map('ID', 'Name') )->setEmptyString('- Country -'),
			$shippingCompany = DropdownField::create('ShippingCompany', '', ShippingCompany::get()->sort('Name', 'ASC')->map('ID', 'Name') )->setEmptyString('- Shipping Company -'),	
		));
		$keyword->setAttribute('placeholder', 'Ship Name');
		$artnr->setAttribute('placeholder', 'Article Number');

		$actions = FieldList::create(array(
			FormAction::create('doSearch', 'Search'),
		));

		$form = Form::create(
			$this, // controller
			__FUNCTION__, // Name of the form
			$fields,
			$actions
		);
		
		// use get and disable security token to have a canonical url.
		$form->setFormMethod('GET');
		$form->disableSecurityToken();
		return $form;
	}


	/**
	 * NOTE: this method is called by Form created in Search, this method is _NOT_ accessible by URL, only through the form
	 * it usually is best practice to do a redirect form this method to a action, 
	 * but in this case it makes sense to display the content directly
	 * 
	 * @param array $data
	 * @param Form $form
	 * @param SS_HTTPRequest $request
	 */
	public function doSearch($data, Form $form, SS_HTTPRequest $request) {
		
		// create a datalist (because the datalist is lazy loading, it will not run the sql query until we actually need the data)
		$ships = Ship::get();

		// if ( isset($data['Keyword']) && $data['Keyword'] ) {
		// 	$sqlSaveKeyword = Convert::raw2sql($data['Keyword']);
		// 	$ships = $ships->filter('Title:StartsWith', $sqlSaveKeyword);
		// }
		// if ( isset($data['ArticleNumber']) && $data['ArticleNumber'] ) {
		// 	$sqlSaveArticleNumber = Convert::raw2sql($data['ArticleNumber']);
		// 	$ships = $ships->filter('ArticleNumber:StartsWith', $sqlSaveArticleNumber);
		// }
		// if ( isset($data['Producer']) && $data['Producer'] ) {

		// 	$sqlSaveProducer = Convert::raw2sql($data['Producer']);
		// 	$ships = $ships->filter(array('ProducerID' => $sqlSaveProducer));
		// }
		// if ( isset($data['ShipType']) && $data['ShipType'] ) {
		// 	$sqlSaveShipType = Convert::raw2sql($data['ShipType']);
		// 	$ships = $ships->filter('ShipType', $sqlSaveShipType);
		// }		
		// if ( isset($data['Country']) && $data['Country'] ) {
		// 	$sqlSaveCountry = Convert::raw2sql($data['Country']);
		// 	$ships = $ships->filter(array('CountryID' => $sqlSaveCountry));
		// }		
		// if ( isset($data['ShippingCompany']) && $data['ShippingCompany'] ) {
		// 	$sqlSaveShippingCompany = Convert::raw2sql($data['ShippingCompany']);
		// 	$ships = $ships->filter('Country', $sqlSaveShippingCompany);			
		// }
				
		$ships = $ships->sort('Title', 'ASC');
		
		//var_dump($ships);
		return $this->customise(array(
			// pass the results to the template, in template it can be used in a loop: <% loop $SearchResults % >$ID - $Title - $Year ($City, $Height)<br><% end_loop % >
			'SearchResults' => $ships,
			// display the form that was just submitted instead of letting SilverStripe render a new one,
			// this has the benefit that the selected values are selected again after the page reload
			'Form' => $form,
		))->renderWith(array('ShipSearch', 'Page'));
	}
}
