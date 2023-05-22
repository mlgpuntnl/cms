<?php

namespace Timo\Cms\Util;

class Config
{
    public function __construct(
        public readonly string $templatesDir,
        public readonly string $publicDir
    ) {
    }
}
