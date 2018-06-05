<?php

namespace Drupal\par_data\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;

/**
 * Defines the par_data_message entity.
 *
 * @ingroup par_data
 *
 * @ContentEntityType(
 *   id = "par_data_message",
 *   label = @Translation("PAR Messages"),
 *   label_collection = @Translation("PAR Messages"),
 *   label_singular = @Translation("PAR Message"),
 *   label_plural = @Translation("PAR Messages"),
 *   label_count = @PluralTranslation(
 *     singular = "@count message",
 *     plural = "@count messages"
 *   ),
 *   bundle_label = @Translation("PAR Message type"),
 *   handlers = {
 *     "storage" = "Drupal\par_data\ParDataStorage",
 *     "storage_schema" = "Drupal\trance\TranceStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\trance\TranceListBuilder",
 *     "views_data" = "Drupal\par_data\Views\ParDataViewsData",
 *     "form" = {
 *       "default" = "Drupal\par_data\Form\ParDataForm",
 *       "add" = "Drupal\par_data\Form\ParDataForm",
 *       "edit" = "Drupal\par_data\Form\ParDataForm",
 *       "delete" = "Drupal\par_data\Form\ParDataDeleteForm",
 *     },
 *     "access" = "Drupal\par_data\Access\ParDataAccessControlHandler",
 *   },
 *   base_table = "par_messages",
 *   data_table = "par_messages_field_data",
 *   revision_table = "par_messages_revision",
 *   revision_data_table = "par_messages_field_revision",
 *   admin_permission = "administer par_data_message entities",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status"
 *   },
 *   links = {
 *     "collection" = "/admin/content/par_data/par_data_message",
 *     "canonical" = "/admin/content/par_data/par_data_message/{par_data_message}",
 *     "edit-form" = "/admin/content/par_data/par_data_message/{par_data_message}/edit",
 *     "delete-form" = "/admin/content/par_data/par_data_message/{par_data_message}/delete"
 *   },
 *   bundle_entity_type = "par_data_message_type",
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.par_data_message_type.edit_form"
 * )
 */
class ParDataMessage extends ParDataEntity {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Message title.
    $fields['message_title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('Title of the message.'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 1000,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Message details.
    $fields['message_details'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Summary'))
      ->setDescription(t('Details about this message.'))
      ->addConstraint('par_required')
      ->setRevisionable(TRUE)
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 2,
        'settings' => [
          'rows' => 25,
        ],
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Message status.
    $fields['message_status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Message Status'))
      ->setDescription(t('The status of the message.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 3,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Message notes.
    $fields['message_notes'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Message Notes'))
      ->setDescription(t('Notes about this message.'))
      ->addConstraint('par_required')
      ->setRevisionable(TRUE)
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 4,
        'settings' => [
          'rows' => 25,
        ],
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Message Referral notes.
    $fields['message_referral_notes'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Referral Notes'))
      ->setDescription(t('Referral notes.'))
      ->addConstraint('par_required')
      ->setRevisionable(TRUE)
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 7,
        'settings' => [
          'rows' => 25,
        ],
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    // Message Documents.
    $fields['document'] = BaseFieldDefinition::create('file')
      ->setLabel(t('Document'))
      ->setDescription(t('Documents relating to the message.'))
      ->addConstraint('par_required')
      ->setRevisionable(TRUE)
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setSettings([
        'target_type' => 'file',
        'uri_scheme' => 's3private',
        'max_filesize' => '20 MB',
        'file_extensions' => 'jpg jpeg gif png tif pdf txt rdf doc docx odt xls xlsx csv ods ppt pptx odp pot potx pps',
        'file_directory' => 'documents/message',
      ])
      ->setDisplayOptions('form', [
        'weight' => 6,
        'default_widget' => "file_generic",
        'default_formatter' => "file_default",
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }
}
