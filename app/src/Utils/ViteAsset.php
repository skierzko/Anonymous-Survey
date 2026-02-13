<?php
namespace App\Utils;

class ViteAsset
{
    private array $manifest;

    public function __construct(string $manifestPath)
    {
        if (!file_exists($manifestPath)) {
            throw new \RuntimeException("Vite manifest not found: $manifestPath");
        }
        $this->manifest = json_decode(file_get_contents($manifestPath), true);
    }

    public function asset(string $entry): string
    {
        if (!isset($this->manifest[$entry])) {
            throw new \RuntimeException("Entry '$entry' not found in Vite manifest.");
        }
        return '/build/' . $this->manifest[$entry]['file'];
    }

    public function css(string $entry): array
    {
        if (!isset($this->manifest[$entry])) {
            throw new \RuntimeException("Entry '$entry' not found in Vite manifest.");
        }
        return $this->manifest[$entry]['css'] ?? [];
    }
}
