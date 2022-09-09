<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Contracts;

use Leeto\MoonShine\ViewComponents\ViewComponents;

interface ViewContract extends \JsonSerializable
{
    public function components(): ViewComponents;
}
