<?php
//  MKMapComponent.php
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

class MKMapComponent extends UIComponent {
	
	protected $content;
	
	public $name;
	public $type;
	public $allowzoom;
	public $allowscroll;
	public $width;
	public $height;
	public $centerLatLng;
	public $zoom;
	public $scrollwheel;
	public $draggable;
	public $navigationControl;
	public $mapTypeControl;
	public $scaleControl;
	
	public $markers;
	
	public function renderComponent() {
		$this->content = simplexml_load_string($this->content);
		$this->parseOptions();
		$this->parseMarkers();
		
		$this->defaultTemplatesPath = 'Library/MKMapKit/';
		
		$this->view = new UIView();
		$this->view->delegate = $this;
		$this->view->initWithPhtmlNames("MapTemplate");
        
		$this->bufferizeTemplates();
        
		return $this->presentViewControllerToString();
	}
	
	private function parseOptions() {
		$this->centerLatLng = strval($this->content->options->center);
		$this->zoom = strval($this->content->options->zoom);
		$this->type = strval($this->content->options->type);
		$this->scrollwheel = strval($this->content->options->scrollwheel);
		$this->draggable = strval($this->content->options->draggable);
		$this->allowzoom = strval($this->content->options->allowzoom);
		$this->allowscroll = strval($this->content->options->allowscroll);
		
		$this->navigationControl = strval($this->content->options->controls->navigationControl);
		$this->mapTypeControl = strval($this->content->options->controls->mapTypeControl);
		$this->scaleControl = strval($this->content->options->controls->scaleControl);
	}
	
	private function parseMarkers() {
		$markers = $this->content->markers;
		if ($markers->marker) {
			$this->markers = array();
			foreach ($markers->marker as $mark) {
				$marker = $mark->attributes();
				$this->markers[] = array("lat" => strval($marker->lat), "lon" => strval($marker->lon), "title" => strval($mark));
			}
		}
	}
	
}

?>