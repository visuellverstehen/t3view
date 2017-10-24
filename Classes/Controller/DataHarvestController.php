<?php
namespace VV\T3view\Controller;

use TYPO3\CMS\Core\Error\Http\StatusException;
use TYPO3\CMS\Core\Error\Http\UnauthorizedException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use VV\T3view\Domain\Model\DataHarvest;
use VV\T3view\Service\SystemInformationService;

/**
 * Controller which will validate the request and
 * creating a data harvest (object) which will
 * then beeing output as JSON.
 */
class DataHarvestController extends ActionController
{
    /**
     * Holds all allowed HTTP methods. Other methods
     * will throw an exception.
     *
     * @var array
     */
    const ALLOWED_HTTP_METHODS = ['GET'];

    /**
     * @var JsonView
     */
    protected $defaultViewObjectName = JsonView::class;

    /**
     * @var JsonView
     */
    protected $view = null;

    /**
     * This method will be dispatched before the actual method. This allows
     * us to do some security checks before performing actual stuff.
     *
     * - Checks if the HTTP method is allowed. Other methods are not allowed.
     * - Checks if the requests secret is the same as the stored secret.
     */
    public function initializeGatherDataAction() {
        if (!in_array($this->request->getMethod(), self::ALLOWED_HTTP_METHODS)) {
            throw new StatusException(
                HttpUtility::HTTP_STATUS_405,
                'The method [' . $this->request->getMethod() . '] is not allowed by the controller [' . __CLASS__ . '].',
                'Oops, an error occurred!',
                1508246619
            );
        }

        // Getting the secret through the TYPO3 API instead of accessing it directly.
        $configurationUtility = $this->objectManager->get(ConfigurationUtility::class);
        $extensionConfiguration = $configurationUtility->getCurrentConfiguration(strtolower($this->extensionName));
        $secret = $extensionConfiguration['secret']['value'];

        // Authenticate request
        if ($secret !== GeneralUtility::_GET('secret')) {
            throw new UnauthorizedException(
                'Accessing this page requires authorization.',
                1508246620
            );
        }
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
        // Docs: https://github.com/TYPO3/TYPO3.CMS/blob/v8.7.8/typo3/sysext/extbase/Classes/Mvc/View/JsonView.php#L60-L158
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
