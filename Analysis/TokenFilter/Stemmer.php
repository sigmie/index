<?php

declare(strict_types=1);

namespace Sigmie\Index\Analysis\TokenFilter;

use function Sigmie\Functions\name_configs;

class Stemmer extends TokenFilter
{
    final public function type(): string
    {
        return 'stemmer_override';
    }

    public static function fromRaw(array $raw): static
    {
        [$name, $configs] = name_configs($raw);
        $settings = [];

        foreach ($configs['rules'] as $value) {
            [$to, $from] = explode('=>', $value);
            $to = explode(', ', $to);
            $from = trim($from);
            $to = array_map(fn ($value) => trim($value), $to);

            $settings[$from] = $to;
        }

        $instance = new static($name, $settings);

        return $instance;
    }

    protected function getValues(): array
    {
        $rules = [];

        foreach ($this->settings as $index => [$to, $from]) {
            $from = implode(', ', $from);
            $rules[] = "{$from} => {$to}";
            // foreach ($from as $word) {
            //     $rules[] = "{$word} => {$to}";
            // }
        }

        return [
            'rules' => $rules,
        ];
    }
}
