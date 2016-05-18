<?php

class HelperArray {

  const ARRAY_REPLACE = 0;
  const ARRAY_MERGE = 1;

  /**
   * Convert $delimiter delimited string to array
   *
   * @param mixed  $string
   * @param string $delimiter
   *
   * @return array
   */
  public static function stringToArray($string, $delimiter = ',') {
    return is_string($string) && !empty($string) ? explode($delimiter, $string) : array();
  }

  /**
   * Convert single value to array by reference
   *
   * @param mixed &$value
   */
  public static function makeArrayRef(&$value, $index = 0) {
    !is_array($value) ? $value = array($index => $value) : false;
  }


  /**
   * Convert single value to array
   *
   * @param mixed $value
   *
   * @return array
   */
  public static function makeArray($value, $index = 0) {
    static::makeArrayRef($value, $index);

    return $value;
  }

  /**
   * Filters array by callback
   *
   * @param mixed    $array
   * @param callable $callback
   *
   * @return array
   */
  public static function filter(&$array, $callback) {
    $result = array();

    if (is_array($array) && !empty($array)) {
      foreach ($array as $value) {
        if (call_user_func($callback, $value)) {
          $result[] = $value;
        }
      }

    }

    return $result;
  }

  /**
   * Filter empty() values from array
   *
   * @param $array
   *
   * @return array
   */
  public static function filterEmpty($array) {
    return static::filter($array, 'Validators::isNotEmpty');
  }

  /**
   * @param string $string
   * @param string $delimiter
   *
   * @return array
   */
  public static function stringToArrayFilterEmpty($string, $delimiter = ',') {
    return static::filterEmpty(static::stringToArray($string, $delimiter));
  }

  /**
   * @param mixed|array &$arrayOld
   * @param mixed|array $arrayNew
   * @param int         $mergeStrategy - default is HelperArray::ARRAY_REPLACE
   */
  public static function merge(&$arrayOld, $arrayNew = array(), $mergeStrategy = HelperArray::ARRAY_REPLACE) {
    if (!is_array($arrayOld)) {
      $arrayOld = array($arrayOld);
    }

    static::makeArrayRef($arrayNew);

    switch ($mergeStrategy) {
      case HelperArray::ARRAY_MERGE:
        $arrayOld = array_merge($arrayOld, $arrayNew);
      break;

      default:
        $arrayOld = $arrayNew;
      break;
    }
  }

}
