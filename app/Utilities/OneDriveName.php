<?php

namespace App\Utilities;

class OneDriveName
{
    const DEFAULT_NAME = 'OneDrive Folder';

    public function name($url)
    {
        $name = $this->findNameInOgCollegeFiscalPath($url);
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

    private function findNameInOgCollegeFiscalPath($url)
    {
        $matches = [];
        if (preg_match('/\/og_uaa_it\/Documents\/General\/TREQ( |%20)Dev\/treq\/([^?]+)(\?.*)?$/', $url, $matches)) {
        //if (preg_match('/\/uaa_treq\/TREQ( |%20)Files\/([^?]+)(\?.*)?$/', $url, $matches)) {
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
