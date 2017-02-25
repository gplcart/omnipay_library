<?php

/**
 * @package GPL Cart core
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2015, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl.html GNU/GPLv3
 */

namespace gplcart\modules\omnipay_library;

use gplcart\core\Library;
use gplcart\core\models\Language as LanguageModel;
use gplcart\core\helpers\Session as SessionHelper;

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
     * Language model instance
     * @var \gplcart\core\models\Language $language
     */
    protected $language;

    /**
     * Session helper class instance
     * @var \gplcart\core\classes\Session $session
     */
    protected $session;

    /**
     * Constructor
     * @param Library $library
     * @param LanguageModel $language
     * @param SessionHelper $session
     */
    public function __construct(Library $library, LanguageModel $language,
            SessionHelper $session)
    {
        $this->library = $library;
        $this->session = $session;
        $this->language = $language;
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
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->library->clearCache();
        $this->session->setMessage($this->language->text('Cache has been cleared'), 'success');
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->library->clearCache();
        $this->session->setMessage($this->language->text('Cache has been cleared'), 'success');
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->library->clearCache();
        $this->session->setMessage($this->language->text('Cache has been cleared'), 'success');
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->library->clearCache();
        $this->session->setMessage($this->language->text('Cache has been cleared'), 'success');
    }

}
