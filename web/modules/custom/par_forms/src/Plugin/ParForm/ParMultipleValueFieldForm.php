<?php

namespace Drupal\par_forms\Plugin\ParForm;

use Drupal\par_data\Entity\ParDataLegalEntity;
use Drupal\par_forms\ParFormPluginBase;

/**
 * This form is used to display a field with multiple values.
 *
 * @ParForm(
 *   id = "multivalue_form",
 *   title = @Translation("Use this form to create any page to edit fields.")
 * )
 */
class ParMultipleValueFieldForm extends ParFormPluginBase {

  public function loadData() {
//    if ($par_data_partnership = $this->getFlowDataHandler()->getParameter('par_data_partnership')) {
  //      $partnership_legal_entities = $par_data_partnership->getLegalEntity();
  //
  //      //      kint($partnership_legal_entities);
  //
  //      if (!empty($partnership_legal_entities)) {
  //        foreach ($partnership_legal_entities as $legal_entity) {
  //          $data[] = [
  //            'registered_name' => $legal_entity->get('registered_name')->getString(),
  //            'registered_number' => $legal_entity->get('registered_number')->getString(),
  //            'legal_entity_type' => $legal_entity->get('legal_entity_type')->getString(),
  //          ];
  //        }
  //
  //        //        $this->getFlowDataHandler()->setTempDataValue('legal_entity', $data);
  //      }
  //    }

    parent::loadData(); // TODO: Change the autogenerated stub
  }

  public function getLegalEntityFormElements($i = 1) {
    $legal_entity_bundle = $this->getParDataManager()->getParBundleEntity('par_data_legal_entity');

  }

  /**
   * {@inheritdoc}
   */
  public function getElements($form = [], $i = 1) {
//    var_dump($i);
    //    $fields_to_display = $this->getFlowDataHandler()
    //      ->getDefaultValues('fields_to_display', 1);
    //
    //    // Get selected legal entities from previous step in flow.
    //    $select_form_cid = $this->getFlowNegotiator()
    //      ->getFormKey('par_partnership_confirmation_select_legal_entities');
    //
    //    $selected_legal_entities = array_filter($this->getFlowDataHandler()
    //      ->getTempDataValue('field_legal_entity', $select_form_cid));
    //
    //    // Display list of selected legal entities for this partnership.
    //    if (!empty($selected_legal_entities)) {
    //      $form['existing_legal_entities'] = [
    //        '#type' => 'fieldset',
    //        '#attributes' => ['class' => 'form-group'],
    //        '#title' => $this->t('Existing legal entities on the primary authority register'),
    //        '#description' => $this->t('<p>Below is a list of your organisation’s legal entities currently on the primary authority register</p>'),
    //      ];
    //
    //      foreach (array_keys($selected_legal_entities) as $entity_id) {
    //        $entity = ParDataLegalEntity::load($entity_id);
    //
    //        $entity_view_builder = $this->getParDataManager()
    //          ->getViewBuilder($entity->getEntityTypeId());
    //
    //        $form['existing_legal_entities'][$entity->id()] = $entity_view_builder->view($entity, 'title');
    //      }
    //    }
    //
    //    // Hidden field to persist between reloads.
    //    $form['fields_to_display'] = [
    //      '#type' => 'hidden',
    //      '#default_value' => $fields_to_display,
    //    ];
    //
        $form['winnner'] = [
          '#type' => 'fieldset',
          '#title' => $this->t('What is a legal STE?'),
          'text' => [
            '#type' => 'markup',
            '#markup' => "<p>" . $this->t("A legal entity is any kind of individual or organisation that has legal standing. This can include a limited company or partnership, as well as other types of organisations such as trusts and charities.") . "</p>",
          ],
        ];

//    $form += $this->getLegalEntityFormElements($i);

    return $form;
  }
}
