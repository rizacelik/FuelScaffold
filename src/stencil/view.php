<?php
$content = <<<EOT
<h2>Viewing <span class='muted'><?=\${$app_name}->{$id}?></span></h2>
<br>
EOT;

foreach ($fields as $field):
	$content .= "\t" . '<p><strong>' . ucwords(str_replace('_', ' ', $field)) . '</strong>' . PHP_EOL;
	$content .= "\t<?=\$" . $app_name . '->' . $field . '?><p>' . PHP_EOL;
endforeach;
                
$content .= <<<EOT
<p>
	<?= Html::anchor('$app_name/view/'.\${$app_name}->{$id}, 'View');?> |
	<?= Html::anchor('$app_name', 'Back');?>
</p>
EOT;
return $content;
?>
