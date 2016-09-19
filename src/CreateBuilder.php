<?php

namespace Fuelcreate\Scaffold;

trait CreateBuilder
{
    
    public $backup = true;
    
    public function _create($relation, $relate = '_has_many', $has = true)
    {
        $i = 0;
        foreach ($relation as $key => $table) {
            $rules      = '';
            $forms      = '';
            $properties = array();
            $fields     = array();
            
            $query = \DB::select()->from('INFORMATION_SCHEMA.COLUMNS')->where('TABLE_SCHEMA', '=', \DB::expr('Database()'))->where('TABLE_NAME', '=', $key)->execute();
            
            foreach ($query as $info) {
                if ($info['COLUMN_KEY'] != 'PRI' && $info['COLUMN_NAME'] != 'created_at' && $info['COLUMN_NAME'] != 'updated_at') {
                    $rule = array();
                    $forms .= "\t\t<div class=\"form-group\"><?= Form::label('" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "', '{$info['COLUMN_NAME']}', array('class'=>'control-label')); ?>" . PHP_EOL;
                    
                    $required = "''";
                    if ($info['IS_NULLABLE'] == 'NO') {
                        $rule[]   = 'required';
                        $required = "'required' => 'required'";
                    }
                    if (in_array($info['DATA_TYPE'], array(
                        'varchar',
                        'string',
                        'char'
                    ))) {
                        if ($info['COLUMN_NAME'] === 'email' || $info['COLUMN_NAME'] === 'mail') {
                            $rule[] = 'valid_email';
                            $forms .= "\t\t<?= Form::input('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array('required' => 'required','type' => 'email', 'class' => 'col-md-4 form-control', 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                        } else {
                            $forms .= "\t\t<?= Form::input('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array($required, 'class' => 'col-md-4 form-control', 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                        }
                        $rule[] = !is_null($info['CHARACTER_MAXIMUM_LENGTH']) ? "max_length[{$info['CHARACTER_MAXIMUM_LENGTH']}]" : 'max_length[255]';
                    } elseif (in_array($info['DATA_TYPE'], array(
                        'int',
                        'integer',
                        'tinyint'
                    ))) {
                        $rule[] = 'valid_string[numeric]';
                        $forms .= "\t\t<?= Form::input('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array($required,'type' => 'number', 'class' => 'col-md-4 form-control', 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                    } elseif (in_array($info['DATA_TYPE'], array(
                        'datetime',
                        'date',
                        'timestamp'
                    ))) {
                        $rule[] = 'valid_date[Y-m-d H:i:s]';
                        $forms .= "\t\t(Y-m-d H:i:s)<?= Form::input('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array($required,'type' => 'datetime','class' => 'col-md-4 form-control', 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                    } elseif ($info['DATA_TYPE'] == 'text') {
                        $forms .= "\t\t<?= Form::textarea('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array($required,'class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                    } else {
                        $forms .= "\t\t<?= Form::input('{$info['COLUMN_NAME']}', Input::post('{$info['COLUMN_NAME']}', isset(\${$key}) ? \${$key}->{$info['COLUMN_NAME']} : ''), array($required,'class' => 'col-md-4 form-control', 'placeholder'=>'" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "')); ?></div>" . PHP_EOL;
                    }
                    
                    if (count($rule) > 0) {
                        $add = implode('|', $rule);
                        $rules .= str_repeat(' ', 11) . '$val->add_field(\'' . $info['COLUMN_NAME'] . "','" . ucwords(str_replace('_', ' ', $info['COLUMN_NAME'])) . "','$add');" . PHP_EOL;
                    }
                    $fields[] = $info['COLUMN_NAME'];
                }
                $properties[] = $info['COLUMN_NAME'];
            }
            
             $app_name = str_replace('_', '', strtolower($key));
	     $model = ucfirst($app_name);
             $id  = $properties[0];
			
             if ($relate == false) {
                $expCode = '';
             } else {
                $expCode = isset($this->example[$i]) ? $this->example[$i] : '';
             }
				
            
            if ($has) {
	        $content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'create.php');				
                $this->makeFile('views', $app_name, 'create', $content);
		$content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'edit.php');
		$this->makeFile('views', $app_name, 'edit', $content);
		$content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'view.php');
		$this->makeFile('views', $app_name, 'view', $content, $this->backup);
		$content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'index.php');
		$this->makeFile('views', $app_name, 'index', $content, $this->backup);
		$content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . '_form.php');
		$this->makeFile('views', $app_name, '_form', $content, $this->backup);
		$content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'controller.php');
		$this->makeFile('classes', 'controller', $app_name, $content, $this->backup);
            }
			
	    if ($relate) {
		$related = 'protected static $' . $relate . ' = ' . var_export($relation[$key], true) . ';' . PHP_EOL;
		$related = str_replace("=> \n", '=>', $related);
		$related = str_replace('    ', '        ', $related);
		$related = str_replace("\n", PHP_EOL . '       ', $related);
	    } else {
		$related = '';
	    }
			
	    $content = include(__DIR__ . DIRECTORY_SEPARATOR . 'stencil' . DIRECTORY_SEPARATOR . 'model.php');
            $this->makeFile('classes', 'model', $app_name, $content, $this->backup);
            $i++;
        }
    }
    
    protected function makeFile($dir, $model, $file, $content, $backup = false)
    {
        
        $file = APPPATH . $dir . DS . $model . DS . $file . '.php';
        if (file_exists($file) && $backup == true) {
            if (file_exists($file . '~')) {
		for($i = 1; $i <= 10; $i++){
		    if (!file_exists($file . '~' . $i)) {
                        rename($file, $file . '~' . $i);
		        echo 'File Backup: ' . $file . '~' . $i . PHP_EOL;
			break;
		    }
		}
            } else {
                rename($file, $file . '~');
		echo 'File Backup: ' . $file . '~' . PHP_EOL;
            }
            
        }
        is_dir(dirname($file)) or mkdir(dirname($file), 0775, true);
        file_put_contents($file, $content);
        echo $file . PHP_EOL;
    }
    
}
