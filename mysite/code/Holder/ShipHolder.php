<?php

class ShipHolder extends Page {
	private static $icon = "cms/images/treeicons/home-file.png";

	private static $allowed_children = array('ShipPage');
	
	public function init() {}
}

class ShipHolder_Controller extends Page_Controller {

	private static $allowed_actions = [
		'SearchForm'
	];


	public function SearchForm() {

		// TODO you should use _t() for translations here
		$fields = FieldList::create(array(
			
			$keyword = TextField::create('Keyword',''),
			$artnr = TextField::create('ArticleNumber',''),
			$producer = DropdownField::create('Producer', '', Producer::get()->sort('Name', 'ASC')->map('ID', 'Name') )->setEmptyString('- Producer -'),			
			$shipType = DropdownField::create('ShipType', '', ShipType::get()->sort('ShipType', 'ASC')->map('ID', 'ShipType') )->setEmptyString('- Ship Type -'),
			//$country = CountryDropdownField::create('Country')->setEmptyString('- Country -'),
			//$country = DropdownField::create('Country','', Country::get()->sort('Name', 'ASC')->map('ID', 'Name'))->setEmptyString('- Country -'),
			//$country = DropdownField::create('Country', ShipPage::get()->sort('Country', 'ASC')->map('ID', 'Name') )->setEmptyString('- Country -'),
			$shippingCompany = DropdownField::create('ShippingCompany', '', ShippingCompany::get()->sort('Name', 'ASC')->map('ID', 'Name') )->setEmptyString('- Shipping Company -'),	
			
		));

	
		//var_dump($country);
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
	 * NOTE: this method is called by Form created in SearchForm, this method is _NOT_ accessible by URL, only through the form
	 * it usually is best practice to do a redirect form this method to a action, 
	 * but in this case it makes sense to display the content directly
	 * 
	 * @param array $data
	 * @param Form $form
	 * @param SS_HTTPRequest $request
	 */
	public function doSearch($data, Form $form, SS_HTTPRequest $request) {
		
		// create a datalist (because the datalist is lazy loading, it will not run the sql query until we actually need the data)
		$ships = ShipPage::get();

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
			'SearchForm' => $form,
		));
	}

}