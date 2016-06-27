<?php
namespace Fuelcreate\Scaffold;

trait Scaffold
{
    use Relation;
	use CreateBuilder;
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

		$found_tables = $this->relate();
		if (count($found_tables) == 0) {
            \Cli::write('Database not found tables. Please; before scaffolding, create table or tables.');
            return false;
        }
		
        echo PHP_EOL;
		\Cli::write(str_repeat("=", 50), 'blue');
        \Cli::write('Found ' . count($found_tables) . ' database tables to generate scaffold for.', 'green');
		\Cli::write(str_repeat("=", 50), 'blue');
		echo PHP_EOL;
        
        $answer = \Cli::prompt('Generate all controller, model and views?', array( 'y', 'n' ));
		
        if ($answer == 'n') {
            \Cli::write('End create scaffold.');
            return false;
        }
		
        echo PHP_EOL;
		\Cli::write(str_repeat("=", 50), 'red');
		$answer = \Cli::prompt('Notice: Backup file exists?', array( 'y', 'n' ));
		\Cli::write(str_repeat("=", 50), 'red');
		echo PHP_EOL;
		
		$this->backup = ($answer == 'y') ? true : false;
		
		
        $this->_create($this->hasmany);
        $this->_create($this->belongsto, '_belongs_to', false);
		$this->_create($this->noRelate(), false);
        
    }
    
 
}
