<?php
class ShipPage extends Page {
      
    private static $db = [
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

    static $defaults = array( 
        'ShowInMenus' => 0
    );


    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true) {
        $return = parent::fieldLabels($includerelations);
        $return['Title'] = _t('Title', 'Ship Name');
        $return['Producer.Name'] = _t('Producer.Name','Producer');
        $return['Country.Name'] = _t('Country.Name','Country');
        $return['ShipType.Name'] = _t('ShipType.Name', 'Ship Type');
         $return['ShippingCompany.Name'] = _t('ShippingCompany.Name', 'Shipping Company');
        return $return;
    }
     
    public function getCMSFields() {

        $fields = parent::getCMSFields();
        
        /* Gallery Tab */
        $conf = GridFieldConfig_RecordEditor::create(10);
        $conf->addComponent(new GridFieldGalleryTheme('Image'));
        $conf->addComponent(new GridFieldBulkUpload());
        $conf->getComponentByType('GridFieldBulkUpload')->setConfig('folderName', $this->getRootFolderName());
        $fields->addFieldToTab("Root.Gallery", Gridfield::create('Gallery', 'Gallery', $this->Images(), $conf));         

        /* Producer */
        $field = new DropdownField('ProducerID', 'Producer', Producer::get()->map('ID', 'Title'));
        $field->setEmptyString('- Producer -');
        $fields->addFieldToTab('Root.Main', $field, 'Content');
       
        /* ArticleNumber */ 
        $field = new TextField('ArticleNumber','ArticleNumber');
        $fields->addFieldToTab('Root.Main', $field, 'Content');
        
        /* ShipType */
        $field = new DropdownField('ShipTypeID', 'Ship Type', ShipType::get()->map('ID', 'Name'));
        $field->setEmptyString('- Ship Type -');
        $fields->addFieldToTab('Root.Main', $field, 'Content'); 
        
        /* Country */ 
        $field = new DropdownField('CountryID','Country', Country::get()->map('ID', 'Name') );
        $field->setEmptyString('- Country -');
        $fields->addFieldToTab('Root.Main', $field, 'Content');
       
        /* ShippingCompany */
        $field = new DropdownField('ShippingCompanyID', 'Shipping Company', ShippingCompany::get()->map('ID', 'Name'));
        $field->setEmptyString('- Shipping Company -');
        $fields->addFieldToTab('Root.Main', $field, 'Content');     

        /* Year */ 
        $field = new TextField('Year','Year');
        $fields->addFieldToTab('Root.Main', $field, 'Content');

        /* YearAct */ 
        $field = new TextField('YearAct','YearAct');
        $fields->addFieldToTab('Root.Main', $field, 'Content');

        return $fields;
    }
}
 
class ShipPage_Controller extends Page_Controller {
    
    public static $current_product_id;

    public function init() 
    { 
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

    public function show( SS_HTTPRequest $request) {
        print_r($request->allParams()); die;
        $ship = Ship::get_by_url_segment(Convert::raw2sql($request->param('ID')));
        if (!$ship) {
            return $this->httpError(404);
        }

        static::$current_product_id = $ship->ID;

        return $this->renderWith('Page',$ship);

    }


}





