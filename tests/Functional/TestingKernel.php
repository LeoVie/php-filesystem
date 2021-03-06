<?php

declare(strict_types=1);

namespace LeoVie\PhpFilesystem\Tests\Functional;

use LeoVie\PhpFilesystem\PhpFilesystemBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestingKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new PhpFilesystemBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}