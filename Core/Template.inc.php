<?php
class Core_Template {

	// create template
	function __construct($page)
	{
		$this->template .= implode('', file($page));
	}
	
	// replace placeholder with dynamic data
	function placeholder($place_holder, $dyn_data)
	{
		$this->template = str_replace($place_holder, stripslashes($dyn_data), $this->template);
	}
	
	// replace placeholder array: replace array keys (placeholder) with array value's
	function placeholder_array($array)
	{
		foreach($array as $key => $value) {
			if(is_array($value)) {
				foreach($value as $inner_key => $inner_value) {
					$tmp_value .= $inner_value;
				}
				$this->placeholder('{'.$key.'}', $tmp_value);
				unset($tmp_value);
			} else{
				$this->placeholder('{'.$key.'}', nl2br($value));
			}
		}
	}	
	
	// extract html commented block from template
	function getblok($name)
	{
		@eregi('<!-- BEGIN '.$name.' -->(.*)<!-- END '.$name.' -->', $this->template, $arr);
		$this->placeholder($arr[0], '{'.$name.'}');
		return $arr[1];	
	}
	
	// remove all placeholders
	function cleanup_placeholders($replacement = false)
	{
		$this->template = eregi_replace('\{[[:alnum:]_.]*\}', $replacement, $this->template);
	}	
	
	// return the template as string
	function return_as_string()
	{
		return($this->template); 
	}	
	
	// print the template to output
	function parse()
	{
		print($this->template);
	}	
}