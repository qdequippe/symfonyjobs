<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('config')
    ->exclude('public/build')
    // exclude files generated by Symfony Flex recipes
    ->notPath('bin/console')
    ->notPath('public/index.php')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->registerCustomFixers(new PedroTroller\CS\Fixer\Fixers())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'PedroTroller/exceptions_punctuation' => true,
        'PedroTroller/line_break_between_method_arguments' => [ 'max-args' => 4, 'max-length' => 120, 'automatic-argument-merge' => true ],
        'PedroTroller/line_break_between_statements' => true,
        'PedroTroller/doctrine_migrations' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/var/.php-cs-fixer.cache')
;
