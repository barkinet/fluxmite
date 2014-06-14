<?php

/**
 * @file
 * Contains MiteAccountTaskHandler.
 */

namespace Drupal\fluxmite\TaskHandler;

/**
 * Event dispatcher for changed mite accounts.
 */
class MiteAccountTaskHandler extends MiteTaskHandlerBase {

  /**
   * {@inheritdoc}
   */
  public function runTask() {
	print_r("<br>account<br>");
	$this->checkAndInvoke();
  }
}