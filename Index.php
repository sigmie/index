<?php

declare(strict_types=1);

namespace Sigmie\Index;

use Sigmie\Index\Actions as ActionsIndex;
use Sigmie\Index\Contracts\Mappings as MappingsInterface;
use Sigmie\Index\Contracts\Settings as SettingsInterface;

/**
 * @property-read string $name
 * @property-read Mappings $mappings
 * @property-read Settings $settings
 */
class Index
{
    use ActionsIndex;

    protected SettingsInterface $settings;

    protected MappingsInterface $mappings;

    public function __construct(
        protected string $name,
        SettingsInterface $settings = null,
        MappingsInterface $mappings = null
    ) {
        $this->settings = $settings ?: new Settings();
        $this->mappings = $mappings ?: new Mappings();
    }

    public function __set(string $name, mixed $value): void
    {
        if ($name === 'name' && isset($this->name)) {
            $class = $this::class;
            user_error("Error: Cannot modify readonly property {$class}::{$name}");
        }

        if ($name === 'settings' && isset($this->settings)) {
            $class = $this::class;
            user_error("Error: Cannot modify readonly property {$class}::{$name}");
        }

        if ($name === 'mappings' && isset($this->mappings)) {
            $class = $this::class;
            user_error("Error: Cannot modify readonly property {$class}::{$name}");
        }
    }

    public function __get(string $attribute): mixed
    {
        return $this->$attribute;
    }

    public static function fromRaw(string $name, array $raw): static
    {
        $settings = Settings::fromRaw($raw);
        $analyzers = $settings->analysis()->analyzers();
        $mappings = Mappings::fromRaw($raw['mappings'], $analyzers);

        $index = new static($name, $settings, $mappings);

        return $index;
    }

    public function delete(): bool
    {
        return $this->deleteIndex($this->name);
    }
}
