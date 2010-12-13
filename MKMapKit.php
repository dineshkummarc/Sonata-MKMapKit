<?php
//  MKMapKit.php
//  Sonata/Libraries/MKMapKit
//
// Copyright 2010 Roman Efimov <romefimov@gmail.com>
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//    http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
require_once "MKMapKit/MKMapComponent.php";

class MKMapKit {
	
	private static $cache;
	
	public static function coordinatesFromAddress($address) {
		if (isset(self::$cache[$address])) return self::$cache[$address];
		$geourl = "http://maps.google.com/maps/geo?q=".urlencode($address)."&output=csv";
		  
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $geourl);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$csv= trim(curl_exec($c));
		$csv = explode(",", $csv);
		curl_close($c);
		self::$cache[$address] = array("lat" => $csv[2], "lon" => $csv[3]);
		return self::$cache[$address];
    }
	
}

?>