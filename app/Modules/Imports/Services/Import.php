<?php

declare(strict_types=1);

namespace App\Modules\Imports\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Import
{
    public function __construct() {}

    public function getFileData(string $filename): string
    {
        $response = $this->request('get', $filename, [], true);
        $stream = $response->toPsrResponse()->getBody();

        $content = '';
        while (!$stream->eof()) {
            $content .= $stream->read(1024 * 1024); // lê em chunks de 1MB
        }

        return $content;
    }

    public function downloadToStorage(string $filename, string $storagePath): void
    {
        $response = $this->request('get', $filename, [], true);

        $stream = $response->toPsrResponse()->getBody();

        Storage::put($storagePath, $stream);
    }

    protected function request(string $method, string $endpoint, ?array $data = [], bool $stream = false)
    {
        $url = config('services.coodesh.endpoint') . $endpoint;

        if ($stream) {
            return Http::withOptions(['stream' => true])->$method($url, $data);
        }

        return Http::$method($url, $data);
    }
}
