<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->name('*.php')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        // Add more custom rules if needed
    ])
    ->setFinder($finder);
