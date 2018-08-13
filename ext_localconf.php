<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'VV.' . $_EXTKEY,
    'Pi1',
    [
        'DataHarvest' => 'gatherData'
    ],
    // We disable caching for the »gatherData« action to guarantee
    // data timeliness.
    [
        'DataHarvest' => 'gatherData'
    ]
);

// Include TypoScript setup for accessing the action via /?type=5996
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
    t3viewGatherDataHarvest = PAGE
    t3viewGatherDataHarvest {
        typeNum = 5996

        config {
            disableAllHeaderCode = 1
            additionalHeaders {
                10.header = Content-Type: application/javascript;charset=UTF-8
            }
            xhtml_cleaning = 0
            debug = 0
        }

        1000 = USER_INT
        1000 {
            userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run

            vendorName = VV
            extensionName = T3view
            pluginName = Pi1
            controller = DataHarvest
            action = gatherData
        }
    }
');
