<?php

declare(strict_types=1);

namespace Sigmie\Index\Analysis\Normalizer;

use Exception;
use Sigmie\Index\Contracts\Normalizer as NormalizerInterface;

use function Sigmie\Functions\name_configs;
use Sigmie\Index\Contracts\Tokenizer as TokenizerInterface;

abstract class Normalizer implements NormalizerInterface
{
    public static function fromRaw(array $raw): NormalizerInterface
    {
        [$name, $config] = name_configs($raw);

        throw new Exception("Normalizer of type '{$config['type']}' doesn't exists.");
    }
}
