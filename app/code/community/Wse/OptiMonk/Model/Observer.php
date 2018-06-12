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
 */
class Wse_OptiMonk_Model_Observer extends Mage_Core_Model_Session_Abstract
{
    /**
     * Listen to the event core_block_abstract_to_html_after
     *
     * @parameter Varien_Event_Observer $observer
     * @return $this
     */
    public function coreBlockAbstractToHtmlAfter($observer)
    {
        if ($this->getModuleHelper()->isEnabled() == false) {
            return $this;
        }

        $block = $observer->getEvent()->getBlock();
        if($block->getNameInLayout() == 'root') {

            $transport = $observer->getEvent()->getTransport();
            $html = $transport->getHtml();

            $script = Mage::helper('optimonk')->getHeaderScript();

            if (empty($script)) {
                return $this;
            }

            $html = preg_replace('/\<\/head\>([^\>]+)\<body([^\>]+)\>/', '\0'.$script, $html);

            $transport->setHtml($html);
        }

        return $this;
    }

    /**
     * Logging plugin install
     */
    public function sendDataToOptimonk()
    {
        $url = 'https://front.optimonk.com/apps/magento/connect';
        $domain = parse_url(Mage::getBaseUrl( Mage_Core_Model_Store::URL_TYPE_WEB));

        $data = array(
            "user" => trim($this->getModuleHelper()->getId()),
            "domain" => $domain['host'],
            "version" => Mage::getVersion()
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Magento OM plugin");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
    }

    /**
     * @return Wse_Optimonk_Helper_Data
     */
    protected function getModuleHelper()
    {
        return Mage::helper('optimonk');
    }
}
