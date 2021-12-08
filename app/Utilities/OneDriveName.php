<?php

namespace App\Utilities;

class OneDriveName
{
    const DEFAULT_NAME = 'OneDrive Folder';

    public function name($url)
    {
        $name = $this->findNameInOgCoeFiscalPath($url);
        if ($name) {
            return $name;
        }

        $name = $this->findNameInQueryId($url);

        return ($name) ?: self::DEFAULT_NAME;
    }

    public function defaultName()
    {
        return self::DEFAULT_NAME;
    }

    private function findNameInOgCoeFiscalPath($url)
    {
        $matches = [];
        if (preg_match('/\/og_coe_fiscal\/shared( |%20)documents\/administrative\/processes\/treq\/([^?]+)(\?.*)?$/', $url, $matches)) {
            return '/treq/' . urldecode($matches[2]);
        }

        return null;
    }

    private function findNameInQueryId($url)
    {
        $idAt = strpos($url, '?id=');
        if ($idAt) {
            return urldecode(substr($url, $idAt + 4));
        }

        return null;
    }
}
