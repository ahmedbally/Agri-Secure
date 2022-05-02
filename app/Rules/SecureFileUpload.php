<?php

namespace App\Rules;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\UploadedFile;
use Sunspikes\ClamavValidator\ClamavValidator;
use voku\helper\AntiXSS;

class SecureFileUpload extends ClamavValidator
{
    /**
     * Creates a new instance of ClamavValidator.
     *
     * ClamavValidator constructor.
     * @param Translator $translator
     * @param array      $data
     * @param array      $rules
     * @param array      $messages
     * @param array      $customAttributes
     */
    public function __construct(
        Translator $translator,
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ) {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function validateSecureFile(string $attribute, $value, array $parameters): bool
    {
        if (!$value instanceof UploadedFile)
        {
            return false;
        }
        if (!preg_match('/^[\p{L}\p{N} _(),-.]+$/u', $value->getClientOriginalName())){
            return false;
        }

        $antiXss = new AntiXSS();
        $antiXss->xss_clean($value->getContent());
        if ($antiXss->isXssFound())
        {
            return false;
        }

        return true;
    }
}
