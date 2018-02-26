<?php

namespace Drupal\par_roles\Access;

use Drupal\Core\Access\AccessResultInterface;

/**
 * Interface for access result value objects with stored explanation for public consumption.
 *
 * Care should be taken not to give away information that could be useful to a potential attacker.
 *
 * For example, a developer can specify the explanation for forbidden access:
 * @code
 * new ParAccessResultForbidden('You are not authorized to hack core');
 * @endcode
 *
 * @see \Drupal\par_roles\Access\ParAccessResultInterface
 */
interface ParAccessResultForbiddenInterface extends AccessResultInterface {

  /**
   * Gets the explanation for this access result.
   *
   * @return string|null
   *   The explanation of this access result or NULL if no explanation is provided.
   */
  public function getExplanation();

  /**
   * Sets the explanation for this access result.
   *
   * @param $explanation string|null
   *   The explanation of this access result or NULL if no explanation is provided.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result instance.
   */
  public function setExplanation($explanation);

}
