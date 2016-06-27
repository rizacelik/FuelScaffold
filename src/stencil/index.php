<?php
$content = <<<EOT
<h2>Listing <span class='muted'>${!${''} = ucfirst(str_replace('_', ' ', $key))}</span></h2>
<br>
<?php if (\$$app_name): ?>

<table class="table table-striped">
	<thead>
		<tr>
EOT;

foreach ($fields as $field):
	$content .= "\t\t\t" . '<th>' . ucwords(str_replace('_', ' ', $field)) . '</th>' . PHP_EOL;
endforeach;

$content .= <<<EOT
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach (\$$app_name as \$item): ?>
		<tr>
EOT;

foreach ($fields as $field):
	$content .= "\t\t\t" . '<td><?= $item->' . $field . ' ?></td>' . PHP_EOL;
endforeach;

$content .= <<<EOT
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?= Html::anchor('$app_name/view/'.\$item->{$id}, '<i class="glyphicon glyphicon-eye-open"></i> View', array('class' => 'btn btn-info btn-sm')); ?>
						<?= Html::anchor('$app_name/edit/'.\$item->{$id}, '<i class="glyphicon glyphicon-pencil"></i> Edit', array('class' => 'btn btn-warning btn-sm')); ?>
						<?= Html::anchor('$app_name/delete/'.\$item->{$id}, '<i class="glyphicon glyphicon-trash"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php else: ?>

<p>No $app_name </p>

<?php endif; ?>
<p>
	<?= Html::anchor('$app_name/create', 'Add new ${!${''} = ucfirst(str_replace('_', ' ', $key))}', array('class' => 'btn btn-success')); ?>

</p>
EOT;
return $content;
?>
