<?php

/**
 * @package Omnipay Library
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2015, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl.html GNU/GPLv3
 */

namespace gplcart\modules\omnipay_library;

/**
 * Main class for Omnipay Library module
 */
class Main
{

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['omnipay'] = array(
            'name' => 'Omnipay', // @text
            'description' => 'A framework agnostic, multi-gateway payment processing library for PHP 5.3+', // @text
            'url' => 'https://github.com/thephpleague/omnipay',
            'download' => 'https://github.com/thephpleague/omnipay-common/archive/2.5.2.zip',
            'type' => 'php',
            'version' => '2.5.2',
            'module' => 'omnipay_library',
            'vendor' => 'omnipay/common',
        );
    }

    /**
     * Returns an array of gateways extracted from registered namespaces
     * @return array
     */
    public function getGateways()
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
     * @param null|string $gateway
     * @return mixed
     */
    public function getGatewayInstance($gateway = null)
    {
        require __DIR__ . '/vendor/autoload.php';

        foreach ($this->getGateways() as $id) {
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
     * Returns registered namespaces from composer's autoload file
     * @return array
     */
    protected function getGatewayNamespaces()
    {
        $file = GC_DIR_VENDOR . '/composer/autoload_psr4.php';

        if (!is_readable($file)) {
            return array();
        }

        $namespaces = include $file;
        return array_keys($namespaces);
    }

}
