<?php
Class AppController extends Zend_Controller_Action{

   public $start;

   public function  __construct( Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {

     parent::__construct( $request, $response, $invokeArgs );
     $this->initView();
     
   }
   /**
    * Set View Object and path to phtml interfaces based on device capabilities ( to implement )
    * @return Zend_View
    */
   public function initView(){
      
      if ( null === $this->view ) { $this->view = new Zend_View(); }
      
      #echo 'Capacidades do dispositivo:<pre>'; print_r( $device->device );exit;
      # gets a namespace setted before in Bootstrap and stored in native Session.
      $mobile = new Zend_Session_Namespace( 'mobile' );
      $this->view->mobile = $mobile->device;

      # adds a path to find custom view helpers for all application versions ( web / wap )
      $this->view->addHelperPath( APPLICATION_PATH . '/views/helpers/' );
      #echo '<pre>';print_r( $this->view->mobile );exit; // test

      # prints the level defined
      #echo $mobile->device->getUIManager()->uiLevel;
      //$this->view->addBasePath( PATH_DEFAULT. 'basic' .SEP );
      #uncomment this in PRO
      $this->view->addBasePath( PATH_DEFAULT. $mobile->device->getUIManager()->uiLevel . SEP );
      #$this->view->addBasePath( PATH_DEFAULT.'web'.SEP );
      #echo '<pre>';print_r( $this->view->getScriptPaths() );exit;

      if( $mobile->device->getUIManager()->uiLevel == 'web' ){ $l = Zend_Layout::getMvcInstance()->setLayout( 'layout_2' ); }
      else{
        $this->view->w = $mobile->device->getDisplay()->maxWidth;
      }
      
      Zend_Session::destroy();
        return $this->view;

   }
   
   //public function  preDispatch(){}
//
//   public function  postDispatch(){
//     $end = microtime( true );
//     $final = $end - $this->start;
//     echo '<br><br>Tempo total entre pre e post dispatch: '.$final;exit();
//   }

}
?>
