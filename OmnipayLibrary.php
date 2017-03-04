<?php

/**
 * @package GPL Cart core
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2015, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl.html GNU/GPLv3
 */

namespace gplcart\modules\omnipay_library;

use gplcart\core\Library;

/**
 * Main class for Omnipay Library module
 */
class OmnipayLibrary
{

    /**
     * Library class instance
     * @var \gplcart\core\Library $library
     */
    protected $library;

    /**
     * Constructor
     * @param Library $library
     */
    public function __construct(Library $library)
    {
        $this->library = $library;
    }

    /**
     * Module info
     * @return array
     */
    public function info()
    {
        return array(
            'core' => '1.x',
            'version' => '1.0.0-alfa.2',
            'author' => 'Iurii Makukh',
            'name' => 'Omnipay library',
            'description' => 'A helper module that just provides <a href="https://github.com/thephpleague/omnipay">Omnipay</a> library'
        );
    }

    /**
     * Implements hook "library.config"
     * @param array $configs
     */
    public function hookLibraryConfig(array &$configs)
    {
        $configs['omnipay/common']['omnipay'] = array(
            'name' => 'Omnipay',
            'description' => 'A framework agnostic, multi-gateway payment processing library for PHP 5.3+',
            'url' => 'https://github.com/thephpleague/omnipay',
            'download' => 'https://github.com/thephpleague/omnipay-common/archive/2.5.2.zip',
            'type' => 'php',
            'version' => '2.5.2',
            'module' => 'omnipay_library',
            'files' => array(
                'vendor/autoload.php'
            )
        );
    }

    /**
     * Retuns registered namespaces from composer's autoload file
     * @return array
     */
    protected function getGatewayNamespaces()
    {
        $file = __DIR__ . '/vendor/composer/autoload_psr4.php';
        if (is_readable($file)) {
            $namespaces = include $file;
            return array_keys($namespaces);
        }
        return array();
    }

    /**
     * Returns an array of gateways extracted from registered namespaces
     * @return array
     */
    public function getGatewayIds()
    {
        $gateways = array();

        foreach ($this->getGatewayNamespaces() as $namespace) {
            if (strpos($namespace, 'Omnipay') !== 0) {
                continue;
            }
            $matches = array();
            preg_match('/Omnipay\\\(.+?)\\\/', $namespace, $matches);

            if (isset($matches[1])) {
                $gateways[] = $matches[1];
            }
        }

        return $gateways;
    }

    /**
     * Returns an array of registered gateway instances
     * @return null|object|array
     */
    public function getGatewayInstance($gateway = null)
    {
        $this->library->load('omnipay');

        foreach ($this->getGatewayIds() as $id) {
            $class = \Omnipay\Common\Helper::getGatewayClassName($id);
            if (class_exists($class)) {
                \Omnipay\Omnipay::register($id);
            }
        }

        $instances = array();
        foreach (\Omnipay\Omnipay::find() as $id) {
            $instances[$id] = \Omnipay\Omnipay::create($id);
        }

        if (isset($gateway)) {
            return empty($instances[$gateway]) ? null : $instances[$gateway];
        }

        return $instances;
    }

    /**
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->library->clearCache();
    }

}
