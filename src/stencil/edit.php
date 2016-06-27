<?php
return <<<EOT
<h2>Edit <span class='muted'>${!${''} = ucfirst(str_replace('_', ' ', $key))}</span></h2>
<br>
<?= render('$app_name/_form')?>
<p>
	<?= Html::anchor('$app_name/view/'.\${$app_name}->{$id} , 'View');?> |
	<?= Html::anchor('$app_name', 'Back');?>
</p>
EOT;
?>
