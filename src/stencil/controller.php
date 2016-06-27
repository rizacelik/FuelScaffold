<?php 
$content = '<?php
class Controller_' . $model . ' extends Controller_Template
{

	public function action_index()
	{
		' . $expCode . '
		
		$data[\'' . $app_name . '\'] = Model_' . $model . '::find(\'all\');
		$this->template->title = "Categories";
		$this->template->content = View::forge(\'' . $app_name . '/index\', $data);

	}

	public function action_view($' . $id . ' = null)
	{
		is_null($' . $id . ') and Response::redirect(\'' . $app_name . '\');

		if ( ! $data[\'' . $app_name . '\'] = Model_' . $model . '::find($' . $id . '))
		{
			Session::set_flash(\'error\', \'Could not find ' . $app_name . ' #\'.$' . $id . ');
			Response::redirect(\'' . $app_name . '\');
		}

		$this->template->title = "' . $model . '";
		$this->template->content = View::forge(\'' . $app_name . '/view\', $data);

	}

	public function action_create()
	{
		if (Input::method() == \'POST\')
		{
			$val = Model_' . $model . '::validate(\'create\');

			if ($val->run())
			{
				$' . $app_name . ' = Model_' . $model . '::forge(array(
';
                
                foreach ($fields as $field):
                    $content .= "\t\t\t\t\t'" . $field . '\' => Input::post(\'' . $field . '\'),' . PHP_EOL;
                endforeach;
                
                $content .= '				));

				if ($' . $app_name . ' and $' . $app_name . '->save())
				{
					Session::set_flash(\'success\', \'Added ' . $app_name . ' #\'.$' . $app_name . '->' . $id . '.\'.\');

					Response::redirect(\'' . $app_name . '\');
				}

				else
				{
					Session::set_flash(\'error\', \'Could not save ' . $app_name . '.\');
				}
			}
			else
			{
				Session::set_flash(\'error\', $val->error());
			}
		}

		$this->template->title = "' . ucfirst($app_name) . '";
		$this->template->content = View::forge(\'' . $app_name . '/create\');

	}

	public function action_edit($' . $id . ' = null)
	{
		is_null($' . $id . ') and Response::redirect(\'' . $app_name . '\');

		if ( ! $' . $app_name . ' = Model_' . $model . '::find($' . $id . '))
		{
			Session::set_flash(\'error\', \'Could not find ' . $app_name . ' #\'.$' . $id . ');
			Response::redirect(\'' . $app_name . '\');
		}

		$val = Model_' . $model . '::validate(\'edit\');

		if ($val->run())
		{
';
                
                foreach ($fields as $field):
                    $content .= "\t\t\t\t\$" . $app_name . '->' . $field . ' = Input::post(\'' . $field . '\');' . PHP_EOL;
                endforeach;
                
                $content .= '
            if ($' . $app_name . '->save())
			{
				Session::set_flash(\'success\', \'Updated ' . $app_name . ' #\' . $' . $id . ');

				Response::redirect(\'' . $app_name . '\');
			}

			else
			{
				Session::set_flash(\'error\', \'Could not update ' . $app_name . ' #\' . $' . $id . ');
			}
		}

		else
		{
			if (Input::method() == \'POST\')
			{
				
';
                
                foreach ($fields as $field):
                    $content .= "\t\t\t\t\$" . $app_name . '->' . $field . ' = $val->validated(\'' . $field . '\');' . PHP_EOL;
                endforeach;
                
                $content .= '

				Session::set_flash(\'error\', $val->error());
			}

			$this->template->set_global(\'' . $app_name . '\', $' . $app_name . ', false);
		}

		$this->template->title = "' . ucfirst($app_name) . '";
		$this->template->content = View::forge(\'' . $app_name . '/edit\');

	}

	public function action_delete($' . $id . ' = null)
	{
		is_null($' . $id . ') and Response::redirect(\'' . $app_name . '\');

		if ($' . $app_name . ' = Model_' . $model . '::find($' . $id . '))
		{
			$' . $app_name . '->delete();

			Session::set_flash(\'success\', \'Deleted ' . $app_name . ' #\'.$' . $id . ');
		}

		else
		{
			Session::set_flash(\'error\', \'Could not delete ' . $app_name . ' #\'.$' . $id . ');
		}

		Response::redirect(\'' . $app_name . '\');

	}

}
';
return $content;
?>
