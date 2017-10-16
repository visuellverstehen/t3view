<?php
defined('TYPO3_MODE') || die();

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
        }

        1000 = USER_INT
        1000 {
            userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run

            vendorName = VV
            extensionName = T3view
            pluginName = Pi1
            controller = DataHarvest
            action = gatherData

            view {
                templateRootPaths.10 = EXT:t3view/Resources/Private/Templates/DynamicContent/
                partialRootPaths.10 = EXT:t3view/Resources/Private/Partials/DynamicContent/
                layoutRootPaths.10 = EXT:t3view/Resources/Private/Layouts/DynamicContent/
            }
        }
    }
');
