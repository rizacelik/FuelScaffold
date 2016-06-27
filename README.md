# FuelPHP Scaffold Generator
FuelPHP scaffold fast create database tables Crud code.
FuelPHP Scaffold All (Model, Controller, views) Generator


## Usage

### Step 1: Install Through Composer

```
composer require fuelcreate/scaffold:"dev-master"
```

### Step 2: Creating a task


In Fuel Tasks are put in the `fuel/app/tasks` directory. Below is an example of the task "`Scaffolds`":

```
<?php 
namespace Fuel\Tasks;

class Scaffolds
{
    use \Fuelcreate\Scaffold\Scaffold;
    public function run()
    {
		return $this->fire();
    }
}
```


### Step 3: That will be called via the refine utility within oil:

~~~
php oil refine Scaffolds
~~~



## Examples

```
C:\xampp\htdocs\fuelphp>php oil refine Scaffolds

==================================================
Found 14 database tables to generate scaffold for.
==================================================

Generate all controller, model and views? [ y, n ]: y

==================================================
Notice: Backup file exists? [ y, n ]: n
==================================================

C:\xampp\htdocs\fuelphp\fuel\app\views\categories\create.php
C:\xampp\htdocs\fuelphp\fuel\app\views\categories\edit.php
C:\xampp\htdocs\fuelphp\fuel\app\views\categories\view.php
C:\xampp\htdocs\fuelphp\fuel\app\views\categories\index.php
C:\xampp\htdocs\fuelphp\fuel\app\views\categories\_form.php
C:\xampp\htdocs\fuelphp\fuel\app\classes\controller\categories.php
C:\xampp\htdocs\fuelphp\fuel\app\classes\model\categories.php
C:\xampp\htdocs\fuelphp\fuel\app\views\posts\create.php
C:\xampp\htdocs\fuelphp\fuel\app\views\posts\edit.php
C:\xampp\htdocs\fuelphp\fuel\app\views\posts\view.php
C:\xampp\htdocs\fuelphp\fuel\app\views\posts\index.php
C:\xampp\htdocs\fuelphp\fuel\app\views\posts\_form.php
.....

C:\xampp\htdocs\fuelphp>
```

