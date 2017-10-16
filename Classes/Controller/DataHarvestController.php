<?php
namespace VV\T3view\Controller;

use TYPO3\CMS\About\Domain\Repository\ExtensionRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use TYPO3\CMS\Extbase\Object\ObjectManager;
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
        //$configurationUtility = GeneralUtility::makeInstance(ObjectManager::class)->get(ConfigurationUtility::class);
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

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $dataHarvest->setDatabaseVersion(
            $connectionPool->getConnectionByName(
                // We only use the first connection, because we usally don't use more than
                // a single database. In the future or when we build a bigger website with
                // more than one database we can update this.
                $connectionPool->getConnectionNames()[0]
            )->getServerVersion()
        );

        $dataHarvest->setApplicationContext((string)GeneralUtility::getApplicationContext());
        $dataHarvest->setComposer(Bootstrap::usesComposerClassLoading());

        // Get installed extensions (excluding system extensions) and add them to the data harvest
        $extensionRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(ExtensionRepository::class);
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

}
