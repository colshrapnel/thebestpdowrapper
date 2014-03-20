<?php
/**
 * @author col.shrapnel@gmail.com
 * @license Apache license 2.0
 *
 * The best PDO wrapper
 *
 *
 *
**/

define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');

class DB
{
    protected static $instance = null;

    final private function __construct() {}
    final private function __clone() {}

    public static function instance()
    {
        if (self::$instance === null)
        {
			$opt  = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => TRUE,
				PDO::ATTR_STATEMENT_CLASS    => array('myPDOStatement'),
			);
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
        }
        return self::$instance;
    }
    public static function __callStatic($method, $args) {
        return call_user_func_array(array(self::instance(), $method), $args);
    }
}

class myPDOStatement extends PDOStatement
{
	function execute($data = array())
	{
		foreach($data as $param => $value)
		{
			$type  = PDO::PARAM_STR;

			if (is_int($value) || ctype_digit($value))
			{
				$value = intval($value);
				$type  = PDO::PARAM_INT;
			}

			if (is_int($param) || ctype_digit($param))
			{
				$param++;
			}

			$this->bindValue($param, $value, $type);
		}
		parent::execute();
		return $this;
	}
}
