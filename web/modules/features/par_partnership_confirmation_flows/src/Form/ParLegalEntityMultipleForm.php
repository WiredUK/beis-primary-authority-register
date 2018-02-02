<?php

namespace Drupal\par_partnership_confirmation_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataLegalEntity;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_partnership_flows\ParPartnershipFlowsTrait;

/**
 * Add multiple legal entities forms.
 */
class ParLegalEntityMultipleForm extends ParBaseForm {

  use ParPartnershipFlowsTrait;

  protected $pageTitle = 'Add a legal entity for the organisation';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'par_partnership_legal_entity_add_multiple';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // Get selected legal entities from previous step in flow.
    $select_form_cid = $this->getFlowNegotiator()
      ->getFormKey('par_partnership_confirmation_select_legal_entities');

    $legal_entity_field = $this->getFlowDataHandler()
      ->getTempDataValue('field_legal_entity', $select_form_cid);

    $selected_legal_entities = isset($selected_legal_entities) ?
      array_filter($legal_entity_field) : [];

    // Display list of selected legal entities for this partnership.
    if (!empty($selected_legal_entities)) {
      $form['existing_legal_entities'] = [
        '#type' => 'fieldset',
        '#attributes' => ['class' => 'form-group'],
        '#title' => $this->t('Existing legal entities on the primary authority register'),
        '#description' => $this->t('<p>Below is a list of your organisation’s legal entities currently on the primary authority register</p>'),
      ];

      foreach (array_keys($selected_legal_entities) as $entity_id) {
        $entity = ParDataLegalEntity::load($entity_id);

        $entity_view_builder = $this->getParDataManager()
          ->getViewBuilder($entity->getEntityTypeId());

        $form['existing_legal_entities'][$entity->id()] = $entity_view_builder->view($entity, 'title');
      }
    }

    $form['legal_entity_intro'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('What is a legal entity?'),
      'text' => [
        '#type' => 'markup',
        '#markup' => "<p>" . $this->t("A legal entity is any kind of individual or organisation that has legal standing. This can include a limited company or partnership, as well as other types of organisations such as trusts and charities.") . "</p>",
      ],
    ];

    return parent::buildForm($form, $form_state); // TODO: Change the autogenerated stub
  }
//
//  public function multipleItemActionsSubmit(array &$form, FormStateInterface $form_state) {
//    $values = $this->cleanseFormDefaults($form_state->getValues());
//    $this->getFlowDataHandler()->setFormTempData($values);
//
//    // Get value of current amount of fields displayed.
//    $fields_to_display = $this->getFlowDataHandler()
//      ->getTempDataValue('fields_to_display');
//
//    $submit_action = $form_state->getTriggeringElement()['#name'];
//
//    // Check input button name to decide whether to add/remove a field.
//    $submit_action === 'add_another' ?
//      $fields_to_display++ : $fields_to_display--;
//
//    // Populate hidden field to generate more legal entity form elements.
//    $this->getFlowDataHandler()
//      ->setTempDataValue('fields_to_display', $fields_to_display);
//  }

}
