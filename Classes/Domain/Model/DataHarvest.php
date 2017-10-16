<?php
namespace VV\T3view\Domain\Model;

class DataHarvest
{
    /**
     * @var string
     */
    protected $typo3_version = TYPO3_version;

    /**
     * @var string
     */
    protected $php_version = PHP_VERSION;

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
    public function getTypo3Version(): string
    {
        return $this->typo3_version;
    }

    /**
     * @return string
     */
    public function getPhpVersion(): string
    {
        return $this->php_version;
    }

    /**
     * @return string
     */
    public function getSitename(): string
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
    public function getServerSoftware(): string
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
    public function getDatabaseVersion(): string
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
    public function getApplicationContext(): string
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
    public function isComposer(): bool
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
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @param array $extensions
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * A single extension should follow this exact pattern:
     * [
     *     'key' => 't3view',
     *     'version' => '1.0.0'
     * ]
     *
     * @param array $extension
     */
    public function addExtension(array $extension)
    {
        $this->extensions[] = $extension;
    }
}
