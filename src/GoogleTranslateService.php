<?php


namespace Webtamizhan\LaravelGoogleTranslator;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Translate\V2\TranslateClient;

class GoogleTranslateService
{
    protected TranslateClient $translate;

    /**
     * @throws GoogleException
     */
    public function __construct()
    {
        $this->translate = new TranslateClient([
            'key' => config('google-translator.api_key'),
        ]);
    }

    /**
     * @param string $text
     * @param string $targetLanguage
     * @return mixed
     * @throws ServiceException
     */
    public function translateText(string $text, string $targetLanguage): mixed
    {
        $translation = $this->translate->translate($text, [
            'target' => $targetLanguage,
        ]);

        return $translation['text'];
    }
}
