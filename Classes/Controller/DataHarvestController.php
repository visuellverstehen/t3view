<?php
namespace VV\T3view\Controller;

use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use VV\T3view\Domain\Model\DataHarvest;
use VV\T3view\Service\SystemInformationService;

class DataHarvestController extends ActionController
{
    /**
     * @var JsonView
     */
    protected $defaultViewObjectName = JsonView::class;

    /**
     * @var JsonView
     */
    protected $view = null;

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
     * Action that will return a DataHarvest object with a bunch of important
     * information as JSON.
     */
    public function gatherDataAction()
    {
        $dataHarvest = SystemInformationService::createDataHarvest();

        // We change the default JsonView configuration to render the »$dataHarvest->extensions«
        // attribute. By default the JsonView does not support the rendering of array or object
        // attributes.
        // Docs: https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/extbase/Classes/Mvc/View/JsonView.php#L60-L158
        $this->view->setConfiguration([
            'value' => [
                '_descend' => [
                    'extensions' => []
                ]
            ]
        ]);

        // The default JsonView only supports the rendering of variables named »value«.
        $this->view->assign('value', $dataHarvest);
    }
}
