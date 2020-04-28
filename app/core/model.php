<?
class Model
{
	public function get_data()
	{
        
	}

	public function clearResult($result)
	{
		$result = (array)$result;
		unset($result['queryString']);
		return $result;
	}
}
?>