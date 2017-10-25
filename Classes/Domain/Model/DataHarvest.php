<?php
namespace VV\T3view\Domain\Model;

class DataHarvest
{
    /**
     * @var string
     */
    protected $typo3Version = '';

    /**
     * @var string
     */
    protected $phpVersion = '';

    /**
     * @var string
     */
    protected $siteName = '';

    /**
     * @var string
     */
    protected $serverSoftware = '';

    /**
     * @var string
     */
    protected $databaseVersion = '';

    /**
     * @var string
     */
    protected $applicationContext = '';

    /**
     * @var bool
     */
    protected $usesComposer = false;

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @return string
     */
    public function getTypo3Version()
    {
        return $this->typo3Version;
    }

    /**
     * @param string $typo3Version
     */
    public function setTypo3Version(string $typo3Version)
    {
        $this->typo3Version = $typo3Version;
    }

    /**
     * @return string
     */
    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    /**
     * @param string $phpVersion
     */
    public function setPhpVersion(string $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * @param string $siteName
     */
    public function setSiteName(string $siteName)
    {
        $this->siteName = $siteName;
    }

    /**
     * @return string
     */
    public function getServerSoftware()
    {
        return $this->serverSoftware;
    }

    /**
     * @param string $serverSoftware
     */
    public function setServerSoftware(string $serverSoftware)
    {
        $this->serverSoftware = $serverSoftware;
    }

    /**
     * @return string
     */
    public function getDatabaseVersion()
    {
        return $this->databaseVersion;
    }

    /**
     * @param string $databaseVersion
     */
    public function setDatabaseVersion(string $databaseVersion)
    {
        $this->databaseVersion = $databaseVersion;
    }

    /**
     * @return string
     */
    public function getApplicationContext()
    {
        return $this->applicationContext;
    }

    /**
     * @param string $applicationContext
     */
    public function setApplicationContext(string $applicationContext)
    {
        $this->applicationContext = $applicationContext;
    }

    /**
     * @return bool
     */
    public function getUsesComposer()
    {
        return $this->usesComposer;
    }

    /**
     * @param bool $usesComposer
     */
    public function setUsesComposer(bool $usesComposer)
    {
        $this->usesComposer = $usesComposer;
    }

    /**
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * A single extension must follow this exact pattern:
     * [
     *     'key' => 't3view',
     *     'version' => '1.0.0'
     * ]
     *
     * @param array $extensions
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }
}
