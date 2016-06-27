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

#Example Relation Model Class


```
<?php

class Model_Posts extends \Orm\Model
{

	protected static $_properties = array(
           'id',
           'title',
           'content',
           'comment_allow',
           'post_date',
	);

	protected static $_table_name = 'posts';

	public static function validate($factory)
	{
	     $val = Validation::forge($factory);
           $val->add_field('title','Title','required|max_length[255]');
           $val->add_field('content','Content','required');
           $val->add_field('comment_allow','Comment Allow','required|valid_string[numeric]');
           $val->add_field('post_date','Post Date','required|valid_date[Y-m-d H:i:s]');

	       return $val;
	}

    protected static $_has_many = array (
         'postscategories' =>  array (
               'key_from' => 'id',
               'model_to' => 'Model_Postscategories',
               'key_to' => 'posts_id',
         ),
         'postscomments' =>  array (
               'key_from' => 'id',
               'model_to' => 'Model_Postscomments',
               'key_to' => 'posts_id',
         ),
         'postslikes' =>  array (
               'key_from' => 'id',
               'model_to' => 'Model_Postslikes',
               'key_to' => 'posts_id',
         ),
         'poststags' =>  array (
               'key_from' => 'id',
               'model_to' => 'Model_Poststags',
               'key_to' => 'posts_id',
         ),
         'postsusers' =>  array (
               'key_from' => 'id',
               'model_to' => 'Model_Postsusers',
               'key_to' => 'posts_id',
         ),
       );

       
}

```


## Scaffold
![image](http://i66.tinypic.com/be79h.png)
![image](http://i64.tinypic.com/2rdi4xw.png)


