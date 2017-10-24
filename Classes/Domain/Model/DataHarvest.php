<?php
namespace VV\T3view\Domain\Model;

class DataHarvest
{
    /**
     * @var string
     */
    protected $sitename = '';

    /**
     * @var string
     */
    protected $server_software = '';

    /**
     * @var string
     */
    protected $database_version = '';

    /**
     * @var string
     */
    protected $application_context = '';

    /**
     * @var bool
     */
    protected $composer = false;

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @return string
     */
    public function getTypo3Version()
    {
        return TYPO3_version;
    }

    /**
     * @return string
     */
    public function getPhpVersion()
    {
        return PHP_VERSION;
    }

    /**
     * @return string
     */
    public function getSitename()
    {
        return $this->sitename;
    }

    /**
     * @param string $sitename
     */
    public function setSitename(string $sitename)
    {
        $this->sitename = $sitename;
    }

    /**
     * @return string
     */
    public function getServerSoftware()
    {
        return $this->server_software;
    }

    /**
     * @param string $server_software
     */
    public function setServerSoftware(string $server_software)
    {
        $this->server_software = $server_software;
    }

    /**
     * @return string
     */
    public function getDatabaseVersion()
    {
        return $this->database_version;
    }

    /**
     * @param string $database_version
     */
    public function setDatabaseVersion(string $database_version)
    {
        $this->database_version = $database_version;
    }

    /**
     * @return string
     */
    public function getApplicationContext()
    {
        return $this->application_context;
    }

    /**
     * @param string $application_context
     */
    public function setApplicationContext(string $application_context)
    {
        $this->application_context = $application_context;
    }

    /**
     * @return bool
     */
    public function isComposer()
    {
        return $this->composer;
    }

    /**
     * @param bool $composer
     */
    public function setComposer(bool $composer)
    {
        $this->composer = $composer;
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
