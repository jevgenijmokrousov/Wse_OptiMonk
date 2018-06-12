<?php
/**
 * OptiMonk plugin for Magento 1.7+
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For a copy of the GNU General Public License, see <http://www.gnu.org/licenses/>.
 *
 * @package     Wse_OptiMonk
 * @copyright   Copyright (c) 2016 Webshop Marketing Kft (www.optimonk.com)
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * @author      Tibor Berna
 *
 * Class Wse_OptiMonk_Block_Entrycode
 */
class Wse_OptiMonk_Block_Entrycode extends Mage_Core_Block_Template
{
    /**
     * Return whether this module is enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getModuleHelper()->isEnabled();
    }

    /**
     * Get the OptiMonk account ID
     *
     * @return mixed
     */
    public function getId()
    {
        return trim($this->getModuleHelper()->getId());
    }

    /**
     * Return a configuration value
     *
     * @param null $key
     * @param null $default_value
     *
     * @return mixed
     */
    public function getConfig($key = null, $default_value = null)
    {
        return $this->getModuleHelper()->getConfigValue($key, $default_value);
    }

    /**
     * Get the OptiMonk helper
     *
     * @return Wse_Optimonk_Helper_Data
     */
    public function getModuleHelper()
    {
        return Mage::helper('optimonk');
    }

    /**
     * Get the OptiMonk container
     *
     * @return Wse_OptiMonk_Model_Container
     */
    public function getContainer()
    {
        return Mage::getSingleton('optimonk/container');
    }

    /**
     * @return bool
     */
    public function hasAttributes()
    {
        $attributes = $this->getAttributes();
        if(!empty($attributes)) {
            return true;
        }
        return false;
    }

    /**
     * Return all attributes as JSON
     *
     * @return string
     */
    public function getAttributesAsJson()
    {
        $attributes = $this->getAttributes();
        return json_encode($attributes);
    }

    /**
     * Add a new attribute to the OM container
     *
     * @param $name
     * @param $value
     *
     * @return Varien_Object
     */
    public function addAttribute($name, $value)
    {
        return $this->getContainer()->setData($name, $value);
    }

    /**
     * Get the configured attributes for the OM container
     *
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->getContainer()->getData();
    }

    /**
     * Return a product collection
     *
     * @return bool|object
     */
    public function getProductCollection()
    {
        return false;
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function jsonEncode($data)
    {
        $string = json_encode($data);
        $string = str_replace('"', "'", $string);
        return $string;
    }

    /**
     * @param $childScript
     */
    public function setChildScript($childScript)
    {
        $this->childScript = $childScript;
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $html = parent::_toHtml();
        if (empty($html)) {
            $html = ' ';
        }

        return $html;
    }
}
