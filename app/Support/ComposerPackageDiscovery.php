<?php

namespace App\Support;

use Illuminate\Foundation\PackageManifest;

final class ComposerPackageDiscovery
{
    public static function discover(): void
    {
        $app = require dirname(__DIR__, 2).'/bootstrap/app.php';

        $app->make(PackageManifest::class)->build();
    }
}
