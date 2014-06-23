<?php
class MyAdmin extends ModelAdmin {
	private static $managed_models = array('Ship', 'Producer', 'ShipType', 'ShippingCompany', 'Country'); // Can manage multiple models
	private static $url_segment = 'ships'; // Linked as /admin/products/
	private static $menu_title = 'Ship Admin';
}