<?
class DB
{
	protected static $pdo = null;
	
	private function __construct()
	{
		
	}
	
	public static function DataBase()
	{
		if(self::$pdo === null)
		{
			$host = '127.0.0.1';
			$db   = '';
			$user = '';
			$pass = '';
			$charset = 'utf8';
			$dsn = 'mysql:host=' . $host . '; dbname=' . $db . '; charset=' . $charset;
			$opt = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			);
			self::$pdo = new PDO($dsn, $user, $pass, $opt);
		}
		return self::$pdo;
	}		
}
?>