<?php

namespace Fuelcreate\Scaffold;

trait Relation
{
    
    public $belongsto = array();
    public $hasmany = array();
    public $example = array();
    public $table_name = array();
    
    public function relate()
    {
        
        $query = \DB::select()->from('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')->where('TABLE_SCHEMA', '=', \DB::expr('Database()'))->where('REFERENCED_TABLE_NAME', null, \DB::expr('IS NOT NULL'))->execute();
        
        $hasmany   = array();
        $belongsto = array();
        $code      = array();
        
        foreach ($query as $row) {
	    $this->table_name[] = $row->TABLE_NAME;
            $code[str_replace('_', '', $row['TABLE_NAME'])][$row['REFERENCED_TABLE_NAME']]    = $row['REFERENCED_TABLE_NAME'];
            $hasmany[$row['REFERENCED_TABLE_NAME']][str_replace('_', '', $row['TABLE_NAME'])] = array(
                'key_from' => $row['REFERENCED_COLUMN_NAME'],
                'model_to' => 'Model_' . str_replace('_', '', ucfirst($row['TABLE_NAME'])),
                'key_to' => $row['COLUMN_NAME']
            );
            
            $belongsto[$row['TABLE_NAME']][$row['REFERENCED_TABLE_NAME']] = array(
                'key_from' => $row['COLUMN_NAME'],
                'model_to' => 'Model_' . ucfirst($row['REFERENCED_TABLE_NAME']),
                'key_to' => $row['REFERENCED_COLUMN_NAME']
            );
        }
        
        foreach ($code as $parents => $tables) {
            
            $model1 = str_replace('_', '', current($tables));
            $model2 = str_replace('_', '', next($tables));
            $model3 = '';
            if (count($tables) > 2) {
                $model  = str_replace('_', '', end($tables));
                $model3 = 'echo $data->' . $model . '->id; //example ' . $model . ' table column name id';
			}
            
			$this->example[] = '
			/*  
			*  Example ' . ucfirst($model1) . ' Model Code
			*
			* $' . $model1 . ' = Model_' . ucfirst($model1) . '::find(\'all\');
			*
			* foreach($' . $model1 . ' as $datas){
			*   echo $datas->id; //example ' . $model1 . ' table column name id
			*
			*   foreach($datas->' . $parents . ' as $data){
			*	   echo $data->' . $model2 . '->id; //example ' . $model2 . ' table column name id
			*      ' . $model3 . '
			*   }
			* }
			*/
			';
            
        }
        
        $found_tables = \DB::select()->from('INFORMATION_SCHEMA.TABLES')->where('TABLE_SCHEMA', '=', \DB::expr('Database()'))->execute();
        
        
        $this->belongsto = $belongsto;
        $this->hasmany   = $hasmany;
        return $found_tables;
    }
    
    public function noRelate()
    {
        
        $query = \DB::select()->from('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')->where('TABLE_SCHEMA', '=', \DB::expr('Database()'))->where('REFERENCED_TABLE_NAME', null, \DB::expr('IS NULL'))->execute();

        $normal = array();
        
        foreach ($query as $row) {

            if (!in_array($row['TABLE_NAME'], $this->table_name)) {
                $normal[$row['TABLE_NAME']] = $row['TABLE_NAME'];
            }
        }
        return $normal;
    }
    
}
