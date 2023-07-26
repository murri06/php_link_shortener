<?php

namespace Acme;

class Link
{
    private string $linkDefault;
    private string $linkShorter;

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

    public function generateLink(): bool
    {
        $short = '';
        for ($i = 0; $i <= 7; $i++) {
            $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $random_index = rand(0, strlen($characters) - 1);
            $short .= $characters[$random_index];
        }


//        if (array_key_exists()) {
//            return false;
//        }

        return $this->linkShorter = $short;
    }
}