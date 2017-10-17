<?php
namespace VV\T3view\Service;

use TYPO3\CMS\About\Domain\Repository\ExtensionRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use VV\T3view\Domain\Model\DataHarvest;

class SystemInformationService implements SingletonInterface
{
    /**
     * @return DataHarvest
     */
    public static function createDataHarvest()
    {
        $dataHarvest = new DataHarvest();
        $dataHarvest->setSitename($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);
        $dataHarvest->setServerSoftware($_SERVER['SERVER_SOFTWARE']);
        $dataHarvest->setDatabaseVersion(self::getDatabaseVersion());
        $dataHarvest->setApplicationContext(self::getApplicationContext());
        $dataHarvest->setComposer(self::isComposer());
        $dataHarvest->setExtensions(self::getExtensions());

        return $dataHarvest;
    }

    /**
     * @return string
     */
    public static function getApplicationContext()
    {
        return GeneralUtility::getApplicationContext()->__toString();
    }

    /**
     * Get installed extensions (excluding system extensions).
     *
     * @return array
     */
    public static function getExtensions()
    {
        $extensions = [];
        $extensionRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(ExtensionRepository::class);

        foreach ($extensionRepository->findAllLoaded() as $extension) {
            $extensions[] = [
                'key' => $extension->getKey(),
                'version' => ExtensionManagementUtility::getExtensionVersion($extension->getKey())
            ];
        };

        return $extensions;
    }

    /**
     * For getting the database version we have to deal with different methods.
     * Since TYPO3 v8 we get the version via an abstraction layer which is
     * more future prove.
     * For v6 we need to perform a plain query and for v7 we have do have a method.
     *
     * @return string
     */
    public static function getDatabaseVersion()
    {
        $currentTYPO3Version = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        $version = 'n/a';

        if ($currentTYPO3Version <= VersionNumberUtility::convertVersionNumberToInteger('7.0.0')) {
            // TYPO3 < v7
            $version = $GLOBALS['TYPO3_DB']->sql_fetch_assoc(
                $GLOBALS['TYPO3_DB']->sql_query('SELECT @@version')
            )['@@version'];
        } else if ($currentTYPO3Version <= VersionNumberUtility::convertVersionNumberToInteger('8.0.0')) {
            // TYPO3 < v8
            $version = $GLOBALS['TYPO3_DB']->getServerVersion();
        } else {
            // TYPO3 >= 8
            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $connection = $connectionPool->getConnectionByName(
                // We only use the first connection, because we usally don't use more than
                // one database. In the future or when we build a bigger website with more
                // than one database we can update this to a more generic method.
                $connectionPool->getConnectionNames()[0]
            );
            $version = $connection->getServerVersion();
        }

        return $version;
    }

    /**
     * Will return true for a composer instance or false if it isn't.
     * We do a version comparison because versions older than TYPO3 v7 are not installable via Composer.
     *
     * @return bool
     */
    public static function isComposer()
    {
        $currentTYPO3Version = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        $composer = false;

        if ($currentTYPO3Version >= VersionNumberUtility::convertVersionNumberToInteger('7.0.0')) {
            $composer = Bootstrap::usesComposerClassLoading();
        }

        return $composer;
    }
}
