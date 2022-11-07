<?php

declare(strict_types=1);

namespace Sigmie\Index\Analysis\TokenFilter;

use Exception;

use function Sigmie\Functions\name_configs;

class Uppercase extends TokenFilter
{
    public function __construct(
        string $name,
    ) {
        parent::__construct($name, []);
    }

    public function type(): string
    {
        return 'uppercase';
    }

    public static function fromRaw(array $raw): static
    {
        [$name, $configs] = name_configs($raw);

        $instance = new static($name);

        return $instance;
    }

    protected function getValues(): array
    {
        return [];
    }
}
