<?php
namespace VV\T3view\Controller;

use TYPO3\CMS\About\Domain\Repository\ExtensionRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use VV\T3view\Domain\Model\DataHarvest;

class DataHarvestController extends ActionController
{
    /**
     * @var JsonView
     */
    protected $defaultViewObjectName = JsonView::class;

    /**
     * @var JsonView
     */
    protected $view;

    /**
     * This method will be dispatche before the actual method. This allows
     * us to do some security checks before performing actual stuff.
     *
     * - Checks if the HTTP method is GET. Other methods are not allowed.
     * - Checks if the request secret is valid.
     */
    public function initializeGatherDataAction() {
        //$configurationUtility = $this->objectManager->get(ConfigurationUtility::class);
        //$extensionConfiguration = $configurationUtility->getCurrentConfiguration(strtolower($this->extensionName));
        //$secret = $extensionConfiguration['secret']['value'];
    }

    /**
     * Will gather various
     */
    public function gatherDataAction()
    {
        $dataHarvest = new DataHarvest();
        $dataHarvest->setSitename($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);
        $dataHarvest->setServerSoftware($_SERVER['SERVER_SOFTWARE']);
        $dataHarvest->setDatabaseVersion($this->getDatabaseVersion());
        $dataHarvest->setApplicationContext((string)GeneralUtility::getApplicationContext());
        $dataHarvest->setComposer($this->isComposer());

        // Get installed extensions (excluding system extensions) and add them to the data harvest
        $extensionRepository = $this->objectManager->get(ExtensionRepository::class);
        foreach ($extensionRepository->findAllLoaded() as $extension) {
            $dataHarvest->addExtension([
                'key' => $extension->getKey(),
                'version' => ExtensionManagementUtility::getExtensionVersion($extension->getKey())
            ]);
        };

        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this);
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($dataHarvest);die();

        $this->view->assign('value', $dataHarvest);
    }

    /**
     * For getting the database version we have to deal with different methods.
     * Since TYPO3 v8 we get get the version via an abstraction layer which is
     * more future prove.
     * For v6 we need to perform a plain query and for v7 we have do have a method.
     *
     * @return string
     */
    protected function getDatabaseVersion()
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
            $version = $connectionPool->getConnectionByName(
                // We only use the first connection, because we usally don't use more than
                // one database. In the future or when we build a bigger website with more
                // than one database we can update this to a more generic method.
                $connectionPool->getConnectionNames()[0]
            )->getServerVersion();
        }

        return $version;
    }

    /**
     * @return bool
     */
    protected function isComposer()
    {
        $composer = false;

        // Check if TYPO3 version is higher or equal than v7, because TYPO3 is only installable via composer since v7.
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= VersionNumberUtility::convertVersionNumberToInteger('7.0.0')) {
            $composer = Bootstrap::usesComposerClassLoading();
        }

        return $composer;
    }
}
