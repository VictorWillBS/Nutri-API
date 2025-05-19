<?php

declare(strict_types=1);

namespace App\Support;

use Exception;
use Illuminate\Support\Facades\Storage;

class FileEditor
{
    private const MAX_CHUCK_OF_GZ = 100;
    private string $path;

    public function __construct(
        protected string $filename,
        protected string $dir,
        protected string | array  $content = ''
    ) {
        $this->path = $dir . '/' . $filename;
    }

    public function store(): void
    {
        if ($this->isGzippedContent()) {
            $this->content = $this->decompress();
        }

        Storage::put($this->path, trim($this->content));
    }

    public function get(): array|string
    {
        $content = Storage::get($this->path);
        $this->content = $content;
        return $content;
    }

    public function txtToArray(): array
    {
        $result = [];
        $index = 0;
        foreach (explode("\n", $this->content) as $line) {
            if ($index >= 100) {
                return array_filter($result);
            }

            $result[] = trim($line);
            $index++;
        }

        return array_filter($result);
    }

    public function decompress()
    {
        $tempGzPath = tempnam(sys_get_temp_dir(), 'gz_');
        file_put_contents($tempGzPath, $this->content);
        $json = $this->extractJsonFromGz($tempGzPath);
        unlink($tempGzPath);

        return $json;
    }

    public function extractJsonFromGz(string $tempGzPath)
    {
        $stream = gzopen($tempGzPath, 'rb');
        if (!$stream) {
            throw new Exception("Não foi possível abrir o arquivo gzip: {$tempGzPath}", 1);
        }

        $jsonContent = "";
        while (!gzeof($stream)) {
            $jsonContent .= gzread($stream, 4096);
        }
        gzclose($stream);

        $this->content = $jsonContent;

        $this->filename = str_replace('.gz', '', $this->filename);
        $this->updatePath();
        return json_encode(array_chunk($this->txtToArray(), self::MAX_CHUCK_OF_GZ)[0]);

    }

    function fixJsonSyntax(string $jsonContent): string
    {
        // Remover espaços em branco extras no começo e no final
        $jsonContent = trim($jsonContent);

        // Corrigir erros comuns:

        // Remover vírgulas extras no final de objetos ou arrays
        // Exemplo: {"key": "value",}
        $jsonContent = preg_replace('/,\s*([\]}])/', '$1', $jsonContent);

        // Corrigir aspas simples para aspas duplas (JSON deve usar aspas duplas)
        $jsonContent = str_replace("'", '"', $jsonContent);

        // Se necessário, adicionar chaves de fechamento no final
        if ($jsonContent[0] !== '{' && $jsonContent[0] !== '[') {
            // Se o JSON não começa com um objeto ou array, tentamos adicionar chaves
            $jsonContent = '{"root":' . $jsonContent . '}';
        }

        return $jsonContent;
    }

    public function isGzippedContent(): bool
    {
        return substr($this->content, 0, 2) === "\x1F\x8B";
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function updatePath(): void
    {
        $this->path = $this->dir . '/' . $this->filename;
    }
}
