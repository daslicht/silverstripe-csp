<?php

class Producer extends DataObject {

	private static $db = [
		'Token' => 'Varchar',
		'Name' => 'Varchar'
	];

	private static $has_many = [
		'Ship' => 'Ship'
	];


	private static $field_labels = array(
		'token' => 'Kurz'
	);

	static $searchable_fields = array(
		'Token',
		'Name'
	);

}

