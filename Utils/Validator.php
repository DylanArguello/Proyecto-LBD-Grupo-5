<?php
class Validator {
  public static function required($v): bool { return !is_null($v) && trim((string)$v) !== ''; }
  public static function email($v): bool    { return filter_var($v, FILTER_VALIDATE_EMAIL) !== false; }
  public static function enum($v, array $opts): bool { return in_array($v, $opts, true); }
  public static function money($v): bool    { return is_numeric($v) && $v >= 0; }
  public static function dateYmd($v): bool  { return (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$v); }
  public static function timeHm($v): bool   { return (bool)preg_match('/^\d{2}:\d{2}$/', (string)$v); }
}
