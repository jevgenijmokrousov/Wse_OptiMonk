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
 * Class Wse_OptiMonk_Block_Cart
 */
class Wse_OptiMonk_Block_Cart extends Wse_OptiMonk_Block_Entrycode
{
    /**
     * Return all cart/quote items as array
     *
     * @return array
     */
    public function getProducts()
    {
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $this->getQuote();
        if (empty($quote)) {
            return array();
        }

        $data = array();
        foreach($quote->getAllVisibleItems() as $item) {
            /** @var Mage_Sales_Model_Quote_Item $item */
            $product = $item->getProduct();

            $data[$item->getSku()] = array(
                "product_id" => $product->getId(),
                "name" => $product->getName(),
                "price" => $item->getPrice(),
                "row_total" => $item->getRowTotal(),
                "quantity" => $item->getQty(),
                "category_ids" => "|" . implode("|", $product->getCategoryIds()) . "|"
            );
        }

        return $data;
    }

    /**
     * Return all quote items as JSON
     *
     * @return string
     */
    public function getItemsAsJson()
    {   
        return json_encode($this->getProducts());
    }
}
