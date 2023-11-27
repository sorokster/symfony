<?php declare(strict_types=1);

namespace App\Shortener\Helper;

use App\Shortener\Interface\IUrlValidator;
use CurlHandle;

class SimpleCurl
{
    protected false|CurlHandle $curl;

    public function __construct(public string $url, protected IUrlValidator $urlValidator)
    {
        if ($this->validateUrl()) {
            $this->init();
        }
    }

    /** @return void */
    public function init(): void
    {
        $this->curl = curl_init($this->url);
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
    }

    /** @return string */
    public function execute(): string
    {
        return (string)curl_exec($this->curl);
    }

    /**
     * @param int $option
     * @return mixed
     */
    public function getInfo(int $option): mixed
    {
        return curl_getinfo($this->curl, $option);
    }


    /** @return void */
    public function close(): void
    {
        curl_close($this->curl);
    }

    /**
     * @param int $name
     * @param string|bool|int $value
     * @return SimpleCurl
     */
    public function setOption(int $name, string|bool|int $value): SimpleCurl
    {
        curl_setopt($this->curl, $name, $value);
        return $this;
    }

    /** @return bool */
    protected function validateUrl(): bool
    {
        return $this->urlValidator->validate($this->url);
    }
}

