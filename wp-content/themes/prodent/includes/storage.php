<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('prodent_storage_get')) {
	function prodent_storage_get($var_name, $default='') {
		global $PRODENT_STORAGE;
		return isset($PRODENT_STORAGE[$var_name]) ? $PRODENT_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('prodent_storage_set')) {
	function prodent_storage_set($var_name, $value) {
		global $PRODENT_STORAGE;
		$PRODENT_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('prodent_storage_empty')) {
	function prodent_storage_empty($var_name, $key='', $key2='') {
		global $PRODENT_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($PRODENT_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($PRODENT_STORAGE[$var_name][$key]);
		else
			return empty($PRODENT_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('prodent_storage_isset')) {
	function prodent_storage_isset($var_name, $key='', $key2='') {
		global $PRODENT_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($PRODENT_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($PRODENT_STORAGE[$var_name][$key]);
		else
			return isset($PRODENT_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('prodent_storage_inc')) {
	function prodent_storage_inc($var_name, $value=1) {
		global $PRODENT_STORAGE;
		if (empty($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = 0;
		$PRODENT_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('prodent_storage_concat')) {
	function prodent_storage_concat($var_name, $value) {
		global $PRODENT_STORAGE;
		if (empty($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = '';
		$PRODENT_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('prodent_storage_get_array')) {
	function prodent_storage_get_array($var_name, $key, $key2='', $default='') {
		global $PRODENT_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($PRODENT_STORAGE[$var_name][$key]) ? $PRODENT_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($PRODENT_STORAGE[$var_name][$key][$key2]) ? $PRODENT_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('prodent_storage_set_array')) {
	function prodent_storage_set_array($var_name, $key, $value) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if ($key==='')
			$PRODENT_STORAGE[$var_name][] = $value;
		else
			$PRODENT_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('prodent_storage_set_array2')) {
	function prodent_storage_set_array2($var_name, $key, $key2, $value) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if (!isset($PRODENT_STORAGE[$var_name][$key])) $PRODENT_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$PRODENT_STORAGE[$var_name][$key][] = $value;
		else
			$PRODENT_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('prodent_storage_merge_array')) {
	function prodent_storage_merge_array($var_name, $key, $value) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if ($key==='')
			$PRODENT_STORAGE[$var_name] = array_merge($PRODENT_STORAGE[$var_name], $value);
		else
			$PRODENT_STORAGE[$var_name][$key] = array_merge($PRODENT_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('prodent_storage_set_array_after')) {
	function prodent_storage_set_array_after($var_name, $after, $key, $value='') {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if (is_array($key))
			prodent_array_insert_after($PRODENT_STORAGE[$var_name], $after, $key);
		else
			prodent_array_insert_after($PRODENT_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('prodent_storage_set_array_before')) {
	function prodent_storage_set_array_before($var_name, $before, $key, $value='') {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if (is_array($key))
			prodent_array_insert_before($PRODENT_STORAGE[$var_name], $before, $key);
		else
			prodent_array_insert_before($PRODENT_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('prodent_storage_push_array')) {
	function prodent_storage_push_array($var_name, $key, $value) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($PRODENT_STORAGE[$var_name], $value);
		else {
			if (!isset($PRODENT_STORAGE[$var_name][$key])) $PRODENT_STORAGE[$var_name][$key] = array();
			array_push($PRODENT_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('prodent_storage_pop_array')) {
	function prodent_storage_pop_array($var_name, $key='', $defa='') {
		global $PRODENT_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($PRODENT_STORAGE[$var_name]) && is_array($PRODENT_STORAGE[$var_name]) && count($PRODENT_STORAGE[$var_name]) > 0) 
				$rez = array_pop($PRODENT_STORAGE[$var_name]);
		} else {
			if (isset($PRODENT_STORAGE[$var_name][$key]) && is_array($PRODENT_STORAGE[$var_name][$key]) && count($PRODENT_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($PRODENT_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('prodent_storage_inc_array')) {
	function prodent_storage_inc_array($var_name, $key, $value=1) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if (empty($PRODENT_STORAGE[$var_name][$key])) $PRODENT_STORAGE[$var_name][$key] = 0;
		$PRODENT_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('prodent_storage_concat_array')) {
	function prodent_storage_concat_array($var_name, $key, $value) {
		global $PRODENT_STORAGE;
		if (!isset($PRODENT_STORAGE[$var_name])) $PRODENT_STORAGE[$var_name] = array();
		if (empty($PRODENT_STORAGE[$var_name][$key])) $PRODENT_STORAGE[$var_name][$key] = '';
		$PRODENT_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('prodent_storage_call_obj_method')) {
	function prodent_storage_call_obj_method($var_name, $method, $param=null) {
		global $PRODENT_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($PRODENT_STORAGE[$var_name]) ? $PRODENT_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($PRODENT_STORAGE[$var_name]) ? $PRODENT_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('prodent_storage_get_obj_property')) {
	function prodent_storage_get_obj_property($var_name, $prop, $default='') {
		global $PRODENT_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($PRODENT_STORAGE[$var_name]->$prop) ? $PRODENT_STORAGE[$var_name]->$prop : $default;
	}
}
?>