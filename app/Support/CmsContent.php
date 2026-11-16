<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

final class CmsContent
{
    public static function html(?string $content): string
    {
        static $purifier;

        if ($purifier === null) {
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Cache.SerializerPath', storage_path('framework/cache'));
            $config->set('HTML.Allowed', 'h1,h2,h3,h4,h5,h6,p,div,span,br,hr,strong,b,em,i,u,ul,ol,li,blockquote,a[href|title],img[src|alt|width|height],table,thead,tbody,tr,td,th,pre,code');
            $purifier = new HTMLPurifier($config);
        }

        return $purifier->purify($content ?? '');
    }
}
