<?php

/**
 * Application bootstrap
 * Responsible for setting the class and file loaders, Registry, DB Singletons, etc.
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package 
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{

    protected function _initAutoload(){

      $autoloader = new Zend_Application_Module_Autoloader(array(
        'namespace' => '',
        'basePath'  => APPLICATION_PATH,
      ));

      $autoloader->addResourceType( 'mobo', '/../library', 'Mobo' );
      $loader = Zend_Loader_Autoloader::getInstance();
      # setting more autoloaders methods = 'Class' , 'Method'
      $loader->pushAutoloader( array( 'Mobo_DeviceLoader' , 'loadDeviceModel' ) );
      $loader->pushAutoloader( array( 'Mobo_DeviceLoader' , 'loadModel' ) );
     // $loader->pushAutoloader( array( 'Mobo_DeviceLoader' , 'loadBaseLibrary' ) );

        return $autoloader;
    }
    /**
     * Init Session NS, DB conns and register everything in Registry
     */
    protected function _initApp(){

      Zend_Session::start(); # starts the session

      require_once APPLICATION_PATH.SEP.'controllers'.SEP.'AppController.php'; # get the base Controller

      //$this->setHandlers();

      # init and store DB Objects
      if( ! Zend_Registry::isRegistered('db') ){

           $dbWurflConfig = new Zend_Config_Ini( APPLICATION_PATH. '/configs/dbconnx.ini', 'wurfl' );
           $dbwurfl = Zend_Db::factory('PDO_MYSQL', $dbWurflConfig->resources->db->params->toArray() ); # SMSD application DB connector

           $dbModelConfig = new Zend_Config_Ini( APPLICATION_PATH. '/configs/dbconnx.ini', 'model' );
           $dbmodel = Zend_Db::factory('PDO_MYSQL', $dbModelConfig->resources->db->params->toArray() ); # model classes connectors

           $dbwurfl->setFetchMode( PDO::FETCH_OBJ );
           $dbmodel->setFetchMode( PDO::FETCH_OBJ );
           
           #Zend_Registry::set('db', $dbsmsd ); # connX for wurfl DB
           Zend_Registry::set('dbmodel', $dbmodel ); # connX for mobikr DB
           Zend_Db_Table_Abstract::setDefaultAdapter( $dbmodel ); # default connector
      }

      # if the mobile properties isn't setted, sets it up
      if( ! Zend_Session::namespaceIsset( 'mobile' ) ){
        
         $mobile = new Zend_Session_Namespace( 'mobile' );
         $mobile->device = new Device;
      }

       # init the app logs'
      $writer = new Zend_Log_Writer_Stream( APPLICATION_PATH . '/log/application.log' );
      $log = new Zend_Log( $writer );
      $logger->info( 'Application Initiated' , Zend_Log::INFO );
      Zend_Registry::set( 'log',  $log );

      $layout = Zend_Layout::startMvc(); # it is an order for mobile layout changing
    }

    /**
     *
     * @return Zend_View
     */
    protected function _initDocType(){
      
      $this->bootstrap( 'view' );
      $view = $this->getResource( 'view' );
      //$view->doctype( 'XHTML1_TRANSITIONAL' );
      $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper( 'ViewRenderer' );
      
      $viewRenderer->setView( $view );
        return $view;
    }
    /**
     * Set exception and error handlers
     */
    protected function _initSetErrorHandlers(){

      function catchException( Exception $e ){

        echo 'Houve uma excecao<br>Mensagem:<b> '.$e->getMessage().'</b><br>';
        echo 'Arquivo:<b> '.$e->getFile().'</b></br>';
        echo 'Linha: <b>'.$e->getLine().'</b></br>';
        echo 'Codigo: <b>'.$e->getCode().'</b></br>';
      }

      set_exception_handler( 'catchException' );
      
    }
    
    
}
