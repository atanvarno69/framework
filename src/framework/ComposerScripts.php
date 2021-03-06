<?php
/**
 * ComposerScripts class file.
 *
 * @package   Atan\Framework
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atan\Framework;

use Composer\{
    Installer\PackageEvent,
    Script\Event
};

class ComposerScripts
{
    public static function postPackageInstall(PackageEvent $event)
    {
        $installPath = self::getPackageInstallDir($event);
        if (!self::hasAssetsDir($installPath)) {
            return;
        }
        $names = self::getNames($installPath);
        $assetsPath = Core::path(dirname(__DIR__, 2), 'public', 'assets');
        $vendorPath = Core::path($assetsPath, $names['vendor']);
        self::createDirectoryIfMissing($assetsPath);
        self::createDirectoryIfMissing($vendorPath);
        symlink(
            Core::path($installPath, 'assets'),
            Core::path($vendorPath, $names['package'])
        );
    }

    public static function prePackageUninstall(PackageEvent $event)
    {
        $installPath = self::getPackageInstallDir($event);
        if (!self::hasAssetsDir($installPath)) {
            return;
        }
        $names = self::getNames($installPath);
        $assetsDir = Core::path(dirname(__DIR__, 2), 'public', 'assets');
        $vendorDir = Core::path($assetsDir, $names['vendor']);
        $link = $vendorDir . DIRECTORY_SEPARATOR . $names['package'];
        if (file_exists($link)) {
            unlink($link);
        }
        self::deleteDirectoryIfEmpty($vendorDir);
        self::deleteDirectoryIfEmpty($assetsDir);
    }
    
    public static function postRootPackageInstall(Event $event = null)
    {
        $dir = include Core::path(
            dirname(__DIR__, 2),
            'config',
            'directories.php'
        );
        $dirs = [
            $dir['assets'],
            $dir['config'],
            $dir['public'],
            Core::path($dir['public'], 'assets'),
            Core::path($dir['public'], 'assets', 'atan'),
            $dir['resources'],
            $dir['storage'],
            Core::path($dir['storage'], 'cache'),
            Core::path($dir['storage'], 'log'),
        ];
        foreach ($dirs as $dir) {
            self::createDirectoryIfMissing($dir);
        }
        $link = Core::path($dir['public'], 'assets', 'atan', 'framework');
        symlink($dir['assets'], $link);
    }

    private static function createDirectoryIfMissing(string $path)
    {
        if (file_exists($path)) {
            return;
        }
        mkdir($path);
    }

    private static function deleteDirectoryIfEmpty(string $path)
    {
        if (!file_exists($path)) {
            return;
        }
        if (count(scandir($path)) !== 2) {
            return;
        }
        rmdir($path);
    }

    private static function getNames(string $packageInstallDir): array
    {
        $listing = array_reverse(
            explode(DIRECTORY_SEPARATOR, $packageInstallDir)
        );
        $return = [
            'vendor' => $listing[1],
            'package' => $listing[0]];
        return $return;
    }

    private static function getPackageInstallDir(PackageEvent $event): string
    {
        $package = $event->getOperation()->getPackage();
        $installationManager = $event->getComposer()->getInstallationManager();
        return $installationManager->getInstallPath($package);
    }

    private static function hasAssetsDir(string $packageInstallDir): bool
    {
        $list = scandir($packageInstallDir);
        return in_array('assets', $list);
    }
}
