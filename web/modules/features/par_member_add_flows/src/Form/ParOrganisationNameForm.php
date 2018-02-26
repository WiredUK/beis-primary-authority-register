<?php

namespace Drupal\par_member_add_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_member_add_flows\ParFlowAccessTrait;

/**
 * Enter the member organisation name.
 */
class ParOrganisationNameForm extends ParBaseForm {

  use ParFlowAccessTrait;

  protected $formItems = [
    'par_data_organisation:organisation' => [
      'organisation_name' => 'organisation_name',
    ],
  ];

  protected $pageTitle = 'Add member organisation name';

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['organisation_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the member organisation name'),
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues('organisation_name'),
    ];

    return parent::buildForm($form, $form_state);
  }

}
