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
            'version' => '1.0.0-alfa.1',
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
     * Implements "afterEnable" callback
     * @see \gplcart\core\models\Module
     */
    public function afterEnable()
    {
        $this->library->clearCache();
    }

    /**
     * Implements "afterDisable" callback
     * @see \gplcart\core\models\Module
     */
    public function afterDisable()
    {
        $this->library->clearCache();
    }

    /**
     * Implements "afterInstall" callback
     * @see \gplcart\core\models\Module
     */
    public function afterInstall()
    {
        $this->library->clearCache();
    }

    /**
     * Implements "afterUninstall" callback
     * @see \gplcart\core\models\Module
     */
    public function afterUninstall()
    {
        $this->library->clearCache();
    }

}
