<?php

namespace Keesschepers\Billink\Response;

use SimpleXMLElement;

class CheckResponse
{
    private $description;
    private $code;
    private $errorCode;
    private $errorDescription;
    private $checkUuId;

    public function __construct($xml)
    {
        $response = new SimpleXMLElement($xml);

        if ($response->ERROR) {
            $this->errorCode = (string)$response->ERROR->CODE;
            $this->errorDescription = (string)$response->ERROR->DESCRIPTION;
        } else {
            $this->code = (string)$response->MSG->CODE;
            $this->description = (string)$response->MSG->DESCRIPTION;

            if ($this->code == '500') {
                $this->checkUuId = (string)$response->UUID;
            }
        }
    }

    public function isError()
    {
        return (null !== $this->errorCode);
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function isCreditWorthy()
    {
        return ($this->code == 500);
    }

    public function getCheckUuId()
    {
        return $this->checkUuId;
    }
}
