<?php

namespace Drupal\par_partnership_confirmation_flows;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\ParFlowException;
use Drupal\par_roles\ParAccessResultForbidden;
use Symfony\Component\Routing\Route;

trait ParFlowAccessTrait {

  /**
   * {@inheritdoc}
   */
  public function accessCallback(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    try {
      $this->getFlowNegotiator()->setRoute($route_match);
      $this->getFlowDataHandler()->reset();
      $this->loadData();
    } catch (ParFlowException $e) {

    }

    // Get the parameters for this route.
    $par_data_partnership = $this->getFlowDataHandler()->getParameter('par_data_partnership');

    $allowed_statuses = [
      $par_data_partnership->getTypeEntity()->getDefaultStatus(),
      'confirmed_authority',
    ];

    // If this partnership has not been reviewed by the organisation.
    if (!in_array($par_data_partnership->getRawStatus(), $allowed_statuses)) {
      $reason = 'This partnership has already been reviewed yet.';
      $explanation = 'This partnership has already been reviewed yet.';
      $this->accessResult = new ParAccessResultForbidden($reason, $explanation);
    }

    return parent::accessCallback($route, $route_match, $account);
  }
}
