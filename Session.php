<?php

  /**
   * Session Wrapper Class.
   * Write your sessions in a more readable way. Great for multidimensional sessions.
   *
   * @author Viktor Geringer <devfakeplus@googlemail.com>
   * @version 1.3.0
   * @license The MIT License (MIT)
   */
  class Session {

    /**
     * The original reference for the $_SESSION array.
     */
    private $reference;

    /**
     * Copy of $_SESSION. Need for check if key or value exists.
     */
    private $copy;

    /**
     * The keys you work with.
     */
    private $keys;

    /**
     * Need second variable with stored keys you work with.
     */
    private $keysForExists;

    /**
     * Need third variable with stored keys you work with.
     */
    private $keysForRemove;


    /**
     * Start session if required, get your keys and initialize the variables.
     */
    public function __construct($keys, $seperator)
    {
      if(session_status() == PHP_SESSION_NONE) session_start();

      $this->keys = $keys ? explode($seperator, $keys) : null;
      $this->keysForExists = $this->keys;
      $this->keysForRemove = $this->keys;

      $this->reference = & $_SESSION;
      $this->copy = $_SESSION;
    }

    /**
     * Get the requested session. If key does not exists, return a default value.
     * If no key set, return complete the $_SESSION array.
     */
    public function get($default = null)
    {
      if( ! $this->keys) {
        return $_SESSION;
      } elseif($this->exists()) {
        $this->createDeepSession();

        return $this->reference;
      }

      return $default;
    }

    /**
     * Set a value for a session.
     */
    public function set($value)
    {
      $this->createDeepSession();

      $this->reference = $value;
    }

    /**
     * Check if session value is equal to the parameter.
     */
    public function is($value)
    {
      if($this->exists()) {
        $this->createDeepSession();

        return $this->reference == $value;
      }
    }

    /**
     * Call the removeKey() method.
     */
    public function remove()
    {
      return $this->removeKey($_SESSION);
    }

    /**
     * Check if requested key exists.
     */
    public function exists($array = null)
    {
      if( ! $array) $array = $this->copy;

      $_key = array_shift($this->keysForExists);

      foreach($array as $key => & $value) {
        if(is_array($value) && ! empty($value) && $key == $_key && ! empty($this->keysForExists)) {
          return $this->exists($value);
        } elseif($key == $_key && empty($this->keysForExists)) {
          return true;
        }
      }
    }

    /**
     * Use this method for flash messages.
     *
     * Stores the value of a session, delete the original session and return the save.
     * Useful for form validation and redirect back with messages.
     */
    public function message()
    {
      if($this->exists()) {
        $this->createDeepSession();

        $value = $this->reference;
        $this->remove();

        return $value;
      }
    }

    /**
     * Creates dynamic a deep session.
     */
    private function createDeepSession()
    {
      while($name = array_shift($this->keys)) {
        $this->reference = & $this->reference[$name];
      }
    }

    /**
     * Remove the key in session.
     */
    private function removeKey( & $array)
    {
      $_key = array_shift($this->keysForRemove);

      foreach($array as $key => & $value) {
        if(is_array($value) && $key == $_key && ! empty($this->keysForRemove)) {
          return $this->removeKey($value);
        } else {
          if($key == $_key) {
            unset($array[$key]);
          }
        }
      }
    }

    /**
     * Destroy complete session.
     *
     * http://stackoverflow.com/questions/3948230/best-way-to-completely-destroy-a-session-even-if-the-browser-is-not-closed
     */
    public function destroy()
    {
      $_SESSION = array();

      if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
        );
      }

      session_destroy();
    }
  }
