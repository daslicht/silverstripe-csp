<?php

class ShippingCompany extends DataObject {

	private static $db = [
		'Token' => 'Varchar',
		'Name' => 'Varchar'
	];

	private static $has_many = [
		'Ship' => 'ShipPage'
	];

	private static $field_labels = array(
		'token' => 'ShippingCompany'
	);

	static $searchable_fields = array(
		'Name'
	);

	private static $summary_fields = array(
		'Token',
		'Name'
	);


}

