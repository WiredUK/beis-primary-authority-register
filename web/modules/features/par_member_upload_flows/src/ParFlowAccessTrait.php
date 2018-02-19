<?php

namespace Drupal\par_member_upload_flows;

use Drupal\Core\Access\AccessResult;
use Drupal\par_data\Entity\ParDataPartnership;

trait ParFlowAccessTrait {

  /**
   * {@inheritdoc}
   */
  public function accessCallback(ParDataPartnership $par_data_partnership = NULL) {
//    dpm($par_data_partnership);

    $lock = \Drupal::lock();
//    $lock = $lock->acquire('partnership-members:{ID}');
    $lock = $lock->acquire('partnership_lock');

    // If the partnership isn't a coordinated one then don't allow update.
    if (!$lock || !$par_data_partnership->isCoordinated()) {
      $this->accessResult = AccessResult::forbidden('This is not a coordianted partnership.');
    }

    return parent::accessCallback();
  }

}
