<?php

namespace Drupal\par_partnership_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_partnership_flows\ParPartnershipFlowsTrait;

/**
 * The partnership form for the sic code details.
 */
class ParPartnershipFlowsSicCodeForm extends ParBaseForm {

  use ParPartnershipFlowsTrait;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'par_partnership_sic_code';
  }

  /**
   * Helper to get all the editable values.
   *
   * Used for when editing or revisiting a previously edited page.
   *
   * @param \Drupal\par_data\Entity\ParDataPartnership $par_data_partnership
   *   The Authority being retrieved.
   * @param int $sic_code_delta
   *   The field delta to update.
   */
  public function retrieveEditableValues(ParDataPartnership $par_data_partnership = NULL, $sic_code_delta = NULL) {
    if ($par_data_partnership) {
      // If we're editing an entity we should set the state
      // to something other than default to avoid conflicts
      // with existing versions of the same form.
      $this->setState("edit:{$par_data_partnership->id()}");

      if ($sic_code_delta) {
        $par_data_organisation = current($par_data_partnership->getOrganisation());
        $sic_code = $par_data_organisation ? $par_data_organisation->get('field_sic_code')->get($sic_code_delta) : NULL;
var_dump($sic_code);
        $this->loadDataValue("sic_code", $sic_code);
      }
    }

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ParDataPartnership $par_data_partnership = NULL, $sic_code_delta = NULL) {
    $this->retrieveEditableValues($par_data_partnership, $sic_code_delta);
    $par_data_organisation = current($par_data_partnership->getOrganisation());

    $form['intro'] = [
      '#markup' => $this->t('Change the SIC Code of your business'),
    ];

    $options = [];

    // Get the list of valid sic codes.
    // Probably not the best method, but will do for now!
    $sic_codes = \Drupal::entityTypeManager()->getStorage('par_data_sic_code')->loadMultiple();
    foreach ($sic_codes as $sic_code) {
      $options[$sic_code->id()] = str_replace('.', '-', $sic_code->get('sic_code')->getString()) . ' ' . $sic_code->get('description')->getString();
    }

    $form['sic_code'] = [
      '#type' => 'select',
      '#title' => $this->t('SIC Code'),
      '#options' => $options,
      '#default_value' => $this->getDefaultValues("sic_code"),
    ];

    $form['save'] = [
      '#type' => 'submit',
      '#name' => 'save',
      '#value' => t('Save'),
    ];

    $cancel_link = $this->getFlow()->getPrevLink('cancel')->setText('Cancel')->toString();
    $form['cancel'] = [
      '#type' => 'markup',
      '#markup' => t('@link', ['@link' => $cancel_link]),
    ];

    // Make sure to add the person cacheability data to this form.
    $this->addCacheableDependency($par_data_partnership);

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    // Save the value for the trading name field.
    $par_data_partnership = $this->getRouteParam('par_data_partnership');
    $par_data_organisation = current($par_data_partnership->getOrganisation());
    $sic_code_delta = $this->getRouteParam('sic_code_delta');

    $items = $par_data_organisation->get('field_sic_code')->getValue();

    $items[$sic_code_delta] = ['target_id' => $this->getTempDataValue('sic_code')];
    $par_data_organisation->set('field_sic_code', $items);

    if ($par_data_organisation->save()) {
      $this->deleteStore();
    }
    else {
      $message = $this->t('This %field could not be saved for %form_id');
      $replacements = [
        '%field' => $this->getTempDataValue('trading_name'),
        '%form_id' => $this->getFormId(),
      ];
      $this->getLogger($this->getLoggerChannel())->error($message, $replacements);
    }

  }

}
