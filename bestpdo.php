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

class DB
{
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $dbname = 'test';
    private static $charset = 'utf8';

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
            $dsn = 'mysql:host='.self::$host.';dbname='.self::$dbname.';charset='.self::$charset;
            self::$instance = new PDO($dsn, self::$user, self::$pass, $opt);
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
		parent::execute($data);
		return $this;
	}
}
