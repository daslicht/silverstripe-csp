<?php
 
class FastFood_Controller extends Controller {
     
    private static $allowed_actions = array('order');
     
    public function order(SS_HTTPRequest $request) {
        print_r($request->allParams());
    }

    public function index(SS_HTTPRequest $request) {
    
		$customFields = array(
			'title' => 'test',
			'Content' => "foo"
		);
    	return $this->renderWith('Page',$customFields);

    }
}