<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\Core\Session\AccountInterface;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_forms\ParFormBuilder;
use Drupal\par_forms\ParFormPluginBase;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * About business form plugin.
 *
 * @ParForm(
 *   id = "person_select",
 *   title = @Translation("Person selection.")
 * )
 */
class ParSelectPersonForm extends ParFormPluginBase {

  /**
   * {@inheritdoc}
   */
  public function loadData($cardinality = 1) {
    $user_people = [];

    // Get the person entities that represent a given user.
    /** @var \Drupal\user\Entity\User $account */
    $account = $this->getFlowDataHandler()->getParameter('user');
    if ($account && $account->isAuthenticated() && $people = $this->getParDataManager()->getUserPeople($account)) {
      // Ignore deleted person accounts.
      $people = array_filter($people, function ($person) {
        return !$person->isDeleted();
      });

      $user_people = $this->getParDataManager()->getEntitiesAsOptions($people, $user_people, 'summary');
    }

    $this->getFlowDataHandler()->setFormPermValue('user_people', $user_people);

    parent::loadData();
  }

  /**
   * {@inheritdoc}
   */
  public function getElements($form = [], $cardinality = 1) {
    // Get all the allowed authorities.
    $user_people = $this->getFlowDataHandler()->getFormPermValue('user_people');

    // If there are no people we should create a new record.
    if (count($user_people) <= 0) {
      $url = $this->getUrlGenerator()->generateFromRoute($this->getFlowNegotiator()->getFlow()->getNextRoute('cancel'), $this->getRouteParams());
      return new RedirectResponse($url);
    }
    // If only one authority submit the form automatically and go to the next step.
    elseif (count($user_people) === 1) {
      $this->getFlowDataHandler()->setTempDataValue('user_person', key($user_people));
      $url = $this->getUrlGenerator()->generateFromRoute($this->getFlowNegotiator()->getFlow()->getNextRoute('next'), $this->getRouteParams());
      return new RedirectResponse($url);
    }

    $form['intro'] = [
      '#type' => 'markup',
      '#markup' => "We have found multiple contact records for you, please choose which one you would like to update.",
      '#prefix' => '<p>',
      '#suffix' => '</p>',
    ];

    $form['user_person'] = [
      '#type' => 'radios',
      '#title' => t('Choose which contact record you would like to update'),
      '#options' => $user_people,
      '#default_value' => $this->getDefaultValuesByKey("user_person", $cardinality, NULL),
      '#attributes' => ['class' => ['form-group']],
    ];

    return $form;
  }

  /**
   * Validate date field.
   */
  public function validate($form, &$form_state, $cardinality = 1, $action = ParFormBuilder::PAR_ERROR_DISPLAY) {
    $authority_id_key = $this->getElementKey('par_data_authority_id');
    if (empty($form_state->getValue($authority_id_key))) {
      $form_state->setErrorByName($authority_id_key, $this->t('<a href="#edit-par_data_authority_id">You must select an authority.</a>'));
    }

    return parent::validate($form, $form_state, $cardinality, $action);
  }
}
