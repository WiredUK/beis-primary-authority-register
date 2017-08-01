<?php

namespace Drupal\par_flow_transition_partnership_details\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataInspectionPlan;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;

/**
 * The inspection plan confirmation form for Transition Journey 1.
 */
class ParFlowTransitionInspectionPlanForm extends ParBaseForm {

  /**
   * @var string
   *   A machine safe value representing the current form journey.
   */
  protected $flow = 'transition_partnership_details';

  public function getFormId() {
    return 'par_flow_transition_partnership_inspection_plan';
  }

  /**
   * Helper to get all the editable values when editing or
   * revisiting a previously edited page.
   *
   * @param ParDataPartnership $par_data_partnership
   *   The Partnership being retrieved.
   * @param ParDataInspectionPlan $par_data_inspection_plan
   *   The Partnership being retrieved.
   */
  public function retrieveEditableValues(ParDataPartnership $par_data_partnership = NULL) {
    if ($par_data_partnership) {
      // If we're editing an entity we should set the state
      // to something other than default to avoid conflicts
      // with existing versions of the same form.
      $this->setState("edit:{$par_data_partnership->id()}");

      foreach ($par_data_partnership->get('inspection_plan')->referencedEntities() as $inspection_plan) {
        // Partnership Confirmation.
        $allowed_values = $inspection_plan->type->entity->getConfigurationByType('inspection_status', 'allowed_values');
        // Set the on and off values so we don't have to do that again.
        $this->loadDataValue("inspection_plan_confirmation_value", $allowed_values['confirmed_authority']);
        $inspection_plan_status = $inspection_plan->getParStatus();
        if ($inspection_plan_status === $allowed_values['confirmed_authority']) {
          $this->loadDataValue("inspection_plan_confirmation", TRUE);
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ParDataPartnership $par_data_partnership = NULL) {
    $this->retrieveEditableValues($par_data_partnership);

    // Show the task links in table format.
    $form['document_list'] = array(
      '#type' => 'table',
      '#title' => 'Inspection plans',
      '#header' => ['Confirm', 'Inspection Plan'],
      '#empty' => $this->t("There is no inspection plan for this partnership."),
    );

    // Get all the inspection plans for this partnership.
    foreach ($par_data_partnership->get('inspection_plan')->referencedEntities() as $inspection_plan) {
      $inspection_plan_view_builder = $inspection_plan->getViewBuilder();

      // The first column contains a rendered summary of the document.
      $inspection_plan_summary = $inspection_plan_view_builder->view($inspection_plan, 'summary');

      // Inspection Plan Confirmation.
      $form['document_list'][$inspection_plan->id()] = [
        'confirm' => [
          '#type' => 'checkbox',
          '#title' => t(''),
          '#disabled' => $this->getDefaultValues("inspection_plan_confirmation", FALSE),
          '#default_value' => $this->getDefaultValues("inspection_plan_confirmation", FALSE),
          '#return_value' => $this->getDefaultValues("inspection_plan_confirmation_value", 0),
        ],
        'inspection_plan' => $this->renderMarkupField($inspection_plan_summary),
      ];

      // Make sure to add the document cacheability data to this form.
      $this->addCacheableDependency($inspection_plan);
    }

    $form['helpdesk'] = [
      '#type' => 'markup',
      '#markup' => "<p>To upload a new inspection plan, please email it to the <a href='mailto:pa@bis.gsi.gov.uk'>Help Desk</a>.</p>"
    ];

    $form['next'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
    ];

    // Make sure to add the partnership cacheability data to this form.
    $this->addCacheableDependency($par_data_partnership);

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $par_data_partnership = $this->getRouteParam('par_data_partnership');
    $this->retrieveEditableValues($par_data_partnership);

    // Get all the inspection plans for this partnership.
    foreach ($par_data_partnership->get('inspection_plan')->referencedEntities() as $inspection_plan) {
      // Save the value for the about_partnership field.
      $inspection_plan_status = $this->decideBooleanValue(
        $this->getTempDataValue(['document_list',$inspection_plan->id(),'confirm']),
        $this->getDefaultValues("inspection_plan_confirmation_value", NULL)
      );

      // Save only if the value is different from the one currently set.
      if ($inspection_plan_status && $inspection_plan_status !== $inspection_plan->getParStatus()) {
        $inspection_plan->set('inspection_status', $inspection_plan_status);
        if (!$inspection_plan->save()) {
          $message = $this->t('The %field field could not be saved for inspection plan %inspection_plan on form %form_id');
          $replacements = [
            '%field' => 'confirmation',
            '%inspection_plan' => $inspection_plan->id(),
            '%form_id' => $this->getFormId(),
          ];
          $this->getLogger($this->getLoggerChannel())->error($message, $replacements);
        }
      }
    }

    // Actually we always want to delete the store here.
    // Confirmation checkboxes should never be checked by default.
    $this->deleteStore();

    // Go back to the overview.
    $form_state->setRedirect($this->getFlow()->getRouteByStep(3), $this->getRouteParams());
  }
}