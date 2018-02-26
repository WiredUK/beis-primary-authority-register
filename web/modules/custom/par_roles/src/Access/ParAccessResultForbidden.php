<?php

namespace Drupal\par_roles\Access;

use Drupal\Core\Access\AccessResultForbidden;

/**
 * Value object indicating a forbidden access result, with cacheability metadata.
 */
class ParAccessResultForbidden extends AccessResultForbidden implements ParAccessResultForbiddenInterface {

  /**
   * The publically visible explanation of why access is forbidden.
   *
   * Must be used with care not to give information too much information to potential attackers.
   *
   * @var string|null
   */
  protected $explanation;

  /**
   * Constructs a new AccessResultForbidden instance.
   *
   * @param null|string $explanation
   *   (optional) A public message to provide details about this access result.
   */
  public function __construct($reason = NULL, $explanation = NULL) {
    $this->explanation = $explanation;
    parent::__construct($reason);
  }

  /**
   * {@inheritdoc}
   */
  public function getExplanation() {
    return $this->explanation;
  }

  /**
   * {@inheritdoc}
   */
  public function setExplanation($explanation) {
    $this->explanation = $explanation;
    return $this;
  }

}
