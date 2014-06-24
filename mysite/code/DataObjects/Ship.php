<?php

class Ship extends DataObject {

	private static $db = [
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'URLSegment' => 'Varchar(255)',
		'ArticleNumber' => 'Varchar',
		'Year' => 'Varchar',
		'YearAct' => 'Varchar'
	];

	private static $has_many = [
		'Images' => 'ShipImage'
	];

	private static $has_one = [
		'Producer' => 'Producer',
		'ShipType' => 'ShipType',
		'Country' => 'Country',
		'ShippingCompany' => 'ShippingCompany'
	];

	static $searchable_fields = array(
		'Title',
		'Producer.Name',
		'ShipType.Name',
		'ShippingCompany.Name',
		'Country.Name',
	);

	private static $summary_fields = array(
		'Producer.Name',
		'ArticleNumber',
		'Title',
		'ShipType.Name',
		'Country.Name',
		'ShippingCompany.Name',
		'Year',
		'YearAct'
	);


	public function fieldLabels($includerelations = true) {
		$return = parent::fieldLabels($includerelations);
		$return['Title'] = _t('Title', 'Ship Name');
		$return['Producer.Name'] = _t('Producer.Name', 'Producer');
		$return['Country.Name'] = _t('Country.Name', 'Country');
		$return['ShipType.Name'] = _t('ShipType.Name', 'Ship Type');
		$return['ShippingCompany.Name'] = _t('ShippingCompany.Name', 'Shipping Company');
		return $return;
	}


	public function getCMSFields() {

		$fields = parent::getCMSFields();

		/* Gallery Tab */
		// $conf = GridFieldConfig_RecordEditor::create(10);
		// $conf->addComponent(new GridFieldGalleryTheme('Image'));
		// $conf->addComponent(new GridFieldBulkUpload());
		// $conf->getComponentByType('GridFieldBulkUpload')->setConfig('folderName', $this->getRootFolderName());
		// $fields->addFieldToTab("Root.Gallery", Gridfield::create('Gallery', 'Gallery', $this->Images(), $conf));


		/* Producer */
		$field = new DropdownField('ProducerID', 'Producer', Producer::get()->map('ID', 'Title'));
		$field->setEmptyString('- Producer -');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* Ship Name (Title) */
		$field = new TextField('Title', 'Ship Name');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* ArticleNumber */
		$field = new TextField('ArticleNumber', 'ArticleNumber');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* ShipType */
		$field = new DropdownField('ShipTypeID', 'Ship Type', ShipType::get()->map('ID', 'Name'));
		$field->setEmptyString('- Ship Type -');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* Country */
		$field = new DropdownField('CountryID', 'Country', Country::get()->map('ID', 'Name'));
		$field->setEmptyString('- Country -');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* ShippingCompany */
		$field = new DropdownField('ShippingCompanyID', 'Shipping Company', ShippingCompany::get()->map('ID', 'Name'));
		$field->setEmptyString('- Shipping Company -');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* Year */
		$field = new TextField('Year', 'Year');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* YearAct */
		$field = new TextField('YearAct', 'YearAct');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		/* Content */
		$field = new HTMLEditorField('Content', 'Content');
		$fields->addFieldToTab('Root.Main', $field, 'Content');


		return $fields;
	}

	 public function Link() { 
	 	return singleton('Ship_Controller')->Link($this->URLSegment); 
	 }


	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$filter = URLSegmentFilter::create();
		$articleNumber = $this->ArticleNumber; //'BI-70a';
		$producerName = $this->Producer()->Name; //'bille';
		$shipName = $this->Title;
		$this->URLSegment = $filter->filter($articleNumber . '-' . $producerName . '-' . $shipName);
	}

	/**
	 * Cache for get_by_url_segment() to avoid duplicate SQL queries
	 *
	 * @var array
	 */
	protected static $_cached_get_by_url = array();

	/**
	 * @param string $str
	 * @param int $excludeID
	 * @return static|Boolean
	 */
	public static function get_by_url_segment($str, $excludeID = null) {
		if (!isset(static::$_cached_get_by_url[$str])) {
			$list = static::get()->filter('URLSegment', $str);
			if ($excludeID) {
				$list = $list->exclude('ID', $excludeID);
			}
			$obj = $list->First();
			self::$_cached_get_by_url[$str] = ($obj && $obj->exists()) ? $obj : false;
		}
		return self::$_cached_get_by_url[$str];
	}

}
 


