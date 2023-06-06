<?php

namespace Timo\Cms\Util;

use Timo\Cms\Enums\AppEnv;

class Config
{
    public function __construct(
        public readonly string $templatesDir,
        public readonly string $publicDir,
        public readonly AppEnv $appEnv
    ) {
    }
}
