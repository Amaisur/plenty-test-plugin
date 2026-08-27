<?php

namespace PlentyTestPlugin\Configs;

use Plenty\Plugin\ConfigRepository;

/**
 * Reads a plugin config value with a safe fallback to a hardcoded default.
 *
 * Every *Config::get() class in this folder uses this so a blank, missing,
 * or malformed value entered in the plentymarkets backend (Plugin ->
 * Configuration) never breaks rendering — it just silently falls back to
 * the built-in default instead of throwing.
 */
class ConfigHelper
{
    public static function text(ConfigRepository $config, string $key, string $default): string
    {
        $value = $config->get($key);
        return (is_string($value) && trim($value) !== '') ? $value : $default;
    }

    public static function int(ConfigRepository $config, string $key, int $default): int
    {
        $value = $config->get($key);
        return (is_numeric($value)) ? (int) $value : $default;
    }

    /**
     * Decodes a JSON-array config field (used for repeating content like nav
     * items, hero slides, footer columns). Falls back to $default whenever
     * the field is blank or fails to decode into an array.
     */
    public static function json(ConfigRepository $config, string $key, array $default): array
    {
        $raw = $config->get($key);
        if (!is_string($raw) || trim($raw) === '') {
            return $default;
        }

        $decoded = json_decode($raw, true);

        // json_decode() returns null (not an array) on malformed JSON, so the
        // is_array() check alone is enough to detect a parse failure. Do not add
        // a json error-code check here: that function is not on plentymarkets'
        // allowed-function list and fails plugin validation on deployment.
        return is_array($decoded) ? $decoded : $default;
    }
}
