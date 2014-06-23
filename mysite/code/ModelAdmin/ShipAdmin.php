<?php

class MyAdmin extends ModelAdmin {
	private static $managed_models = array(
		'Ship',
		'Producer',
		'ShipType',
		'ShippingCompany',
		'Country'
	);
	private static $url_segment = 'ships';
	private static $menu_title = 'Ship Admin';
}