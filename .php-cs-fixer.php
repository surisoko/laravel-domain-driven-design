<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor', 'tools', 'bootstrap', 'storage'])
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_unused_imports' => true,
])->setFinder($finder);
