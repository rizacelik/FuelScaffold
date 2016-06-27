<?php 
return '<?php

class Model_' . ucfirst($app_name) . ' extends \Orm\Model
{

	protected static $_properties = array(
           \'' . implode("'," . PHP_EOL . str_repeat(' ', 11) . "'", $properties) . '\',
	);

	protected static $_table_name = \'' . $key . '\';

	public static function validate($factory)
	{
	       $val = Validation::forge($factory);
' . $rules . '
	       return $val;
	}

    ' . $related . '
}
';
?>
