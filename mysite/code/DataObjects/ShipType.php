<?php

class ShipType extends DataObject {

	private static $db = [
		'Token' => 'Varchar',
		'Name' => 'Varchar'
	];

	private static $has_many = [
		'Ship' => 'ShipPage'
	];

	static $searchable_fields = array(
		'Token',
		'Name'
	);

	private static $summary_fields = array(
		'Token',
		'Name'
		// leaves out the 'ProductCode' field, removing the column
	);

}