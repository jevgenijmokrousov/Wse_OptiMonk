<?php

/**
 * Wse_OptiMonk_CartController
 *
 * @author peterfodor
 * @since 2017.12.28. 13:27
 */
class Wse_OptiMonk_CartController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        header("Content-type:application/json");
        $response = Mage::helper('optimonk')->getCartScript();

        $this->getResponse()->setBody($response);
    }
}