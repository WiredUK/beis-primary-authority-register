<?php

namespace Drupal\par_forms\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\par_forms\ParRedirectTrait;

/**
 * Defines the PAR Form Flow entity.
 *
 * @ConfigEntityType(
 *   id = "par_form_flow",
 *   label = @Translation("PAR Form Flow"),
 *   config_prefix = "par_form_flow",
 *   handlers = {
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\Core\Entity\EntityForm",
 *       "edit" = "Drupal\Core\Entity\EntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityConfirmFormBase"
 *     }
 *   },
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/par/form-flow/{par_entity_type}",
 *     "edit-form" = "/admin/config/par/form-flow/{par_entity_type}/edit",
 *     "delete-form" = "/admin/config/par/form-flow/{par_entity_type}/delete",
 *     "collection" = "/admin/config/par/form-flow"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "steps"
 *   }
 * )
 */
class ParFormFlow extends ConfigEntityBase {

  use ParRedirectTrait;

  /**
   * The flow ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The flow label.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this flow.
   *
   * @var string
   */
  protected $description;

  /**
   * The steps for this flow.
   *
   * @var array
   */
  protected $steps;

  /**
   * Get the description for this flow.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Get all steps in this flow.
   */
  public function getSteps() {
    return $this->steps ?: [];
  }

  /**
   * Get a step by it's index.
   *
   * @param int $index
   *   The step number that is required.
   *
   * @return array
   *   An array with values for the form_id & route
   */
  public function getStep($index) {
    return isset($this->steps[$index]) ? $this->steps[$index] : NULL;
  }

  /**
   * Get a step by the form id.
   *
   * @param string $form_id
   *   The form id to lookup.
   *
   * @return array
   *   An array with values for the form_id & route
   */
  public function getStepByFormId($form_id) {
    foreach ($this->getSteps() as $key => $step) {
      if (isset($step['form_id']) && $form_id === $step['form_id']) {
        $match = [
          'step' => $key,
        ] + $step;
      }
    }
    return isset($match) ? $match : [];
  }

  /**
   * Get all the forms in a given flow.
   *
   * @return array
   *   An array of strings representing form IDs.
   */
  public function getFlowForms() {
    $forms = [];

    foreach ($this->getSteps() as $step) {
      if (isset($step['form_id'])) {
        $forms[] = (string) $step['form_id'];
      }
    }

    return $forms;
  }

  /**
   * Get route for any given step.
   *
   * @param integer $index
   *   The step number to get a link for.
   *
   * @return Link
   *   A Drupal link object.
   */
  public function getRouteByStep($index, $link_options = []) {
    $step = $this->getStep($index);
    return isset($step['route']) ? $step['route'] : NULL;
  }

  /**
   * Get a form_id by the flow step.
   *
   * @param integer $index
   *   The step number to get a link for.
   *
   * @return array
   *   An array with values for the form_id & route
   */
  public function getFormIdByStep($index) {
    $step = $this->getStep($index);
    return isset($step['form_id']) ? $step['form_id'] : NULL;
  }

  /**
   * Get link for any given step.
   *
   * @param integer $index
   *   The step number to get a link for.
   * @param array $link_options
   *   An array of options to set on the link.
   *
   * @return Link
   *   A Drupal link object.
   */
  public function getLinkByStep($index, $link_options = []) {
    $step = $this->getStep($index);
    $route = $step['route'];
    return $this->getLinkByRoute($route, $link_options);
  }

}