<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'VV.' . $_EXTKEY,
    'Pi1',
    [
        'DataHarvest' => 'gatherData',
    ],
    // non-cacheable action(s)
    [
        'DataHarvest' => 'gatherData',
    ]
);
