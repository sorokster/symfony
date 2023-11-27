<?php declare(strict_types=1);

namespace App\Shortener;

use App\Shortener\Helper\SimpleCurl;
use App\Shortener\Interface\IUrlCodeService;
use App\Shortener\Interface\IUrlDecoder;
use App\Shortener\Interface\IUrlEncoder;
use App\Shortener\Validator\UrlValidator;
use App\Shortener\ValueObject\UrlCodeValueObject;
use InvalidArgumentException;

class UrlShortener implements IUrlEncoder, IUrlDecoder
{
    private string $salt = 'encode';
    protected int $maxLength = 10;

    public function __construct(public IUrlCodeService $service)
    {
    }

    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string
    {
        if (!$this->validateUrl($url)) {
            throw new InvalidArgumentException('Website is not exist');
        }

        $code = substr(hash_hmac('sha256', $url, $this->salt), 0, $this->maxLength);

        if (empty($this->service->getRecord($code))) {
            $this->service->addRecord(new UrlCodeValueObject($url, $code));
        }

        return $code;
    }

    /**
     * @param string $code
     * @return string
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string
    {
        if (empty($record = $this->service->getRecord($code))) {
            throw new InvalidArgumentException('Url is not found');
        }

        return $record->getUrl();
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function validateUrl(string $url): bool
    {
        $curl = new SimpleCurl($url, new UrlValidator());
        $curl
            ->setOption(CURLOPT_RETURNTRANSFER, 1)
            ->setOption(CURLOPT_FOLLOWLOCATION, 1);
        $curl->execute();
        $httpCode = $curl->getInfo(CURLINFO_HTTP_CODE);
        $curl->close();

        return $httpCode === 200;
    }
}
