<?php

namespace Drupal\par_member_upload_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\file\Entity\File;

//use Drupal\file\FileInterface;
use Drupal\par_partnership_flows\ParPartnershipFlowsTrait;

/**
 * The partnership form for the premises details.
 */
class ParMemberUploadFlowsForm extends ParBaseForm {

  use ParPartnershipFlowsTrait;

  protected $pageTitle = 'Upload First';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'par_member_upload_csv';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ParDataPartnership $par_data_partnership = NULL) {

//    $form['warning'] = [
//      '#theme' => 'gds_warning',
//      '#markup' => 'This operation will erase any existing list of members. If you are unsure, please click the ‘Cancel’ link (below) and contact the Help Desk.',
//    ];

    // Multiple file field.
    $form['csv'] = [
      '#type' => 'managed_file',
      '#title' => t('Upload a list of members'),
      '#description' => t('Upload your CSV file, be sure to make sure the'
        . ' information is accurate so that it can all be processed'),
      '#upload_location' => 's3private://member-csv/',
      '#multiple' => FALSE,
      '#required' => TRUE,
      '#default_value' => $this->getFlowDataHandler()->getDefaultValues("csv"),
      '#upload_validators' => [
        'file_validate_extensions' => [
          0 => 'csv',
        ]
      ]
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    parent::submitForm($form, $form_state);

    $rows = [];

    // Process uploaded csv file.
    if ($csv = $this->getFlowDataHandler()->getTempDataValue('csv')) {

      // Load the submitted file and process the data.
      $files = File::loadMultiple($csv);
      foreach ($files as $file) {
        // Save processed row data in an array.
        $rows[] = $this->getParDataManager()->processCsvFile($file, $rows);
      }

      // Save the data in the User's temp private store for later processing.
      if (!empty($rows)) {
        $this->getFlowDataHandler()->setTempDataValue('coordinated_members', $rows);
      }
    }

    // Display success message.
    drupal_set_message('CSV file successfully uploaded.');

    parent::submitForm($form, $form_state);
  }

}
