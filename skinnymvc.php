<?php

/***************************************************************************************
 ***                                                                                 ***
 *    SkinnyMVC for PHP                                                                *
 *                                                                                     *
 *    Author: Radoslav Gazo           <rado@49research.com>    :: http://radogazo.com  *
 *            Charles Iliya Krempeaux <charles@49research.com> :: http://changelog.ca  *
 *                                                                                     *
 *    Web:    http://skinnymvc.com                                                     *
 *            http://49research.com                                                    *
 *                                                                                     *
 *                                                                                     *
 *    SkinnyMVC License:                                                               *
 *                                                                                     *
 *    Copyright (c) 2009 49 Research, Inc.                                             *
 *                                                                                     *
 *    Permission is hereby granted, free of charge, to any person                      *
 *    obtaining a copy of this software and associated documentation                   *
 *    files (the "Software"), to deal in the Software without                          *
 *    restriction, including without limitation the rights to use,                     *
 *    copy, modify, merge, publish, distribute, sublicense, and/or sell                *
 *    copies of the Software, and to permit persons to whom the                        *
 *    Software is furnished to do so, subject to the following                         *
 *    conditions:                                                                      *
 *                                                                                     *
 *    The above copyright notice and this permission notice shall be                   *
 *    included in all copies or substantial portions of the Software.                  *
 *                                                                                     *
 *    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,                  *
 *    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES                  *
 *    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND                         *
 *    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT                      *
 *    HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,                     *
 *    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING                     *
 *    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR                    *
 *    OTHER DEALINGS IN THE SOFTWARE.                                                  *
 *                                                                                     *
 ***                                                                                 ***
 ***************************************************************************************/




// This version of skinnymvc.php was built on: 2009-12-18T20:43:01-05:00



// P R O C E D U R E S //////////////////////////////////////////////////////////////////////////////////////////////////////
    function _help()
    {
        $help = '
Usage:
  php skinnymvc.php task_name [argument]

Tasks:
  install       -  Installs new SkinnyMVC framework
  upgrade       -  Upgrades core SkinnyMVC files
  uninstall     -  Uninstalls the SkinnyMVC project (deletes all files in all SkinnyMVC directories)
  createModule  -  Creates new module (Ex.: "php skinnymvc.php createModule login")
  createMod     -  Alias for createModule
  generateSQL   -  Generates sql from schema.php and stores it in lib/skinnymvc/model/sql/database.sql
  generateModel -  Generates model classes from schema.php
  help          -  Displays this help

Other:
  * Make sure that your project\'s tmp directory is writable by the web server
  * Your custom error pages are located in templates

';

        print($help);
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        function _upgrade()
        {
                mkdir('web');
                @file_put_contents('web/dev.php','<?php
/******************************
 * filename: dev.php
 */

    require_once(\'../config/settings.php\');
    require_once(\'../lib/skinnymvc/controller/SkinnyController.php\');
    require_once(\'../lib/skinnymvc/core/SkinnyException.php\');

    SkinnySettings::$CONFIG[\'debug\'] = true;

    $__DEBUG = array(\'sql\'=>array(), \'data\'=>array());

    try {
      $c = new SkinnyController;
      $c->main();
    } catch (SkinnyException $e) {
      echo "<h4>Exception</h4>";
      echo "<div>$e->getMessage()</div>";
      echo "<div>$e->getTrace()</div>";
    }

    echo "<div><pre>".var_export($__DEBUG, true)."</pre></div>";
    ');
                mkdir('web/css');
                mkdir('web/js');
                @file_put_contents('web/.htaccess','Options +FollowSymLinks +ExecCGI

<IfModule mod_rewrite.c>
  RewriteEngine On

  RewriteRule ^(.*)/([^/\\.]+)\\.(gif|jpg|png)$ images/$2.$3 [L]
  RewriteRule ^(.*)/([^/\\.]+)\\.js$ js/$2.js [L]
  RewriteRule ^(.*)/([^/\\.]+)\\.css$ css/$2.css [L]

  RewriteRule ^(dev.php)/([^/\\.]+)/?([^/\\.]+)?/?$ dev.php?__module=$2&__action=$3&%{QUERY_STRING}  [L]
  RewriteRule ^(index.php/)?([^/\\.]+)/?([^/\\.]+)?/?$ index.php?__module=$2&__action=$3&%{QUERY_STRING}  [L]

</IfModule>
    ');
                mkdir('web/images');
                @file_put_contents('web/index.php','<?php
/******************************
 * filename: index.php
 */

    require_once(\'../config/settings.php\');
    require_once(\'../lib/skinnymvc/controller/SkinnyController.php\');

    $c = new SkinnyController;
    $c->main();

   ');
                mkdir('modules');
                @file_put_contents('README','
Please add the following settings to httpd.conf with the proper values filled out.

<VirtualHost *:80>
    ServerName   [your domain name]
    ServerAdmin  [your email]
    DocumentRoot [path to your project]/web
    php_value include_path .:[path to your project]
    <Directory "[path to your project]/web">
     AllowOverride All
     Allow from All
    </Directory>
</VirtualHost>
    ');
                mkdir('tmp');
                mkdir('config');
                mkdir('templates');
                @file_put_contents('templates/README','
This directory contains the main project template (layout.php). This template contains the HTML wrapper for all pages.

The line with <?php echo $skinny_content ?> outputs the processed model-action templates. 
    ');
                mkdir('plugins');
                @file_put_contents('plugins/README','
       Put your plugins here.
       The file name of a plugin must be formatted like this:
            skinnyPlugin*.php

       For example:
           skinnyPluginCaptcha.php
    ');
                mkdir('lib');
                mkdir('lib/skinnymvc');
                mkdir('lib/skinnymvc/class');
                mkdir('lib/skinnymvc/dbcontroller');
                mkdir('lib/skinnymvc/dbcontroller/base');
                @file_put_contents('lib/skinnymvc/dbcontroller/base/SkinnyBaseDbTransaction.php','<?php
/**
 * filename:    SkinnyBaseDbTransaction.php
 * description: Database Transaction class
 */

class SkinnyBaseDbTransaction {

    protected static $dbTransactions = array();
    protected $currentDbKey = null;
    protected $magicNumber = null;
    protected $transactionActive = false;


    protected function __construct() {
        $this->magicNumber = md5(uniqid(mt_rand(), true)); //TODO
    }


    public static function create($p=array()) {
      $t = new SkinnyDbTransaction();
      if (!empty($p)) {
         $t->addManyORMs($p);
      }
      return $t;
    }


    public static function transactionActive($dbKey) {
       if (isset(self::$dbTransactions[$dbKey])) {
          return self::$dbTransactions[$dbKey][\'is_active\'];
       }
       return false;
    }


    public static function transactionMagicNumber($dbKey) {
       if (isset(self::$dbTransactions[$dbKey])) {
          return self::$dbTransactions[$dbKey][\'magic_number\'];
       }
       return false;
    }

    public static function transactionExists($dbKey) {
       return isset(self::$dbTransactions[$dbKey]);
    }


    public static function fetchDbTransaction($dbKey, $magicNumber) {
       if (isset(self::$dbTransactions[$dbKey]) && self::$dbTransactions[$dbKey][\'magic_number\'] == $magicNumber) {
          return self::$dbTransactions[$dbKey][\'db_transaction\'];
       }
       return null;
    }


    public function getCurrentDbKey() {
        return $this->currentDbKey;
    }


    //begin transaction; at least one object must be added before calling this method.
    public function begin() {
       if(empty($this->currentDbKey)) {
          throw new SkinnyDbException(\'No DB connection.\');
       }

       $this->transactionActive = true;
       self::$dbTransactions[$this->currentDbKey][\'is_active\'] = $this->transactionActive; 

       //begin the actual transaction
       $con = SkinnyDbController::getWriteConnection($this->currentDbKey);
       $con->beginTransaction();
    }


    public function addORM($ormObj) {
       if (!is_object($ormObj)) {
          throw new SkinnyDbException(\'Non-object sent to addORM().\');
       }

       // Set the DB Key
       $dbKey = $ormObj->databaseKey();
       if (is_null($this->currentDbKey)) {
          if (isset(self::$dbTransactions[$dbKey])) {
             throw new SkinnyDbException(\'An open transaction already exists for this DB key.\');
          }
          $this->currentDbKey = $dbKey;
          self::$dbTransactions[$dbKey][\'is_active\'] = $this->transactionActive;
          self::$dbTransactions[$dbKey][\'magic_number\'] = $this->magicNumber;
          self::$dbTransactions[$dbKey][\'db_transaction\'] = $this;
       } else {
          if($this->currentDbKey != $dbKey) {
             throw new SkinnyDbException(\'DbKey mismatch.\');
          }
       }

       if ($ormObj->isInAnyTransaction()) {
          throw new SkinnyDbException(\'Object is already in a transaction\');
       }

       //Flag the ORM object
       $ormObj->updateMagicTransactionNumber($this->magicNumber);

       //TODO: add updateMagicTransactionNumber and isInTransaction to ORM objects
       //TODO: check for existing transaction in save and delete, 
       //      so that objects that are not in an existing transaction are locked out of saving
       //      If no transaction exists for the particular database, objects are saved with autocommit
    }


    public function addManyORMs($p) {
       if (is_array($p)) {
          foreach($p as $pObj) {
             $this->addORM($pObj);
          }
       } else if(is_object($p)) {
          $this->addORM($p);
       }
    }


    public function removeORM($ormObj) {
       if (!is_object($ormObj)) {
          throw new SkinnyDbException(\'Non-object sent to addORM().\');
       }
       $ormObj->updateMagicTransactionNumber(null);
    }

    public function commit() {
       if(empty($this->currentDbKey)) {
          throw new SkinnyDbException(\'No DB connection.\');
       }

       if (!$this->transactionActive) {
          throw new SkinnyDbException(\'Transaction not active\');
       }

       //Do the actual commit
       $con = SkinnyDbController::getWriteConnection($this->currentDbKey);
       $con->commit();

       $this->clearKey();
    }


    public function rollBack() {
       if(empty($this->currentDbKey)) {
          throw new SkinnyDbException(\'No DB connection.\');
       }

       if (!$this->transactionActive) {
          throw new SkinnyDbException(\'Transaction not active\');
       }

       //Do the actual rollBack
       $con = SkinnyDbController::getWriteConnection($this->currentDbKey);
       $con->rollBack();

       $this->clearKey();
    }


    private function clearKey() {
       $this->transactionActive = false;
       unset(self::$dbTransactions[$this->currentDbKey][\'db_transaction\']);
       unset(self::$dbTransactions[$this->currentDbKey]);
       $this->currentDbKey = null;
    }
}
');
                @file_put_contents('lib/skinnymvc/dbcontroller/base/SkinnyBaseDbController.php','<?php
/**
 * filename:    SkinnyBaseDbController.php
 * description: Database controller
 */

class SkinnyBaseDbController extends PDO {

   protected static $connections = array();

   protected function SkinnyBaseDbController($dbKey, $mode, $dsn, $username=null, $password=null, $driver_options=null ) {
     parent::__construct($dsn, $username, $password, $driver_options);
     self::$connections[$dbKey][$mode] = $this;
   }

  /**
   * Gets the existing DB Connection or creates a new one
   * @param string $dbKey
   * @return SkinnyDbController
   */
   public static function getConnection($dbKey = \'\', $mode=\'r+\') { // empty $dbKey must be \'\' and NOT null!!!

     if (!isset(self::$connections[$dbKey][$mode]) || empty(self::$connections[$dbKey][$mode])) {

       if (  array_key_exists("dbs", SkinnySettings::$CONFIG) && is_array(SkinnySettings::$CONFIG["dbs"]) && array_key_exists($dbKey, SkinnySettings::$CONFIG["dbs"])  ) {
         $db_config = SkinnySettings::$CONFIG["dbs"][$dbKey];
         $dbName = null;
       } else {
         $db_config = SkinnySettings::$CONFIG;
         $dbName = $dbKey;
       }
       if (empty($dbName)) {
         $dbName = $db_config["dbname"];
       }

       if ($db_config["dbhost"] == "127.0.0.1") {
         $dsn = $db_config["dbdriver"].":dbname=".$dbName;
       } else {
         $dsn = $db_config["dbdriver"].":dbname=".$dbName.";host=".$db_config["dbhost"];
       }

       $dsn = $db_config["dbdriver"].":dbname=".$dbName.";host=".$db_config["dbhost"];
       try {
         return new SkinnyDbController($dbKey, $mode, $dsn, $db_config["dbuser"], $db_config["dbpassword"]);
       } catch (PDOException $e) {
         throw new SkinnyDbException($e->getMessage(), $e->getCode());
       }
     } else {
       return self::$connections[$dbKey][$mode];
     }
   }

    public static function getReadConnection($dbKey = \'\')
    {
        // TODO after PHP 5.3 becomes more common: return static::getConnection($dbKey, "r");
        return self::getConnection($dbKey, "r");
    }

    public static function getWriteConnection($dbKey = \'\')
    {
        // TODO after PHP 5.3 becomes more common: return static::getConnection($dbKey, "w");
        return self::getConnection($dbKey, "w");
    }
}
    
');
                mkdir('lib/skinnymvc/controller');
                mkdir('lib/skinnymvc/controller/base');
                @file_put_contents('lib/skinnymvc/controller/base/SkinnyBaseController.php','<?php
/******************************
 * filename:    SkinnyBaseController.php
 * description: The main application controller. Every request goes through here.
 */

class SkinnyBaseController {

    protected static $layout = \'layout\'; /* name of the layout file to use - no extension */
    protected $app = null;
    protected $module = null;
    protected $action = null;
    protected $param = null;
    protected $skinnyUser = null;

    protected $allowModulesAsFiles = false;
    protected $allowActionsAsFiles = false;
    protected $fixMisspellings     = true;

    public function __construct()
    {
        // Nothing here.
    }

  /**
   * The main controller script, running with every request.
   */
    public function main()
    {
        //
        // Get the Module and Action from the CGI parameters.
        //
            if (isset($_GET[\'__action\']) && !empty($_GET[\'__action\'])) {
                $action = $_GET[\'__action\'];
            } else {
                $action = \'index\';
            }

            if (isset($_GET[\'__module\']) && !empty($_GET[\'__module\'])) {
                $module = $_GET[\'__module\'];
            } else {
                $module = \'default\';
                $action = \'index\';
            }


        //
        // Set up $param.
        //
            $paramGET = $_GET;
            unset($paramGET[\'__module\']);
            unset($paramGET[\'__action\']);

            $param = array(\'GET\'=>$paramGET, \'POST\'=>$_POST, \'FILES\'=>$_FILES);


        //
        // Set up variable that are used by the run() method.
        //
            $this->module = $module;
            $this->action = $action;
            $this->param  = $param;


        //
        // Handle the missing slashes if there are any.
        //

           // Slash after the module missing?
            $hasMissingSlash = \'\' == @$_GET[\'__action\']
                            && \'/\' == substr($_SERVER[\'REQUEST_URI\'],0,1) 
                            && 1 < strlen($_SERVER[\'REQUEST_URI\']) 
                            && FALSE == strpos($_SERVER[\'REQUEST_URI\'],\'/\',1)
                             ;
            if (  $hasMissingSlash  ) {

                if (  $this->allowModulesAsFiles   ) {

                    // Nothing here.

                } else if (  $this->fixMisspellings  ) {

                    if (  \'\' != $this->module && \'\' == @$_GET[\'__action\']  ) {
                        $href = \'/\' . $this->module . \'/\';
                        header(\'Location: \'.$href);
                        exit();
                    }

                } else {
                    //Error: Action does not exist
                    header("HTTP/1.1 404 Not Found");
                    echo file_get_contents("../templates/404.php");
                    exit;
                }
            }

           // Slash after the action missing?
           $hasMissingSlash = \'\' != @$_GET[\'__action\']
                            && \'/\' == substr($_SERVER[\'REQUEST_URI\'],0,1) 
                            && 1 < strlen($_SERVER[\'REQUEST_URI\']) 
                            && FALSE !== strpos($_SERVER[\'REQUEST_URI\'],\'/\',1)
                            && FALSE ==  strpos($_SERVER[\'REQUEST_URI\'],\'/\', strpos($_SERVER[\'REQUEST_URI\'],\'/\',1))
                             ;
            if (  $hasMissingSlash  ) {

                if (  $this->allowActionsAsFiles   ) {

                    // Nothing here.

                } else if (  $this->fixMisspellings  ) {

                    if (  \'\' != $this->module && \'\' != @$_GET[\'__action\']  ) {
                        $href = \'/\' . $this->module . \'/\'. $this->action .\'/\';
                        header(\'Location: \'.$href);
                        exit();
                    }

                } else {
                    //Error: Action does not exist
                    header("HTTP/1.1 404 Not Found");
                    echo file_get_contents("../templates/404.php");
                    exit;
                }
            

            }


        //Get the core classes
        $this->require_once_many("../lib/skinnymvc/core/base/*.php");
        $this->require_once_many("../lib/skinnymvc/core/*.php");

        // Get the db controller classes
        $this->require_once_many("../lib/skinnymvc/dbcontroller/base/*.php");
        $this->require_once_many("../lib/skinnymvc/dbcontroller/*.php");

        // Get the controller classes
        $this->require_once_many("../lib/skinnymvc/controller/base/*.php");
        $this->require_once_many("../lib/skinnymvc/controller/*.php");

        //Get all Model classes
        if (SkinnySettings::$CONFIG[\'preload model\']) {
            $this->require_once_many("../lib/skinnymvc/model/*.php");
            $this->require_once_many("../lib/skinnymvc/model/base/*.php");
        }

        //Initialize session
        if (SkinnySettings::$CONFIG[\'session persistency\']) {
            $this->skinnyUser = SkinnyUser::getUser();
        }

        //Get all plugins
        $this->require_once_many("../plugins/skinnyPlugin*.php");


        //
        // Call the run() method.
        //
            $this->run();

    }


    public function run()
    {
        $this->executeModuleAction($this->module, $this->action, $this->param);
    }


    protected function executeModuleAction($module, $action, $param)
    {

        if (!file_exists("../modules/$module/actions/actions.php")) {
            //Error: Action does not exist
            header("HTTP/1.1 404 Not Found");
            echo file_get_contents("../templates/404.php");
            exit;
        }
        require_once("../modules/$module/actions/actions.php");

        $moduleClass = self::camelize($module) . \'Actions\';

        $actionMethod = \'execute\'.self::camelize($action);

        $moduleObj = new $moduleClass();

        $skinnyUser = $this->skinnyUser;

        if (!empty($skinnyUser)) {
            $this->checkAuthentication($moduleObj, $skinnyUser, $param);
        }

        if (empty($moduleObj)) {
            //Error: Module does not exist
            header("HTTP/1.1 404 Not Found");
            echo file_get_contents("../templates/404.php");
            exit;
        }

        // The action should return an array of all values that will be needed in the template
        if ( $moduleObj->allowUndefinedActions()) {

            $data = array();
            if (  is_callable(array($moduleObj, $actionMethod))  ) {
                $data = call_user_func_array(array($moduleObj, $actionMethod), array($param));
            } else {
                if (!file_exists("../modules/$module/templates/$action.php")) {
                    //Error: Action does not exist
                    header("HTTP/1.1 404 Not Found");
                    echo file_get_contents("../templates/404.php");
                    exit;
                }
            }
            if (SkinnySettings::$CONFIG[\'debug\']) {
                global $__DEBUG;
                array_push($__DEBUG[\'data\'], $data);
            }
        } else if (is_callable(array($moduleObj, $actionMethod))) {
            $data = call_user_func_array(array($moduleObj, $actionMethod), array($param));
            if (SkinnySettings::$CONFIG[\'debug\']) {
                global $__DEBUG;
                array_push($__DEBUG[\'data\'], $data);
            }
        } else {
            //Error: Action $action does not exist
            header("HTTP/1.1 404 Not Found");
            echo file_get_contents("../templates/404.php");
            exit;
        }

        //Process the templates
        if (!file_exists("../modules/$module/templates/$action.php")) {
            //Error
            throw new SkinnyException("Template for module $module, action $action does not exist.");
            exit;
        }

        $actionTemplateSource = file_get_contents("../modules/$module/templates/$action.php");

        ob_start();
        $this->processTemplate($data, $skinnyUser, $actionTemplateSource);

        $skinny_content = ob_get_clean();

        //Run the layout;
        $this->processLayout($skinny_content, $data, $skinnyUser, $module, $action, self::$layout);


        flush();
        ob_flush();

        //clean up old sessions
        $rand = rand(0, 99);
        if ($rand == 1) {
            SkinnyUser::cleanup();
        }
    }

    protected function checkAuthentication($moduleObj, $skinnyUser, $param) {
        $moduleObj->setSkinnyUser($skinnyUser);
        if ($moduleObj->authenticatedOnly()) {
            if (!$skinnyUser->isAuthenticated()) {
                //Not authenticated!
                if (isset(SkinnySettings::$CONFIG[\'unauthenticated default module\'])) {
                    if (isset(SkinnySettings::$CONFIG[\'unauthenticated default action\'])) {
                        $moduleObj->redirect(SkinnySettings::$CONFIG[\'unauthenticated default module\'], SkinnySettings::$CONFIG[\'unauthenticated default action\'], $param);
                    } else {
                        $moduleObj->redirect(SkinnySettings::$CONFIG[\'unauthenticated default module\'], "index", $param);
                    }
                } else {
                    $moduleObj->redirect("default", "index", $param);
                }
            }
        }
    }


  /**
   * Turns "foo_bar" into "FooBar"
   * @param string $str
   * @return string Camelized $str
   */
   public static function camelize($str)
   {
     $str = str_replace("_", " ", $str);
     $str = ucwords($str);
     $str = str_replace(" ", "", $str);
     return $str;
   }

   private function processTemplate($skinnyData, $skinnyUser, $skinnyTemplateSourceData) {
      eval(\'?>\'.$skinnyTemplateSourceData."\\n");
   }


   private function processLayout(&$skinny_content, $layoutData, $skinnyUser, $module, $action, $layout) {
      include_once \'../templates/\'. $layout .\'.php\';
   }


   private function require_once_many($pattern)
   {
      foreach(glob($pattern) as $class_filename) {
         require_once($class_filename);
      }
   }

    protected function moduleExists($moduleName)
    {
        return file_exists(\'../modules/\'. $moduleName .\'/actions/actions.php\');
    }

    protected function actionExists($moduleName, $actionName)
    {
        return file_exists(\'../modules/\'. $moduleName .\'/templates/\'. $actionName .\'.php\');
    }

    
   /**
    * static setter for the layout used to render action data
    *
    * @access public
    * @static
    * @param string $layout
    * @return void
    */
   public static function setLayout($layout)
   {
     self::$layout = $layout;
   }


} // class SkinnyBaseController

');
                mkdir('lib/skinnymvc/core');
                @file_put_contents('lib/skinnymvc/core/SkinnyUser.php','<?php
/******************************
 * filename:    SkinnyUser.php
 * description: Holds session stuff
 *              This version requires working session persistency!
 */

class SkinnyUser {

   private $authenticated = false;

   private $timeout = 1800;

   private $last_accessed = 0;

   private $attributes = array();

   private function SkinnyUser() {
   }

  /**
   * Gets the existing User or creates a new one
   */
   public static function getUser() {
      if (!SkinnySettings::$CONFIG[\'session persistency\']) {
        throw new SkinnyException("Session persistency not enabled");
      }
      $sess = null;
      session_start();

      if (file_exists("../tmp/".session_id().".session")) {
         $sess = unserialize(@file_get_contents("../tmp/".session_id().".session"));
         $session_inactive = time() - $sess->last_accessed;
         if ($session_inactive > $sess->timeout) {
             $sess->last_accessed = time();
             $sess->setAuthenticated(false);
             $sess->save();
         } else {
             $sess->last_accessed = time();
             $sess->save();
         }
      } else {
         $sess = new SkinnyUser();
         $sess->timeout = SkinnySettings::$CONFIG[\'session timeout\'];
         $sess->last_accessed = time();
         $sess->save();
      }
      return $sess;
   }

  /**
   * @return boolean Is the user authenticated?
   */
   public function isAuthenticated() {
     return $this->authenticated;
   }

  /**
   * Sets the user to authenticated or unauthenticated
   * @param boolean $authenticated 
   */
   public function setAuthenticated($authenticated) {
     if (!is_bool($authenticated)) {
        throw new SkinnyException("Authentication value must be boolean");
     }

     $this->authenticated = $authenticated;
     $this->save();     
   }

  /**
   * Returns the value of a saved attribute
   * @param string $name Name of the attribute
   * @return mixed Value of the attribute or null if the attribute was not found
   */
   public function getAttribute($name) {
     if(isset($this->attributes[$name])) {
        return $this->attributes[$name];
     } else {
        return null;
     }
   }

  /**
   * Saves an attribut in the session
   * @param string $name Name of the attribute
   * @param mixed $value Value of the attribute
   */
   public function setAttribute($name, $value) {
      $this->attributes[$name] = $value;
      $this->save();
   }

  /**
   * Deletes an attibute that was stored in the session
   * @param string $name Name of the attribute
   */
   public function deleteAttribute($name) {
      if(isset($this->attributes[$name])) {
        unset($this->attributes[$name]);
      }
      $this->save();
   }

  /**
   * Gets the current session timeout value
   * @return int Timeout in seconds
   */ 
   public function getTimeout() {
      return $this->timeout;
   }

  /**
   * Make user data persistent
   */
   public function save() {
      $data = serialize($this);
      return file_put_contents("../tmp/".session_id().".session", $data);
   }

  /**
   * Destroys the session - removes user file
   */
   public function destroy() {
      return @unlink("../tmp/".session_id().".session");
   }

   //clean up the tmp dir
   public static function cleanup() {
      if ($handle = opendir("../tmp")) {
         while (false !== ($file = readdir($handle))) {
           $diff = time() - filemtime("../tmp/".$file);
           if ($diff>SkinnySettings::$CONFIG["session timeout"]){
              @unlink("../tmp/$file");
           }
         }
      }
   }
}
    ');
                mkdir('lib/skinnymvc/core/base');
                @file_put_contents('lib/skinnymvc/core/base/SkinnyBaseActions.php','<?php
/******************************
 * filename:    SkinnyBaseActions.php
 * description: main Actions class
 */

class SkinnyBaseActions {

   protected $skinnyUser = null;

   protected $authenticatedOnly = false;

   protected $allowUndefinedActions = false;

  /**
   * Attaches the session-user to this action
   * @param SkinnyUser $skinnyUser
   */
   public function setSkinnyUser($skinnyUser) {
      $this->skinnyUser = $skinnyUser;
   }

  /**
   * Gets the current SkinnyUser - session
   * @return SkinnyUser
   */
   public function getSkinnyUser() {
      return $this->skinnyUser;
   }

  /**
   * Is this module restricted?
   * @return boolean
   */
   public function authenticatedOnly() {
      return $this->authenticatedOnly;
   }

  /**
   * Does module allow undefined actions?
   * @return boolean
   */
   public function allowUndefinedActions() {
      return $this->allowUndefinedActions;
   }

  /**
   * Redirects the browser to a new page (modue and action)
   * @param string $module
   * @param string $action
   * @param array $request
   */
   public function redirect($module=\'default\', $action=\'index\', $request=\'\') {
      $param = self::getRelativeRoot()."$module/$action/";
      if (is_array($request)) {
        $loop = 0;
        if(isset($request[\'GET\'])) {
           foreach ($request[\'GET\'] As $key=>$value) {
              if ($loop == 0) {
                $param .= "?";
              } else {
                $param .= "&";
              }
              $param .= "$key=$value";
              $loop++;
           }
        }
        if(isset($request[\'POST\'])) {
           foreach ($request[\'POST\'] As $key=>$value) {
               if ($loop == 0) {
                $param .= "?";
              } else {
                $param .= "&";
              }
              $param .= "$key=$value";
              $loop++;
           }
        }
      } else { //not array
        $param .= $request;
      }

      if (SkinnySettings::$CONFIG[\'debug\']) {
         header( "Location: /dev.php".$param );
      } else {
         header( "Location: ".$param );
      }
      exit;
   }

  /**
   * Makes a call to the specified module+action and returns back to the caller
   * @param string $module
   * @param string $action
   * @param array $request
   * @return array
   */
   public function call($module=\'default\', $action=\'index\', $request=array(\'GET\'=>array(), \'POST\'=>array())) {
      $moduleClass = SkinnyController::camelize($module) . \'Actions\';

      $actionMethod = \'execute\'.SkinnyController::camelize($action);

      $moduleObj = new $moduleClass();

      if ($moduleObj->authenticatedOnly()) {
        if (!$this->skinnyUser->isAuthenticated()) {
            //Not authenticated!
            return null;
        }
      }

      if (is_callable(array($moduleObj, $actionMethod))) {
        $data = call_user_func_array(array($moduleObj, $actionMethod), array($request));
        if (SkinnySettings::$CONFIG[\'debug\']) {
           global $__DEBUG;
           array_push($__DEBUG[\'data\'], $data);
        }
      }
      return $data;
   }


    public function sendHttpResponse204($param=array())
    {
        //
        // Deal with parameters.
        //
            if (  !isset($param) || !is_array($param)  ) {
                $param = array();
            }

        //
        // Send the HTTP 204 Not Found response.
        //
            header(\'HTTP/1.1 204 No Content\');
            if (  isset($param[\'headers\']) && is_array($param[\'headers\']) && !empty($param[\'headers\'])  ) {
                foreach (  $param[\'headers\'] AS $header  ) {
                    header($header);
                } // foreach
            }

        //
        // Exit.
        //
    /////// EXIT
            exit(0);
    }

    public function sendHttpResponse404($param=array())
    {
        $default_s = \'<html><head><title>Not Found</title></head><body><h1>Not Found</h1></body></html>\';

        //
        // Deal with parameters.
        //
            if (  is_string($param)  ) {
                $param = array(  \'layoutData\' => $param  );
            }
            if (  !isset($param) || !is_array($param)  ) {
                $param = array();
            }
            if (  !isset($param[\'layoutData\'])  ) {
                $param[\'layoutData\'] = array();
            }

        //
        // Send the HTTP 404 Not Found response.
        //
            header(\'HTTP/1.1 404 Not Found\');
            if (  isset($param[\'headers\']) && is_array($param[\'headers\']) && !empty($param[\'headers\'])  ) {
                foreach (  $param[\'headers\'] AS $header  ) {
                    header($header);
                } // foreach
            }


            $s = file_get_contents("../templates/404.php");
            if (  !isset($s) || !is_string($s) ) {
                $s = $default_s;
            }

            $code = \' ?\'.\'>\'. $s .\'<\'.\'?\'.\'php \';

            $proc = create_function(\'$layoutData\', $code);
            if (  !isset($proc) || FALSE === $proc  ) {
                print($default_s);
    /////////// EXIT
                exit(1);
            }

            $proc($param[\'layoutData\']);

        //
        // Exit.
        //
    /////// EXIT
            exit(1);
    }

    public function sendHttpResponse405($param=array())
    {
        $default_s = \'<html><head><title>Method Not Allowed</title></head><body><h1>Method Not Allowed</h1></body></html>\';

        //
        // Deal with parameters.
        //
            if (  is_string($param)  ) {
                $param = array(  \'layoutData\' => $param  );
            }
            if (  !isset($param) || !is_array($param)  ) {
                $param = array();
            }
            if (  !isset($param[\'layoutData\'])  ) {
                $param[\'layoutData\'] = array();
            }

        //
        // Send the HTTP 405 Not Found response.
        //
            header(\'HTTP/1.1 405 Method Not Allowed\');
            if (  isset($param[\'headers\']) && is_array($param[\'headers\']) && !empty($param[\'headers\'])  ) {
                foreach (  $param[\'headers\'] AS $header  ) {
                    header($header);
                } // foreach
            }


            $s = file_get_contents("../templates/405.php");
            if (  !isset($s) || !is_string($s) ) {
                $s = $default_s;
            }

            $code = \' ?\'.\'>\'. $s .\'<\'.\'?\'.\'php \';

            $proc = create_function(\'$layoutData\', $code);
            if (  !isset($proc) || FALSE === $proc  ) {
                print($default_s);
    /////////// EXIT
                exit(1);
            }

            $proc($param[\'layoutData\']);

        //
        // Exit.
        //
    /////// EXIT
            exit(1);
    }

    public function sendHttpResponse500($param=array())
    {
        $default_s = \'<html><head><title>Internal Server Error</title></head><body><h1>Internal Server Error</h1></body></html>\';

        //
        // Deal with parameters.
        //
            if (  is_string($param)  ) {
                $param = array(  \'layoutData\' => $param  );
            }
            if (  !isset($param) || !is_array($param)  ) {
                $param = array();
            }
            if (  !isset($param[\'layoutData\'])  ) {
                $param[\'layoutData\'] = array();
            }

        //
        // Send the HTTP 500 Not Found response.
        //
            header(\'HTTP/1.1 500 Internal Server Error\');
            if (  isset($param[\'headers\']) && is_array($param[\'headers\']) && !empty($param[\'headers\'])  ) {
                foreach (  $param[\'headers\'] AS $header  ) {
                    header($header);
                } // foreach
            }


            $s = file_get_contents("../templates/500.php");
            if (  !isset($s) || !is_string($s) ) {
                $s = $default_s;
            }

            $code = \' ?\'.\'>\'. $s .\'<\'.\'?\'.\'php \';

            $proc = create_function(\'$layoutData\', $code);
            if (  !isset($proc) || FALSE === $proc  ) {
                print($default_s);
    /////////// EXIT
                exit(1);
            }

            $proc($param[\'layoutData\']);

        //
        // Exit.
        //
    /////// EXIT
            exit(1);
    }



  /**
   * Gets the relative root directory of the project - useful, if installed in a subdir.
   * @return string
   */
   public static function getRelativeRoot() {
      $rel_path = str_replace($_SERVER[\'DOCUMENT_ROOT\'], \'\', $_SERVER[\'SCRIPT_FILENAME\']);
      if ($rel_path == "index.php"){
        $rel_path="/";
      } else if ($rel_path == "dev.php") {
        $rel_path="/dev.php/";
      } else {
        $rel_path = substr($rel_path, 0, strrpos($rel_path, "/")+1);
      }
      return $rel_path;
   }

   
   /**
    * proxy method providing ability to set the layout used for a given action
    *
    * @param String $layout
    * @return void
    */
   public function setLayout($layout)
   {
     SkinnyBaseController::setLayout($layout);
   }

}

');
                @file_put_contents('lib/skinnymvc/core/BaseModel.php','<?php
/**
 * filename:    BaseModel.php
 * description: Base class for all Base model classes
 */

abstract class SkinnyBaseModel {

    // P R O C E D U R E S //////////////////////////////////////////////////////////////////////////////////////////////////
        /**
         * Gets SQL query results
         * @param string $tableName Name of the affected table
         * @param mixed $criteria
         * @return array
         */
        public static function selectArray($tableName, $criteria = array(), $dbKey)
        {

            if (  isset($criteria["sql"]) && is_string($criteria["sql"])  ) {

                $sql = $criteria["sql"];

            } else {

                //columns can be SQL or an array.
                if (empty($criteria[\'columns\'])) {
                    $criteria[\'columns\'] = \'*\';
                } else {
                    if (is_array($criteria[\'columns\'])) {
                        $criteria[\'columns\'] = implode (\',\', $criteria[\'columns\']);
                    }
                }

                //joins are only SQL for now
                if (empty($criteria[\'joins\'])) {
                    $criteria[\'joins\'] = \'\';
                }

                // group can be SQL or array
                if (empty($criteria[\'group\'])) {
                    $criteria[\'group\'] = \'\';
                } else {
                    if(is_array($criteria[\'group\'])) {
                        $criteria[\'group\'] = \'GROUP BY \'.implode(\',\',$criteria[\'group\']);
                    }
                }

                //limit can be SQL or a STRING formatted like this: "LIMIT 10" or "LIMIT 5,10" or "10"
                if (empty($criteria[\'limit\'])) {
                    $criteria[\'limit\'] = \'\';
                }else{
                    if (is_numeric($criteria[\'limit\'])) {
                        $criteria[\'limit\'] = "LIMIT ".$criteria[\'limit\'];
                    }
                }

                //offset can be SQL or a STRING formatted like this: "OFFSET 10" or "10"
                if (empty($criteria[\'offset\'])) {
                    $criteria[\'offset\'] = \'\';
                }else{
                    if (is_numeric($criteria[\'offset\'])) {
                        $criteria[\'offset\'] = "OFFSET ".$criteria[\'offset\'];
                    }
                }

                //order can be SQL or array
                //   array(
                //         array(\'column\'=>\'column1\', \'direction\'=>\'desc\'),
                //         array(\'column\'=>\'column2\', \'direction\'=>\'desc\')
                //   );
                if (empty($criteria[\'order\'])) {
                    $criteria[\'order\'] = \'\';
                } else {
                    if(is_array($criteria[\'order\'])) {
                        $tmpOrder = "ORDER BY ";
                        foreach($criteria[\'order\'] As $order) {
                            if (is_array($order)) {
                                $tmpOrder .= $order[\'column\'].\' \'.$order[\'direction\'];
                            } else {
                                $tmpOrder .= $order;
                            }
                            $tmpOrder .= \', \';
                        }
                        $tmpOrder = substr($tmpOrder, 0, strlen($tmpOrder)-2);
                        $criteria[\'order\'] = $tmpOrder;
                    }
                }

                //conditions could be SQL code or an array
                //if an array, it should look like this:
                //   array( 
                //          array(\'left\'=>\'column1\', \'condition\'=>\'<\',\'right\'=>\'10\'),
                //          array(\'left\'=>\'column1\', \'condition\'=>\'NOT NULL\'),
                //   );
                if (empty($criteria[\'conditions\'])) {
                    $criteria[\'conditions\'] = \'\';
                } else {
                    if (is_array($criteria[\'conditions\'])) {
                        $tmpConditions = \'WHERE\';
                        foreach($criteria[\'conditions\'] As $condition) {
                            if(is_array($condition)) {
                                if (empty($condition[\'left\'])) {
                                    throw new SkinnyException(\'Missing left side of the condition.\');
                                }
                                if (empty($condition[\'condition\'])) {
                                    throw new SkinnyException(\'Invalid condition.\');
                                }
                                if (!isset($condition[\'right\'])) {
                                    if (!in_array(strtoupper($condition[\'condition\']), array(\'NOT NULL\', \'IS NULL\'))) {
                                        throw new SkinnyException(\'Missing right side of the condition.\');
                                    } else {
                                        $tmpConditions .= $condition[\'left\'].\' \'.$condition[\'condition\'];
                                    }
                                } else {
                                    $tmpConditions .= $condition[\'left\'].\' \'.$condition[\'condition\'].\' \'.$condition[\'right\'];
                                }
                                $tmpConditions .= "\\n AND ";
                            } else {
                                $tmpConditions .= $condition."\\n AND ";
                            }
                        }
                        $tmpConditions .= " 1=1\\n";
                        $criteria[\'conditions\'] = $tmpConditions;
                    }
                }

                $sql = "SELECT ".$criteria[\'columns\']."\\n"
                     ."FROM ".$tableName."\\n";
                if (!empty($criteria[\'joins\'])) {
                    $sql .= $criteria[\'joins\']."\\n";
                }
                if (!empty($criteria[\'conditions\'])) {
                    $sql .= $criteria[\'conditions\']."\\n";
                }
                if (!empty($criteria[\'group\'])) {
                    $sql .= $criteria[\'group\']."\\n";
                }
                if (!empty($criteria[\'order\'])) {
                    $sql .= $criteria[\'order\']."\\n";
                }
                if (!empty($criteria[\'limit\'])) {
                    $sql .= $criteria[\'limit\']."\\n";
                }
                if (!empty($criteria[\'offset\'])) {
                    $sql .= $criteria[\'offset\']."\\n";
                }

            }


            if (SkinnySettings::$CONFIG[\'debug\']) {
                global $__DEBUG;
                array_push($__DEBUG[\'sql\'], $sql);
            }

            $con = SkinnyDbController::getReadConnection($dbKey);
            $result = $con->query($sql);
            if (!empty($result)) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        }
    ////////////////////////////////////////////////////////////////////////////////////////////////// P R O C E D U R E S //



    // M E T H O D S ////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function isValid()
        {
            return TRUE;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
    // p r o t e c t e d   m e t h o d s                                                                                   //
    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        protected function assertMaySave()
        {
            // Nothing here.
        }

    //---------------------------------------------------------------------------------------------------------------------//

        protected function preSave()
        {
            // Nothing here.
        }

    //---------------------------------------------------------------------------------------------------------------------//

        protected function postSave()
        {
            // Nothing here.
        }
    //////////////////////////////////////////////////////////////////////////////////////////////////////// M E T H O D S //
}

');
                @file_put_contents('lib/skinnymvc/core/SkinnyDbException.php','<?php
/******************************
 * filename:    SkinnyDbException.php
 * description: Skinny database Exception class
 */

require_once("SkinnyException.php");

class SkinnyDbException extends SkinnyException {
}
    
');
                @file_put_contents('lib/skinnymvc/core/SkinnyException.php','<?php
/******************************
 * filename:    SkinnyException.php
 * description: main Exception class
 */

class SkinnyException extends Exception {
}
    ');
                mkdir('lib/skinnymvc/model');
                mkdir('lib/skinnymvc/model/sql');
                mkdir('lib/skinnymvc/model/base');
        }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        function _install()
        {
                if (  !file_exists('web/css/main.css')  ) {
                    @file_put_contents('web/css/main.css','');
                }
                if (  !file_exists('modules/default')  ) {
                    mkdir('modules/default');
                }
                if (  !file_exists('modules/default/actions')  ) {
                    mkdir('modules/default/actions');
                }
                if (  !file_exists('modules/default/actions/actions.php')  ) {
                    @file_put_contents('modules/default/actions/actions.php','<?php
/******************************
 * filename:    modules/default/actions/actions.php
 * description:
 */

class DefaultActions extends SkinnyActions {

    public function __construct()
    {
    }

  /**
   * The actions index method
   * @param array $request
   * @return array
   */
    public function executeIndex($request)
    {
        // return an array of name value pairs to send data to the template
        $data = array();
        return $data;
    }

}
');
                }
                if (  !file_exists('modules/default/templates')  ) {
                    mkdir('modules/default/templates');
                }
                if (  !file_exists('modules/default/templates/README')  ) {
                    @file_put_contents('modules/default/templates/README','
       This directory contains your module-action templates.

       A template must be named after the associated action. 
       For example, if the associated action is "list", then the file name of the template must be "list.php"
    ');
                }
                if (  !file_exists('modules/default/templates/index.php')  ) {
                    @file_put_contents('modules/default/templates/index.php','   <h1>Under Construction</h1>
<?php
 echo "   You have successfuly installed SkinnyMVC."; 
');
                }
                if (  !file_exists('config/settings.php')  ) {
                    @file_put_contents('config/settings.php','<?php
/******************************
 * filename:    settings.php
 * description: Project settings. 
 *              To edit, change the values on right side of the name-value pairs.
 */

class SkinnySettings { public static $CONFIG = array(


"project name"    => "SkinnyMVC Project",
"debug"           => false,
"preload model"   => true,  //true = all model classes will be loaded with each request;
                            //false = model classes will be loaded only if explicitly required (use require_once)

"session persistency" => true, //tmp in your project dir must be writeable by the server!
"session timeout" => 1800, //in seconds!

"unauthenticated default module" => "default", //set this to where you want unauthenticated users redirected.
"unauthenticated default action" => "index",

"dbdriver"        => "mysql",
"dbname"          => "db",
"dbhost"          => "127.0.0.1",
"dbuser"          => "user",
"dbpassword"      => "password",

// To use multiple databases, keep the code above with default values
// and add a new setting like this:
//   "dbs" => array(
//                   "database1"=> array(
//                                       "dbdriver"   => "mysql",
//                                       "dbname"     => "db",
//                                       "dbhost"     => "127.0.0.1",
//                                       "dbuser"     => "user",
//                                       "dbpassword" => "password",
//                                      ),
//                   "database2"=> array(
//                                       "dbdriver"   => "mysql",
//                                       "dbname"     => "db",
//                                       "dbhost"     => "127.0.0.1",
//                                       "dbuser"     => "user",
//                                       "dbpassword" => "password",
//                                      ),
//                ),
//
 

);}
    ');
                }
                if (  !file_exists('config/schema.php')  ) {
                    @file_put_contents('config/schema.php','<?php
/**
 * Use the schema to generate database.sql file and the model files
 *
 * To create database.sql:
 *                          php skinnymvc.php generateSQL
 *
 *    database.sql will be stored in lib/skinnymvc/model/sql
 *
 * To create the model files:
 *                          php skinnymvc.php generateModel
 *
 *    model files will be stored in lib/skinnymvc/model
 *
 * Example schema code:
 * $model = array(\'table1\'=>array(
 *                                 \'field1\'=>array(\'type\'=>\'int\', \'null\'=>false, \'special\'=>\'auto_increment\'),
 *                                 \'field2\'=>\'datetime\',
 *                                 \'field3\'=>\'varchar(255)\',
 *                                 \'_INDEXES\'=>array(\'field3\'),
 *                                 \'_PRIMARY_KEY\'=>array(\'field1\'),
 *                               ),
 *                \'table2\'=>array(
 *                                 \'field1\'=>array(\'type\'=>\'int\', \'null\'=>false, \'special\'=>\'auto_increment\'), //null is false by default
 *                                 \'field2\'=>\'decimal(10,4)\',
 *                                 \'field3\'=>\'varchar(255)\',
 *                                 \'_INDEXES\'=>array( array(\'field3\',\'field4\') ),
 *                                 \'_PRIMARY_KEY\'=>array(\'field1\'),
 *                               ),
 *                \'table3\'=>array(
 *                                 \'field1\'=>array(\'type\'=>\'int\', \'null\'=>false, \'special\'=>\'auto_increment\'),
 *                                 \'field2\'=>array(\'type\'=>\'varchar(255)\', \'null\'=>false),
 *                                 \'field3\'=>\'text\',
 *                                 \'field4\'=>\'int\',
 *                                 \'field5\'=>\'int\',
 *                                 \'_UNIQUES\'=>array( \'field2\', array(\'field4\',\'field5\') ),
 *                                 \'_FULLTEXT\'=>array(\'field3\'),
 *                                 \'_PRIMARY_KEY\'=>array(\'field1\'),
 *                                 \'_FOREIGN_KEYS\'=>array(\'field4\'=>array(\'table\'=>\'table1\',\'field\'=>\'field1\'), \'field5\'=>array(\'table\'=>\'table2\',\'field\'=>\'field1\')),
 *                                 \'_DATABASE_KEY\'=>\'db_key\',
 *                                 \'_TABLE_NAME\'=>\'table_name\',
 *                               ),
 *                  );
 *
 */
');
                }
                if (  !file_exists('templates/layout.php')  ) {
                    @file_put_contents('templates/layout.php','<html>
 <head>
  <title>SkinnyMVC Project</title>
  <meta http-equiv="Content-Type" content="text/html" />
  <meta name="keywords" content="SkinnyMVC" />
  <meta name="description" content="SkinnyMVC Project" />
  <meta name="robots" content="index,follow" />
  <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
 </head>
 <body>
  <?php echo $skinny_content ?>

  <div id="SkinnyMVCAttribution" style="font-size:8pt;margin-bottom:8px;">Powered by <a href="http://skinnymvc.com">SkinnyMVC</a></div>
 </body>
</html>');
                }
                if (  !file_exists('templates/404.php')  ) {
                    @file_put_contents('templates/404.php','<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>SkinnyMVC: 404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found.</p>
<hr>
<address><a href="http://skinnymvc.com">SkinnyMVC</address>
</body>
</html>
   ');
                }
                if (  !file_exists('templates/500.php')  ) {
                    @file_put_contents('templates/500.php','<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>SkinnyMVC: 500 Internal Server Error</title>
</head><body>
<h1>Internal Server Error</h1>
<p>Something went wrong on the server.</p>
<hr>
<address><a href="http://skinnymvc.com">SkinnyMVC</address>
</body>
</html>
   
');
                }
                if (  !file_exists('lib/skinnymvc/dbcontroller/SkinnyDbTransaction.php')  ) {
                    @file_put_contents('lib/skinnymvc/dbcontroller/SkinnyDbTransaction.php','<?php
/**
 * filename:    SkinnyDbTransaction.php
 * description: Database Transaction class
 */

class SkinnyDbTransaction extends SkinnyBaseDbTransaction {
}
');
                }
                if (  !file_exists('lib/skinnymvc/dbcontroller/SkinnyDbController.php')  ) {
                    @file_put_contents('lib/skinnymvc/dbcontroller/SkinnyDbController.php','<?php
/**
 * filename:    SkinnyDbController.php
 * description: Database controller
 */

class SkinnyDbController extends SkinnyBaseDbController {

}

    ');
                }
                if (  !file_exists('lib/skinnymvc/controller/SkinnyController.php')  ) {
                    @file_put_contents('lib/skinnymvc/controller/SkinnyController.php','<?php
/******************************
 * filename:    SkinnyController.php
 * description: The main application controller. Every request goes through here.
 */

require_once(\'base/SkinnyBaseController.php\');

class SkinnyController extends SkinnyBaseController 
{

    public function __construct()
    {
        // Nothing here.
    }

    public function run()
    {
        // Put code here to rewrite the routing rules, or whatever.
        //
        // To make this happen, set the following fields to change the routing (and then call parent::run() )...
        //
        //     $this->module
        //     $this->action
        //     $this->param
        //
        //
        // For example, to make it so URLs like...
        //
        //     http://example.com/book/1234
        //     http://example.com/book/51238
        //     http://example.com/book/7
        //
        // ... work as if they were the URLs...
        //
        //     http://example.com/knowledgebase/item?ID=1234
        //     http://example.com/knowledgebase/item?ID=51238
        //     http://example.com/knowledgebase/item?ID=7
        //
        // ... we use the following code...
        //
        //     if (  \'book\' == $module  ) {
        //
        //         $ID = $this->action;
        //
        //         $this->param[\'GET\'][\'ID\'] = $ID;
        //         $this->module = \'knowledgebase\';
        //         $this->action = \'item\';
        //     }
        //
        //
        // Or for a more complex example, to make it so URLs like...
        //
        //     http://example.com/joe
        //     http://example.com/john
        //     http://example.com/jen
        //
        // ... work as if they were the URLs...
        //
        //     http://example.com/user/defaul?username=joe
        //     http://example.com/user/defaul?username=john
        //     http://example.com/user/defaul?username=jen
        //
        // ... EXCEPT in cases where there is actually a module for that, like...
        //
        //     http://example.com/settings
        //     http://example.com/about
        //     http://example.com/contact
        //
        // ... we use code like...
        //
        //     if (  ! $this->moduleExists($this->module)  ) {
        //         $this->module = \'user\';
        //         $this->action = \'default\';
        //         $this->param[\'GET\'][\'username\'] = $this->module;
        //     }
        //



        // This MUST stay here!
        parent::run();
    }

} // class SkinnyController

    ');
                }
                if (  !file_exists('lib/skinnymvc/core/SkinnyActions.php')  ) {
                    @file_put_contents('lib/skinnymvc/core/SkinnyActions.php','<?php
/******************************
 * filename:    SkinnyActions.php
 * description: main Actions class
 */

class SkinnyActions extends SkinnyBaseActions {

}

');
                }
                if (  !file_exists('lib/skinnymvc/core/Model.php')  ) {
                    @file_put_contents('lib/skinnymvc/core/Model.php','<?php
/**
 * filename:    Model.php
 * description: Use this class for methods that you want to extend into all model classes.
 */

abstract class SkinnyModel extends SkinnyBaseModel {
}
    ');
                }
        }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _uninstall()
    {
        echo "This will delete ALL files in the project. Are you sure? [y/N]";
        flush();
        @ob_flush();
        $confirmation  =  trim( fgets( STDIN ) );
        if ( $confirmation !== 'y' ) {
            exit;
        }
        _delete_directory('modules');
        _delete_directory('templates');
        _delete_directory('config');
        _delete_directory('lib');
        _delete_directory('plugins');
        _delete_directory('web');
        _delete_directory('tmp');

        unlink('README');
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _delete_directory($dir)
    {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!_delete_directory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!_delete_directory($dir . "/" . $item)) return false;
            }
        }
        return rmdir($dir);
    }


//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _create_module($module_name)
    {
            if (!file_exists('modules')) {
                echo "Invalid SkinnyMVC installation.\n";
                exit;
            }

            if(empty($module_name)) {
                echo "Usage: ".$argv[0]." createMod module\n";
                return;
            }

            if(file_exists('modules/'.$module_name)) {
                echo "Module '$module_name' already exists!\n";
                return;
            }

            mkdir('modules/'.$module_name);
            mkdir('modules/'.$module_name.'/actions');
            mkdir('modules/'.$module_name.'/templates');

            _create_module_actions_file($module_name);
            _create_module_template_files($module_name);
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _create_module_actions_file($module)
    {
        $moduleClassName = $module;
        $moduleClassName = str_replace('_', ' ', $moduleClassName);
        $moduleClassName = ucwords($moduleClassName);
        $moduleClassName = str_replace(' ', '', $moduleClassName);
        $moduleClassName .= 'Actions';

        $s = '<?php
/******************************
 * filename:    modules/'.$module.'/actions/actions.php
 * description:
 */

class '.$moduleClassName.' extends SkinnyActions {

    public function __construct()
    {
    }

  /**
   * The actions index method
   * @param array $request
   * @return array
   */
    public function executeIndex($request)
    {
        // return an array of name value pairs to send data to the template
        $data = array();
        return $data;
    }

}';

        @file_put_contents('modules/'.$module.'/actions/actions.php', $s);
    } 

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _create_module_template_files($module)
    {

        if ($module=='default') {
            $output = ' echo "   You have successfuly installed SkinnyMVC."; ';
        } else {
            $output = " /* Put your code here */ ";
        }

        $s = '    <h1>Under Construction</h1>'."\n"
           . '<?php'."\n"
           . $output."\n"
           ;

        @file_put_contents('modules/'.$module.'/templates/index.php', $s);

        //README for plugins
        $s = 'This directory contains your module-action templates.'."\n"
           . 'A template must be named after the associated action.'."\n"
           . 'For example, if the associated action is "list", then the file name of the template must be "list.php"'."\n"
           ;

        @file_put_contents('modules/'.$module.'/templates/README', $s);

    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    if (  !function_exists('camelize')  ) {
        function camelize($str)
        {
            $str = str_replace("_", " ", $str);
            $str = ucwords($str);
            $str = str_replace(" ", "", $str);
            return $str;
        }
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _get_nonkeys()
    {
        $nonkeys = array('_UNIQUE', '_UNIQUES', '_INDEX', '_INDEXES', '_PRIMARY_KEY', '_FOREIGN_KEY', '_FOREIGN_KEYS', '_FULLTEXT', '_DATABASE_KEY', '_TABLE_NAME');

        return $nonkeys;
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _generate_sql()
    {
        //
        // Check to see if files we ned exist.
        //
            if(!file_exists('config/schema.php')) {
                //Error
                echo "File schema.php does not exist!\n";
                exit;
            }

            if(!file_exists('config/settings.php')) {
                //Error
                echo "File settings.php does not exist!\n";
                exit;
            }


        //
        // include() the files we need.
        //
            include('config/schema.php');
            include('config/settings.php');


        //
        // Generate SQL.
        //
            $sql = '';

            if (!empty($model) && is_array($model) && count($model)>0) {
                $sql = _create_sql_from_array($model);
            } else {
                //Error
                echo "File schema.php is empty!\n";
                exit;
            }

            if (!empty($sql)) {
                if (count($sql)==1 && isset($sql['__database'])) {
                    @file_put_contents('lib/skinnymvc/model/sql/database.sql', $sql['__database']);
                    return;
                }

                foreach($sql as $dbName=>$dbSQL) {
                    @file_put_contents('lib/skinnymvc/model/sql/'.$dbName.'.sql', $dbSQL);
                }
            }

    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _generate_model()
    {
        if(!file_exists('config/schema.php')) {
            //Error
            echo "File schema.php does not exist!\n";
    /////// EXIT
            exit;
        }

        include('config/schema.php');
        include('config/settings.php');

        if (!empty($model) && is_array($model) && count($model)>0) {
            _create_model_from_array($model);
        }

    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _create_sql_from_array($model)
    {
        //
        //
        //
            $return_sql = array();

            if (isset(SkinnySettings::$CONFIG['dbs']) && !empty(SkinnySettings::$CONFIG['dbs']) && is_array(SkinnySettings::$CONFIG['dbs'])) {
                $dbs = array();
                foreach(SkinnySettings::$CONFIG['dbs'] as $db_key=>$value) {
                   array_push($dbs, $db_key);
                   $return_sql[$db_key] = '';
                }
            }
            $return_sql['__database'] = ''; //default db

            foreach($model As $tableName=>$table) {
                if (isset($table['_TABLE_NAME']) && !empty($table['_TABLE_NAME'])) {
                    $tableName = $table['_TABLE_NAME'];
                }

                //get the db driver (for ex. "mysql" or "pgsql")
                //we need this for stuff like "auto_increment" in $special
                if (isset(SkinnySettings::$CONFIG['dbs']) && !empty(SkinnySettings::$CONFIG['dbs']) && is_array(SkinnySettings::$CONFIG['dbs'])) {
                    if (isset($table['_DATABASE_KEY']) && !empty($table['_DATABASE_KEY'])) {
                        if (!in_array($table['_DATABASE_KEY'], $dbs)) {
                            //Error
                            echo "Invalid _DATABASE_KEY in table $tableName \n";
                            exit;
                        }
                        $db_driver = SkinnySettings::$CONFIG['dbs'][$table['_DATABASE_KEY']]['dbdriver'];
                    } else {
                        $db_driver = SkinnySettings::$CONFIG['dbdriver'];
                    }
                } else {
                    if (isset($table['_DATABASE_KEY'])) {
                        //Error
                        echo "Invalid _DATABASE_KEY in table $tableName; dbs not specified in config; \n";
                        exit;
                    }
                    $db_driver = SkinnySettings::$CONFIG['dbdriver'];
                }

                //For postgres
                $create_sequence = false;

                if ($db_driver == "pgsql") {
                    $sql = "CREATE TABLE ".$tableName." (\n";
                    $unique_key = "UNIQUE";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS ".$tableName." (\n";
                    $unique_key = "UNIQUE KEY";
                }
                foreach($table As $fieldName=>$field) {
                    if (in_array($fieldName, _get_nonkeys())) {
                        continue;
                    }
                    if (is_array($field)){
                        if (!isset($field['type']) || empty($field['type'])) { 
                            die("You must specify the data type for \'$fieldName\'\n");
                        }
                        $type = $field['type'];
                        $null = (isset($field['null'])&&$field['null'])?"NULL":"NOT NULL";
                        $special = isset($field['special'])?$field['special']:"";
                        if($db_driver == 'pgsql' && $special == 'auto_increment') {
                            $special = " DEFAULT nextval('".$tableName."_seq')";
                            $create_sequence = true;
                        }
                    } else {
                        if(empty($field)) {
                            $type='int';
                        } else {
                            $type = $field;
                        }
                        $null = "NOT NULL";
                        $special = "";
                    }
                    $sql .= "    ".$fieldName." ".strtoupper($type)." ".$null." ".$special.",\n";
                }//end foreach
                $sql = substr($sql, 0, strrpos($sql,','));

                if (isset($table['_PRIMARY_KEY']) && is_string($table['_PRIMARY_KEY'])) {
                    $sql .= ",\n";
                    $sql .= "    PRIMARY KEY (". $table['_PRIMARY_KEY'] .")";
                } else if (isset($table['_PRIMARY_KEY']) && !empty($table['_PRIMARY_KEY'])) {
                    $sql .= ",\n";
                    $sql .= "    PRIMARY KEY (".implode(',',$table['_PRIMARY_KEY']).")";
                } else {
                    echo "Warning: No _PRIMARY_KEY specified for \'$tableName\'!. It is recommended to define a primary key for every table to get the maximum functionality from SkinnyMVC.\n\n";
                }
                if (!empty($table['_UNIQUE'])) {
                    foreach (  $table['_UNIQUE'] AS $x  ) {

                        if (  is_array($x)  ) {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (".implode(',',$x).")";

                        } else if (  is_string($x)  ) {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (". $x .")";

                        } else {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (". (string)$x .")";
                        }

                    } // foreach
                }
                if (!empty($table['_UNIQUES'])) {
                    foreach (  $table['_UNIQUES'] AS $x  ) {

                        if (  is_array($x)  ) {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (".implode(',',$x).")";

                        } else if (  is_string($x)  ) {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (". $x .")";

                        } else {

                            $sql .= ",\n";
                            $sql .= "    $unique_key (". (string)$x .")";
                        }

                    } // foreach
                }

                unset ($indexes);
                if ($db_driver == "pgsql") {
                    if (!empty($table['_INDEX'])) {
                        $indexes = '';
                        foreach($table['_INDEX'] As $key) {
                            $indexes .= "CREATE INDEX ".$tableName."_".$key."_idx ON $tableName($key);\n";
                        } 
                    } 
                    if (!empty($table['_INDEXES'])) {
                        if (!isset($indexes)) {
                            $indexes = '';
                        }
                        foreach($table['_INDEXES'] As $key) {
                            $indexes .= "CREATE INDEX ".$tableName."_".$key."_idx ON $tableName($key);\n";
                        }
                    }
                } else {
                    if (!empty($table['_INDEX'])) {
                        $sql .= ",\n";
                        $single_keys = array();
                        $complex_keys = array();
                        foreach($table['_INDEX'] As $key) {
                            if (is_array($key)) {
                                array_push($complex_keys,"    KEY (".implode(',',$key).")");
                            } else {
                                array_push($single_keys, $key);
                            }
                        }
                        if (!empty($complex_keys)) {
                            $sql .= implode (",\n", $complex_keys); 
                        }
                        if (!empty($single_keys)) {
                            if (!empty($complex_keys)) {
                                $sql .= ",\n";
                            }
                            $sql .= "    KEY (".implode("),\n    KEY (", $single_keys).")";
                        }
                    }


                    if (!empty($table['_INDEXES'])) {
                        $sql .= ",\n";
                        $single_keys = array();
                        $complex_keys = array();
                        foreach($table['_INDEXES'] As $key) {
                            if (is_array($key)) {
                                array_push($complex_keys,"    KEY (".implode(',',$key).")");
                            } else {
                                array_push($single_keys, $key);
                            }
                        }
                        if (!empty($complex_keys)) {
                            $sql .= implode (",\n", $complex_keys); 
                        }
                        if (!empty($single_keys)) {
                            if (!empty($complex_keys)) {
                                $sql .= ",\n";
                            }
                            $sql .= "    KEY (".implode("),\n    KEY (", $single_keys).")";
                        }
                    }
                } // end if $db_driver == "pgsql"

                if (!empty($table['_FOREIGN_KEY'])) {
                    $sql .= ",\n";
                    $foreign_keys = array();
                    foreach($table['_FOREIGN_KEY'] As $keyName=>$key) {
                        array_push($foreign_keys, "    FOREIGN KEY (".$keyName.") REFERENCES ".$key["table"]." (".$key["field"].")");
                    }
                    $sql .= implode (",\n", $foreign_keys);
                }
                if (!empty($table['_FOREIGN_KEYS'])) {
                    $sql .= ",\n";
                    $foreign_keys = array();
                    foreach($table['_FOREIGN_KEYS'] As $keyName=>$key) {
                        array_push($foreign_keys, "    FOREIGN KEY (".$keyName.") REFERENCES ".$key["table"]." (".$key["field"].")");
                    }
                    $sql .= implode (",\n", $foreign_keys);
                }

                if ($db_driver == 'pgsql') {
                    $sql .= "\n);\n\n";
                } else {
                    $sql .= "\n) ENGINE=InnoDB;\n\n";
                }

                if ($create_sequence) {
                    $sql = "CREATE SEQUENCE ".$tableName."_seq MINVALUE 1;\n\n".$sql;
                }

                if (isset($indexes) && !empty($indexes)) {
                    $sql .= $indexes."\n\n";
                }

                $sql .= "\n";

                if (isset($table['_DATABASE_KEY']) && !empty($table['_DATABASE_KEY'])) {
                    if (!in_array($table['_DATABASE_KEY'], $dbs)) {
                        //Error
                        echo "Invalid _DATABASE_KEY in table $tableName \n";
                        exit;
                    }
                    $return_sql[$table['_DATABASE_KEY']] .= $sql;
                } else {
                    $return_sql['__database'] .= $sql;
                }
            }

        //
        // Return.
        //
            return $return_sql;
    }


//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function _create_model_from_array($model)
    {
        //
        // Create a list of all db_keys
        //
            if (isset(SkinnySettings::$CONFIG['dbs']) && !empty(SkinnySettings::$CONFIG['dbs']) && is_array(SkinnySettings::$CONFIG['dbs'])) {
                $dbs = array();
                foreach(SkinnySettings::$CONFIG['dbs'] as $db_key=>$value) {
                    array_push($dbs, $db_key);
                }
            }


        //
        // For each table....
        //
            foreach($model As $tableName=>$table) {
                if (isset($table['_TABLE_NAME']) && !empty($table['_TABLE_NAME'])) {
                    $tableName = $table['_TABLE_NAME'];
                }
                unset($databaseKey);
                if (isset($table['_DATABASE_KEY']) && !empty($table['_DATABASE_KEY'])) {
                    $databaseKey = $table['_DATABASE_KEY'];
                }

                //get the db driver (for ex. "mysql" or "pgsql")
                if (isset(SkinnySettings::$CONFIG['dbs']) && !empty(SkinnySettings::$CONFIG['dbs']) && is_array(SkinnySettings::$CONFIG['dbs'])) {
                    if (isset($databaseKey)) {
                        if (!in_array($databaseKey, $dbs)) {
                            //Error
                            echo "Invalid _DATABASE_KEY in table $tableName \n";
                            exit;
                        }
                        $db_driver = SkinnySettings::$CONFIG['dbs'][$databaseKey]['dbdriver'];
                    } else {
                        $db_driver = SkinnySettings::$CONFIG['dbdriver'];
                    }
                } else {
                    if (isset($databaseKey)) {
                        //Error
                        echo "Invalid _DATABASE_KEY in table $tableName; dbs not defined \n";
                        exit;
                    }
                    $db_driver = SkinnySettings::$CONFIG['dbdriver'];
                }

                $tableFieldsArray = array_diff(array_keys($table), _get_nonkeys());
                $tableFields = 'array("'.implode('","', $tableFieldsArray).'")';

                $integerType = array('int', 'integer', 'smallint', 'tinyint', 'longint');


                $tableFieldsValues = 'array(';
                foreach($tableFieldsArray As $column) {
                    $tableFieldsValues .= '"'.$column.'"=>';
                    if ((isset($table[$column]['type']) && in_array($table[$column]['type'], $integerType)) || in_array($table[$column], $integerType)) {
                        $tableFieldsValues .= "0,";
                    } else {
                        if (isset($table[$column]['null']) && false === $table[$column]['null']) {
                            $tableFieldsValues .= '"",';
                        } else {
                            $tableFieldsValues .= "null,";
                        }
                    }
                }
                $tableFieldsValues .= ')';
                $tableNameCamelized = camelize($tableName);
                if(isset($table['_PRIMARY_KEY'])) {
                    if (  is_array($table['_PRIMARY_KEY'])  ) {
                        $pk = 'array("'.implode('","',$table['_PRIMARY_KEY']).'")';
                    } else if(  is_string($table['_PRIMARY_KEY'])  ) {
                        $pk = 'array('. var_export($table['_PRIMARY_KEY'],TRUE) .')';
                    } else {
                        $pk = 'array('. var_export((string)$table['_PRIMARY_KEY'],TRUE) .')';
                    }
                } else {
                    $pk = 'null';
                        echo "Warning: No _PRIMARY_KEY specified for '$tableName'!. It is recommended to define a primary key for every table to get the maximum functionality from SkinnyMVC.\n\n"; 
                }

                //
                // Data for foreign keys.
                //
                    $tableForeignKeys = array();
                    if (  isset($table['_FOREIGN_KEYS']) && is_array($table['_FOREIGN_KEYS']) && !empty($table['_FOREIGN_KEYS'])  ) {
                        $tableForeignKeys = array_keys($table['_FOREIGN_KEYS']);
                    }


                $class = '<?php

require_once("base/Base'.$tableNameCamelized.'.php");

class '.$tableNameCamelized.' extends Base'.$tableNameCamelized.'
{
}
       ';

                $baseClass = '<?php
/**
 * filename:    Base'.$tableNameCamelized.'.php
 * description: Represents table \''.$tableName.'\'
 *
 */

require_once("../lib/skinnymvc/core/Model.php");

abstract class Base'.$tableNameCamelized.' extends SkinnyModel {

    // P R O C E D U R E S //////////////////////////////////////////////////////////////////////////////////////////////////
        public static function databaseKey() {
            return self::$databaseKey;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public static function fetchByPK($pk) {
            if (!isset(self::$primaryKey)) {
                throw new SkinnyException(\'This class does not have a primary key defined.\');
            }
            $_pk = self::$primaryKey;
            if (count($_pk)>1 && (!is_array($pk) ||  count($_pk) !=  count($pk))) {
                throw new SkinnyException(\'Invalid primary key.\');
            }
            if (!is_array($pk)) {
                $con = SkinnyDbController::getWriteConnection(self::$databaseKey);

                $condition = "WHERE ".$_pk[0]."=". $con->quote($pk);
            } else {
                $condition = array();
                foreach ($pk As $column=>$value) {
                    if (!in_array($column, $_pk)) {
                        throw new SkinnyException(\'Invalid primary key.\');
                    }
                    array_push($condition, $column."=\'".$value."\'");
                }
                $condition = "WHERE ".implode(" AND ", $condition);
            }
            return self::selectOne(array(\'conditions\'=>$condition));
        }

    //---------------------------------------------------------------------------------------------------------------------//

        // This procedure is deprecated!  Use "fetchByPK" instead.
        public static function getByPK($pk) {
            return self::fetchByPK($pk);
        }
';


                if (  isset($table['_UNIQUES']) && is_array($table['_UNIQUES']) && !empty($table['_UNIQUES'])  ) {
                    foreach (  $table['_UNIQUES'] AS $theUnique  ) {

                        if (  is_string($theUnique)  ) {
                            $theUnique = array( $theUnique );
                        }

                        $theCamelCasePart = '';
                        $paramPart = '';
                        $sqlWherePart = '';


                        $paramPartSeparator = '';
                        $theCamelCasePartSeparator = ' ';
                        $sqlWherePartSeparator = '';
                        foreach (  $theUnique AS $aField) {

                            $theCamelCasePart .= $theCamelCasePartSeparator . $aField;
                            $paramPart .= $paramPartSeparator .'$'. $aField;
                            $sqlWherePart .= $sqlWherePartSeparator . '\'. self::tableName .\'.' . $aField . ' = \'. $this->sqlReaderQuote($'. $aField .') .\'';

                            $paramPartSeparator = ', ';
                            $theCamelCasePartSeparator = ' and ';
                            $sqlWherePartSeparator = ' AND ';
                        } // foreach

                        $theCamelCasePart = str_replace(' ','',ucwords(str_replace('_',' ',$theCamelCasePart)));

                        $baseClass .= '
    //---------------------------------------------------------------------------------------------------------------------//

//        public static function fetchBy'. $theCamelCasePart .'('. $paramPart .')
//        {
//            //
//            // Deal with parameters.
//            //
//// #### TODO
//
//            //
//            // Fetch it.
//            //
//                $sql = \'
//
//                    SELECT \'. self::tableName .\'.*
//
//                    FROM \'. self::tableName .\'
//
//                    WHERE '. $sqlWherePart .'
//
//                \';
//
//                $criteria = array();
//
//                $criteria[\'sql\'] = $sql;
//
//                $obj = self::selectOne($criteria);
//
//
//            //
//            // Return.
//            //
//                return $obj;
//        }
';

                    } // foreach
                }


                $baseClass .= '
    ////////////////////////////////////////////////////////////////////////////////////////////////// P R O C E D U R E S //




    // G L O B A L S ////////////////////////////////////////////////////////////////////////////////////////////////////////
        protected static $fields = '.$tableFields.';
        protected static $tableName = \''.$tableName.'\';
        protected static $databaseKey = '.(isset($databaseKey)?'"'.$databaseKey.'"':"null").';
        protected static $className = \'Base'.$tableNameCamelized.'\';
        protected static $primaryKey = '.$pk.';
    //////////////////////////////////////////////////////////////////////////////////////////////////////// G L O B A L S //




    // C O N S T R U C T O R ////////////////////////////////////////////////////////////////////////////////////////////////
        public function __construct($fieldValues=null)
        {
            if(!empty($fieldValues)) {
                foreach($fieldValues As $field=>$value) {
                    if (is_numeric($field)) continue;
                    if (!in_array($field, self::$fields)) {
                        throw new SkinnyException(\'Invalid field name used in constructor.\');
                    }
                    $this->fieldValues[$field] = $value;
                }
                $this->originalFieldValues = $this->fieldValues;
            }
        }
    //////////////////////////////////////////////////////////////////////////////////////////////// C O N S T R U C T O R //




    // F I E L D S //////////////////////////////////////////////////////////////////////////////////////////////////////////
        protected $new = true;
        protected $originalFieldValues = '.$tableFieldsValues.';
        protected $fieldValues = '.$tableFieldsValues.';
        protected $modifiedFields = array();
        protected $magicTransactionNumber = null;

        //query error info
        protected $errorInfo = null;

        protected $cachedForeignKeyObjects;
    ////////////////////////////////////////////////////////////////////////////////////////////////////////// F I E L D S //




    // M E T H O D S ////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function isNew()
        {
            return $this->new;
        }
    //---------------------------------------------------------------------------------------------------------------------//
        public function makeNew($new)
        {
            $this->new = $new;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function isInAnyTransaction()
        {
            if (!empty($this->magicTransactionNumber)) {
                $tn = SkinnyDbTransaction::transactionMagicNumber(self::$databaseKey);
                if ($tn == $this->magicTransactionNumber) {
                    return true;
                }
            }
            return false;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function canModify()
        {
            if ($this->isInAnyTransaction()) {
                return true;
            } else if (!SkinnyDbTransaction::transactionExists(self::$databaseKey)) {
                return true;
            }

            return false;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function updateMagicTransactionNumber($mn)
        {
            $this->magicTransactionNumber = $mn;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function fetchDbTransaction()
        {
            if ($this->canModify()) {
                return SkinnyDbTransaction::fetchDbTransaction(self::$databaseKey, $this->magicTransactionNumber);
            }
            return null;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function get()
        {
            return $this->fieldValues;
        }

    //---------------------------------------------------------------------------------------------------------------------//

        public function set($fieldValues=null)
        {
            if(!empty($fieldValues)) {
                foreach($fieldValues AS $field=>$value) {

                    if (!in_array($field, self::$fields)) {
                        throw new SkinnyException(\'Invalid field name used in set().\');
                    }

                    $this->fieldValues[$field] = $value;

                    if (  !in_array($field, $this->modifiedFields)  ) {
                        $this->modifiedFields[] = $field;
                    }
                }
            }
        }

    //---------------------------------------------------------------------------------------------------------------------//

        public function reset()
        {
            $this->modifiedFields = array();

            $this->fieldValues   = $this->originalFieldValues;
        }

    //---------------------------------------------------------------------------------------------------------------------//

        public function isValid()
        {
            $is_valid = parent::isValid()
';

foreach ($tableFieldsArray as $column) {
    $columnCamelized = camelize($column);

    $baseClass .= '                      && $this->isValid'. $columnCamelized .'()'."\n";
} // foreach
$baseClass .= '                      ;'."\n";

$baseClass .=
'
            return $is_valid;
        }

';

                foreach ($tableFieldsArray as $column) {
                    $columnCamelized = camelize($column);

                    $baseClass .=     ''
                               .      '    '
                               .      '//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//'
                               .      "\n"
                               .      '    '
                               .      '// field: '. $column
                               .      "\n"
                               .      '    '
                               .      '//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//'
                               .      "\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      "        public function get".$columnCamelized."()\n"
                               .      "        {\n"
                               .      "            return \$this->fieldValues['$column'];\n"
                               .      "        }"
                               .      "\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      '    '
                               .      '//---------------------------------------------------------------------------------------------------------------------//'
                               .      "\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      "        public function set".$columnCamelized."(\$value)\n"
                               .      "        {"
                               .      "            \$this->fieldValues['$column'] = \$value;\n"
                               .      '            if (  !in_array('. var_export($column,TRUE) .', $this->modifiedFields)  ) {' ."\n"
                               .      '                $this->modifiedFields[] = '. var_export($column,TRUE) .';'               ."\n"
                               .      '            }'                                                                           ."\n"
                               .      '        }'                                                                               ."\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      '    '
                               .      '//---------------------------------------------------------------------------------------------------------------------//'
                               .      "\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      '        public function reset'. $columnCamelized .'()'                                                                            ."\n"
                               .      '        {'                                                                                                                        ."\n"
                               .      '            $i = array_search('. var_export($column,TRUE) .', $this->modifiedFields);'                                            ."\n"
                               .      '            if (  FALSE !== $i  ) {'                                                                                              ."\n"
                               .      '                unset($this->modifiedFields[$i]);'                                                                                ."\n"
                               .      '                $this->fieldValues['. var_export($column,TRUE) .'] = $this->originalFieldValues['. var_export($column,TRUE) .'];' ."\n"
                               .      '            }'                                                                                                                    ."\n"
                               .      '        }'                                                                                                                        ."\n"
                               .      "\n"
                               ;

                    $baseClass .=     ''
                               .      '    '
                               .      '//---------------------------------------------------------------------------------------------------------------------//'
                               .      "\n"
                               .      "\n"
                               ;

                    $baseClass .=     '        public function isValid'. $columnCamelized .'()' ."\n"
                               .      '        {'                                               ."\n"
                               .      '            return TRUE;'                                ."\n"
                               .      '        }'                                               ."\n"
                               .      "\n"
                               ;

                    if (  isset($table['_FOREIGN_KEYS']) && is_array($table['_FOREIGN_KEYS']) && !empty($table['_FOREIGN_KEYS'])  ) {
                        if (  in_array($column, $tableForeignKeys) && isset($table['_FOREIGN_KEYS'][$column]['table'])  ) {
                            $foreignCamelizedClassName = camelize($table['_FOREIGN_KEYS'][$column]['table']);

                            $retrieverMethodName = $columnCamelized;
                            if (  2 < strlen($retrieverMethodName) && 'Id' == substr($retrieverMethodName,-2)  ) {
                                $retrieverMethodName = substr($retrieverMethodName, 0, -2);
                            }

                            $baseClass .=     ''
                                       .      '    '
                                       .      '//---------------------------------------------------------------------------------------------------------------------//'
                                       .      "\n"
                                       .      "\n"
                                       ;

                            $baseClass .=     '        public function retrieve'. $retrieverMethodName .'()'                                                    ."\n"
                                       .      '        {'                                                                                                       ."\n"
                                       .      '            return '.$foreignCamelizedClassName.'::fetchByPK($this->fieldValues['.var_export($column,TRUE).']);' ."\n"
                                       .      '        }'                                                                                                       ."\n"
                                       .      ''                                                                                                                ."\n"
                                       ;


                            $baseClass .=     ''
                                       .      '    '
                                       .      '//---------------------------------------------------------------------------------------------------------------------//'
                                       .      "\n"
                                       .      "\n"
                                       ;

                            $baseClass .=     '        public function recache'. $retrieverMethodName .'()'                      ."\n"
                                       .      '        {'                                                                        ."\n"
                                       .      '            $this->cachedForeignKeyObjects['.var_export($column,TRUE).'] = $this->retrieve'. $retrieverMethodName .'();' ."\n"
                                       .      ''                                                                                 ."\n"
                                       .      '            return $this->cachedForeignKeyObjects['.var_export($column,TRUE).'];' ."\n"
                                       .      '        }'                                                                        ."\n"
                                       .      ''                                                                                 ."\n"
                                       ;


                            $baseClass .=     ''
                                       .      '    '
                                       .      '//---------------------------------------------------------------------------------------------------------------------//'
                                       .      "\n"
                                       .      "\n"
                                       ;

                            $baseClass .=     '        public function clearCached'. $retrieverMethodName .'()'                      ."\n"
                                       .      '        {'                                                                        ."\n"
                                       .      '            unset($this->cachedForeignKeyObjects['.var_export($column,TRUE).']);' ."\n"
                                       .      ''                                                                                 ."\n"
                                       .      '            return TRUE;' ."\n"
                                       .      '        }'                                                                        ."\n"
                                       .      ''                                                                                 ."\n"
                                       ;



                            $baseClass .=     ''
                                       .      '    '
                                       .      '//---------------------------------------------------------------------------------------------------------------------//'
                                       .      "\n"
                                       .      "\n"
                                       ;

                            $baseClass .=     '        public function cached'. $retrieverMethodName .'()'                       ."\n"
                                       .      '        {'                                                                        ."\n"
                                       .      '            if (  !isset($this->cachedForeignKeyObjects['.var_export($column,TRUE).']) || !is_object($this->cachedForeignKeyObjects['.var_export($column,TRUE).']) || ! $this->cachedForeignKeyObjects['.var_export($column,TRUE).'] instanceof '. $foreignCamelizedClassName .'  ) {' ."\n"
                                       .      '                $this->cachedForeignKeyObjects['.var_export($column,TRUE).'] = $this->retrieve'. $retrieverMethodName .'();' ."\n"
                                       .      '            }'                                                                    ."\n"
                                       .      ''                                                                                 ."\n"
                                       .      '            return $this->cachedForeignKeyObjects['.var_export($column,TRUE).'];' ."\n"
                                       .      '        }'                                                                        ."\n"
                                       .      ''                                                                                 ."\n"
                                       ;
                        }
                    }

                    $baseClass .= "\n\n";

                } // foreach
                $baseClass .= '

        public function fetchFields()
        {
            return self::$fields;
        }

        public function fetchTableName()
        {
            return self::$tableName;
        }

   public function reload() {
     if (!isset(self::$primaryKey)) {
       throw new SkinnyException(\'This class does not have a primary key defined.\');
     }
     $_pk = self::$primaryKey;
     $pk = array();
     $condition = array();

     foreach($_pk As $field) {
        array_push($condition, $field.\'="\'.$this->fieldValues[$field].\'"\');
     }
     $condition = "WHERE ".implode(" AND ", $condition);

     $criteria = array();
     $criteria[\'conditions\'] = $condition;

     $criteria[\'limit\'] = \'LIMIT 1\';
     $criteria[\'offset\'] = \'OFFSET 0\';


     $result = self::selectArray(self::$tableName, $criteria, self::$databaseKey);

     if (empty($result)) {
        //Something is wrong
        throw new SkinnyException("Could not reload object from database. Criteria:".var_export($criteria, true));
     }

     $row = $result[0];

     foreach($row As $field=>$value) {
       if (is_numeric($field)) continue;
       $this->fieldValues[$field] = $value;
     }

     $this->originalFieldValues = $this->fieldValues;

     $this->new = false;
   }

   public function __clone() {
      $this->new = true;
      $_pk = self::$primaryKey;
      //TODO: Create a new object instead
      foreach($_pk As $field) {
         $this->fieldValues[$field]         = 0;
         $this->originalFieldValues[$field] = 0;
      }
   }
  
   public function delete() {
     if ($this->new) return false;
     if (!$this->canModify()) {
        throw new SkinnyDbException(\'Not in transaction.\');
     }
     $sql = "DELETE FROM '.$tableName.' WHERE ";

     $_pk = self::$primaryKey;
     $npk = count($_pk);
     for ($loop=0;$loop<$npk;$loop++) {
       $sql .= $_pk[$loop]."=".$this->fieldValues[$_pk[$loop]];
       if($loop<$npk-1) {
         $sql .= " AND ";
       }
     }

     $con = SkinnyDbController::getWriteConnection(self::$databaseKey);
     $result = $con->exec($sql);
     if (!empty($result)) {
        return true;
     }
     return true;
   }
 

        protected function assertMaySave()
        {
            //
            // Check various things.
            //
';

                foreach($tableFieldsArray As $column) {
                    if ((isset($table[$column]['type']) && in_array($table[$column]['type'], $integerType)) || in_array($table[$column], $integerType)) {
                        $baseClass .= '                if (!is_numeric($this->fieldValues["'.$column.'"]) && !is_null($this->fieldValues["'.$column.'"])) {'."\n"
                                   .  '                    throw new SkinnyException(\''.$column.' must be numeric.\');'."\n"
                                   .  '                }'."\n";
                    } else {
                        if (isset($table[$column]['null']) && false === $table[$column]['null']) {
                            $baseClass .= '                if (is_null($this->fieldValues["'.$column.'"])) {'."\n"
                                       .  '                    throw new SkinnyException(\''.$column.' must not be null.\');'."\n"
                                       .  '                }'."\n";
                        }
                    }
                }



$baseClass .= '
            //
            // Check the parent version of this method too.
            //
                parent::assertMaySave();
        }


        public function save()
        {
            //
            // Run pre-Save.
            //
                $this->preSave();


            //
            //
            //
                if (!$this->canModify()) {
                    throw new SkinnyDbException(\'Not in transaction.\');
                }

                $this->assertMaySave();


            //
            //
            //
                $con = SkinnyDbController::getWriteConnection(self::$databaseKey);

                $numfv = count($this->fieldValues);
                $inserted = false;
                if($this->new) {
                    $sql = "INSERT INTO '.$tableName.' VALUES (";
                    $loop = 1;
                    foreach($this->fieldValues As $field=>$value) {
                        if (  !in_array($field, $this->modifiedFields)  ) {
                            $sql .= "DEFAULT";
                        } elseif(is_null($value)) {
                            $sql .= \'NULL\';
                        } else {
                            $sql .= $con->quote($value);
                        }
                        if ($loop<$numfv) {
                            $sql .= ", ";
                        }
                        $loop++;
                    } // foreach;
                    $sql .= ")";

                    $this->new = false;
                    $inserted = true;
                }else{
                    //UPDATE
                    $numfv = count($this->modifiedFields);
                    if ($numfv == 0) {
                        return true;
                    }
                    $sql = "UPDATE '.$tableName.' SET ";
                    $loop = 1;
                    foreach($this->fieldValues As $field=>$value) {
                        if (  in_array($field, $this->modifiedFields)  ) {
                            if (is_null($value)) {
                                $sql .= $field."=null";
                            } else if (is_bool($value)) {
                                if (  TRUE === $value  ) {
                                    $sql .= $field."=TRUE";
                                } else if (  FALSE === $value  ) {
                                    $sql .= $field."=FALSE";
                                } else {
                                    // Should never go in here!
                                }
                            } else {
                                $sql .= $field."=". $con->quote($value);
                            }
                            if ($loop<$numfv) {
                                $sql .= ", ";
                            }
                            $loop++;
                        }
                    } // foreach
                    $sql .= " WHERE ";
                    $_pk = self::$primaryKey;
                    $npk = count($_pk);
                    for ($loop=0;$loop<$npk;$loop++) {
                        $sql .= $_pk[$loop]."=".$this->fieldValues[$_pk[$loop]];
                        if($loop<$npk-1) {
                            $sql .= " AND ";
                        }
                    }
                }


      ';

   if ($db_driver == "pgsql") {
    // use query for inserts instead of exec for postgres
    //TODO: Make work with complex primary key! 
    $baseClass .= '
        $result = false;
        if ($inserted) {
           //Works with simple primary key only
           $stmt = $con->query($sql. " RETURNING ".self::$primaryKey[0]);

           if (!empty($stmt)) {
             $result = $stmt->fetchColumn();
             $this->fieldValues[self::$primaryKey[0]] = $result;
           } else {
             //result is false
           }
        } else {
           $result = $con->exec($sql);
        }
    ';

   } else {
    $baseClass .= '
        $result = $con->exec($sql);

        if ($inserted) {
            //TODO: Make work with multiple fields
            $this->fieldValues[self::$primaryKey[0]] = $con->lastInsertId();
        }
    ';
   } //end if

   // $result, if successful, contains the number of affected rows OR the insert_id (only in postgres).
   // In postgres, the insert_id should always be >0
   $baseClass .= '

            //
            // Since we just saved it, we need to update $this->originalFieldValues with the new saved values.
            //
                if (  $result  ) {
                    $this->originalFieldValues = $this->fieldValues;
                }

            //
            // Figure out result to return.
            //
                if (is_numeric($result) && $result>0) {
                   $result = true;
                } else {
                   $result = false;
                }

            //
            // Set error info.
            //
                $this->errorInfo = $con->errorInfo();


            //
            // Run post-Save.
            //
                $this->postSave();


            //
            // Return.
            //
                return $result;
        }

    //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

        public function errorInfo()
        {
            return $this->errorInfo;
        }
    //////////////////////////////////////////////////////////////////////////////////////////////////////// M E T H O D S //


    //selects and returns ONE instance of the class
    public static function selectOne($criteria = array()) {
        if (  !isset($criteria["sql"])  ) {
            $criteria[\'limit\'] = \'LIMIT 1\';
            $criteria[\'offset\'] = \'OFFSET 0\';
        }
        $result = self::select($criteria);

        if(!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

  /**
   * Selects and creates multiple instances of the class
   * @param mixed $criteria
   * @return array of class instances
   */
    public static function select($criteria = array()) {

        if (  !isset($criteria["sql"])  ) {

            //columns can be SQL or an array.
            if (empty($criteria[\'columns\'])) {
                $criteria[\'columns\'] = \'*\';
            } else {
                if (is_array($criteria[\'columns\'])) {
                    foreach($criteria[\'columns\'] As $column) {
                        if (!in_array($column, self::$fields)) {
                            throw new SkinnyException(\'Invalid column: "\'.$column.\'".\');
                        }
                    }
                    $criteria[\'columns\'] = implode (\',\', $criteria[\'columns\']);
                }
            }

            // group can be SQL or array
            if (empty($criteria[\'group\'])) {
                $criteria[\'group\'] = \'\';
            } else {
                if(is_array($criteria[\'group\'])) {
                    foreach($criteria[\'group\'] As $column) {
                        if (!in_array($column, self::$fields)) {
                            throw new SkinnyException(\'Invalid column: "\'.$column.\'".\');
                        }
                    }
                    $criteria[\'group\'] = \'GROUP BY \'.implode(\',\',$criteria[\'group\']);
                }
            }
        }


        $result = self::selectArray(self::$tableName, $criteria, self::$databaseKey);

        if (is_array($result)) {
            $objects = array();

            foreach($result as $row) {
                $obj = new '.$tableNameCamelized.'($row);
                $obj->makeNew(false); 
                array_push($objects, $obj);
            }
            return $objects;
        }
        return null;
    }

}
       ';

            if (!file_exists('lib/skinnymvc/model/'.$tableNameCamelized.'.php')) {
                @file_put_contents('lib/skinnymvc/model/'.$tableNameCamelized.'.php', $class);
                echo "Created $tableNameCamelized.php\n";
            }
            @file_put_contents('lib/skinnymvc/model/base/Base'.$tableNameCamelized.'.php', $baseClass);
            echo "Created Base$tableNameCamelized.php\n";
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////// P R O C E D U R E S //



// C L A S S E S ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    class MVC
    {
        // M E T H O D S ////////////////////////////////////////////////////////////////////////////////////////////////////
            public function install()
            {
                _upgrade();
                _install();
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function upgrade()
            {
                _upgrade();
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function uninstall()
            {
                _uninstall();
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function createModule()
            {
                global $argv;

                _create_module($argv[2]);
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function createMod()
            {
                $this->createModule();
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function generateSQL()
            {
                _generate_sql();
            }

        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

            public function generateModel()
            {
                _generate_model();
            }
        //////////////////////////////////////////////////////////////////////////////////////////////////// M E T H O D S //

    } // class MVC
//////////////////////////////////////////////////////////////////////////////////////////////////////////// C L A S S E S //



//
// M A I N
//

    //
    // Make sure the proper number of CLI parameters were given.
    //
        if ($argc < 2) {
            _help();
/////////// EXIT
            exit(0);
        }

    //
    //
    //
        $mvc = new MVC();

        if (is_callable(array($mvc, $argv[1])) && $argv[1]!='main') {
            call_user_func_array(array($mvc, $argv[1]), array($argv)); //hack
        } else {
            echo "Invalid argument!\n\n";
            _help();
/////////// EXIT
            exit(0);
        }


    //
    // Exit
    //
/////// EXIT
        exit(0);
