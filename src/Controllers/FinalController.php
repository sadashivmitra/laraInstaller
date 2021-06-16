<?php

namespace Sadashiv\LaraInstaller\Controllers;

use Illuminate\Routing\Controller;
use Sadashiv\LaraInstaller\Events\LaraInstallerFinished;
use Sadashiv\LaraInstaller\Helpers\EnvironmentManager;
use Sadashiv\LaraInstaller\Helpers\FinalInstallManager;
use Sadashiv\LaraInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Sadashiv\LaraInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Sadashiv\LaraInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Sadashiv\LaraInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaraInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
