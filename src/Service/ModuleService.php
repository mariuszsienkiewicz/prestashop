<?php

declare(strict_types=1);

namespace MyParcelNL\PrestaShop\Service;

use Module;
use MyParcelNL\Pdk\Facade\Logger;
use MyParcelNL\Pdk\Facade\Pdk;
use MyParcelNL\PrestaShop\Pdk\Installer\Exception\InstallationException;

final class ModuleService
{
    /**
     * @return \MyParcelNL
     */
    public function getInstance(): Module
    {
        return Pdk::get('moduleInstance');
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return Module::isEnabled($this->getInstance()->name);
    }

    /**
     * @return void
     * @throws \MyParcelNL\PrestaShop\Pdk\Installer\Exception\InstallationException
     * @noinspection PhpUnused
     */
    public function registerHooks(): void
    {
        $instance = $this->getInstance();

        foreach (Pdk::get('moduleHooks') as $hook) {
            if ($instance->registerHook($hook)) {
                Logger::debug("Hook $hook registered");
                continue;
            }

            throw new InstallationException(sprintf('Hook %s could not be registered', $hook));
        }
    }
}
