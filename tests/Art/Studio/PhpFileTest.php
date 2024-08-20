<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Art\Studio\PhpFile;
use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a class', function () {
    $art = new PhpFile(
        draft: Factory::draft('class', 'User'),
        preset: Factory::preset('studio')
    );

    expect($art->generate())
        ->toMatchSnapshot()
        ->and($art->filename())
        ->toEndWith('src/User.php');
});
