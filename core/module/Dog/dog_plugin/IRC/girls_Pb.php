<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show the IRC girls who %BOT% likes the most.',
		'like' => 'I like %s.',
	),
);

$plugin = Dog::getPlugin();

$girls = array(
	'PoisonIvy',
	'Wyshfire',
	'gemgale',
	'Unholy',
	'bb',
);

$girl = $girls[array_rand($girls)];

$plugin->rply('like', array($girl));
?>