<?php

require __DIR__ . '/vendor/autoload.php'; // Stelle sicher, dass der Autoloader geladen wird

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        Finder::create()
            ->in(__DIR__)           // Aktuelles Verzeichnis
            ->exclude('vendor')     // 'vendor'-Ordner ausschließen
    );
