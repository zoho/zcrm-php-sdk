<?php
/**
 * Trait for singleton functionality
 */

namespace ZCRM\common;

trait Singleton {

  private static $instance;
  private final function __construct() {
  }
  private final function __clone() {
  }
  private final function __wakeup() {
  }
  public final static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self;
    }
    return self::$instance;
  }
}