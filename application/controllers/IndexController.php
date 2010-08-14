<?php

/**
 * Index controller
 *
 * Default controller for TMobile.
 * 
 * @uses       Zend_Controller_Action
 * @package    TMobile
 * @subpackage Controller
 */
Class IndexController extends AppController{

    public function indexAction(){

       
    }

    public function moboAction(){
       try{

           $mobile = new Zend_Session_Namespace( 'mobile' );
           $this->view->mobile = $mobile->device;
           #$scriptPaths = $this->view->getScriptPaths();
           #echo '<pre>'; print_r( $scriptPaths );
           //$this->view->setBasePath( APPLICATION_PATH.SEP.'views'.SEP );
           

           # change the layout according the device capabilities
           $this->_helper->layout->setLayout( 'layout_2' );
           Zend_Session::destroy();

       }catch( Exception $e ){ echo $e->getMessage(); }
    }

    public function mobikrAction(){
      
    }

}// IndexController
