<?php

namespace Acme;

class Link
{
    private string $linkDefault;
    private string $linkShorter;

    /**
     * @param string $linkDefault
     */
    public function __construct(string $linkDefault)
    {
        $this->linkDefault = $linkDefault;
    }


    /**
     * @return string
     */
    public function getLinkDefault(): string
    {
        return $this->linkDefault;
    }

    /**
     * @param string $linkDefault
     */
    public function setLinkDefault(string $linkDefault): void
    {
        $this->linkDefault = $linkDefault;
    }

    /**
     * @return string
     */
    public function getLinkShorter(): string
    {
        return $this->linkShorter;
    }

    public function generateLink($pdo): bool
    {
        $short = substr(md5(microtime()), rand(0, 26), 7);
        if ($pdo->getLinkValidation($short)) {
            return false;
        }

        return $this->linkShorter = $short;
    }
}