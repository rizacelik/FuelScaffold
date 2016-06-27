<?php 
return <<<EOT
<?php echo Form::open(array("class"=>"form-horizontal")); ?>
	<fieldset>
$forms
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?= Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>
		</div>
	</fieldset>
<?php if (isset(\$csrf)): ?>
	<?= Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); ?>
<?php endif; ?>
<?= Form::close();?>
EOT;
?>
