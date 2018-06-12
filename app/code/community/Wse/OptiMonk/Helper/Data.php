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
 * Class Wse_Optimonk_Helper_Data
 */
class Wse_Optimonk_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check whether the module is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->getConfigValue('active', false);
    }

    /**
     * Return the OptiMonk ID
     *
     * @return string
     */
    public function getId()
    {
        return trim($this->getConfigValue('id'));
    }

    /**
     * Return a configuration value
     *
     * @param null $key
     * @param null $default_value
     *
     * @return mixed|null
     */
    public function getConfigValue($key = null, $default_value = null)
    {
        $value = Mage::getStoreConfig('optimonk/settings/' . $key);
        if (empty($value)) {
            $value = $default_value;
        }

        return $value;
    }

    /**
     * Fetch a specific block
     *
     * @param $name
     * @param $type
     * @param $template
     *
     * @return bool|Mage_Core_Block_Template
     */
    public function fetchBlock($name, $type, $template)
    {
        /** @var Mage_Core_Model_Layout $layout */
        if (!($layout = Mage::app()->getFrontController()->getAction()->getLayout())) {
            return false;
        }

        /** @var Mage_Core_Block_Template $block */
        if ($block = $layout->getBlock('optimonk_' . $name)) {
            $block->setTemplate('optimonk/' . $template);

            return $block;
        }

        if ($block = $layout->createBlock('optimonk/' . $type)) {
            $block->setTemplate('optimonk/' . $template);

            return $block;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getHeaderScript()
    {
        $response = '';
        $block = $this->fetchBlock('entrycode', 'entrycode', 'entrycode.phtml');

        if (!$block) {
            return $response;
        }

        return $block->toHtml();
    }

    /**
     * @return string
     */
    public function getCartScript()
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = Mage::getModel('checkout/cart')->getQuote();

        if ($quote->getId() > 0) {
            $cartBlock = $this->fetchBlock('cart', 'cart', 'cart.phtml');

            if ($cartBlock) {
                $cartBlock->setQuote($quote);
                $html = $cartBlock->toHtml();

                return $html;
            }
        }

        return "";
    }
}
