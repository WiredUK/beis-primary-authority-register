<?php

namespace Drupal\par_data\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\UserInterface;

/**
 * Defines the par_data_person entity.
 *
 * @ingroup par_data
 *
 * @ContentEntityType(
 *   id = "par_data_person",
 *   label = @Translation("PAR Person"),
 *   label_collection = @Translation("PAR People"),
 *   label_singular = @Translation("PAR Person"),
 *   label_plural = @Translation("PAR People"),
 *   label_count = @PluralTranslation(
 *     singular = "@count person",
 *     plural = "@count people"
 *   ),
 *   bundle_label = @Translation("PAR Person type"),
 *   handlers = {
 *     "storage" = "Drupal\trance\TranceStorage",
 *     "storage_schema" = "Drupal\trance\TranceStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\trance\TranceListBuilder",
 *     "views_data" = "Drupal\par_data\Views\ParDataViewsData",
 *     "form" = {
 *       "default" = "Drupal\trance\Form\ParEntityForm",
 *       "add" = "Drupal\trance\Form\ParEntityForm",
 *       "edit" = "Drupal\trance\Form\ParEntityForm",
 *       "delete" = "Drupal\trance\Form\TranceDeleteForm",
 *     },
 *     "access" = "Drupal\par_data\Access\ParDataAccessControlHandler",
 *   },
 *   base_table = "par_people",
 *   data_table = "par_people_field_data",
 *   revision_table = "par_people_revision",
 *   revision_data_table = "par_people_field_revision",
 *   admin_permission = "administer par_data_person entities",
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
 *     "collection" = "/admin/content/par_data/par_data_person",
 *     "canonical" = "/admin/content/par_data/par_data_person/{par_data_person}",
 *     "edit-form" = "/admin/content/par_data/par_data_person/{par_data_person}/edit",
 *     "delete-form" = "/admin/content/par_data/par_data_person/{par_data_person}/delete"
 *   },
 *   bundle_entity_type = "par_data_person_type",
 *   permission_granularity = "bundle",
 *   field_ui_base_route = "entity.par_data_person_type.edit_form"
 * )
 */
class ParDataPerson extends ParDataEntity {

  /**
   * Get the User account.
   */
  public function getUserAccount() {
    $entities = $this->get('user_account')->referencedEntities();
    return $entities ? current($entities) : NULL;
  }

  /**
   * Get the User account.
   *
   * @param boolean $link_up
   *   Whether or not to link up the accounts if any are found that aren't already linked.
   *
   * @return array
   *   Returns any other PAR Person records if found.
   */
  public function getSimilarPeople($link_up = TRUE) {
    $account = $this->getUserAccount();

    // Link this entity to the Drupal User if one exists.
    if (!$account && $link_up) {
      $account = $this->linkAccounts();
    }

    // Return all similar people.
    if ($account) {
      $accounts = \Drupal::entityTypeManager()
        ->getStorage($this->getEntityTypeId())
        ->loadByProperties(['email' => $account->get('mail')->getString()]);
    }

    return isset($accounts) ? $accounts : [];
  }

  /**
   * Get the User accounts that have the same email as this PAR Person.
   *
   * @return mixed|null
   *   Returns a Drupal User account if found.
   */
  public function lookupUserAccount() {
    $entities = \Drupal::entityTypeManager()
      ->getStorage('user')
      ->loadByProperties(['mail' => $this->get('email')->getString()]);
    return $entities ? current($entities) : NULL;
  }

  /**
   * Link up the PAR Person to a Drupal User account.
   *
   * @param UserInterface $account
   *   An optional user account to lookup.
   *
   * @return bool|int
   *   If there was an account to link to, that wasn't already linked to.
   */
  public function linkAccounts(UserInterface $account = NULL) {
    $saved = FALSE;
    if (!$account) {
      $account = $this->lookupUserAccount();
    }
    $current_user_account = current($this->get('user_account')->referencedEntities());
    if ($account && (!$current_user_account || !$account->id() !== $current_user_account->id())) {
      $this->set('user_account', $account);
      $saved = $this->save();
    }
    return $saved ? $account : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // List the Drupal user account the user is related to.
    $fields['user_account'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User Account'))
      ->setDescription(t('The user account that this entity is linked to.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Title.
    $fields['salutation'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of this Person.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    // Name.
    $fields['person_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Person.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 500,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    // Work Phone.
    $fields['work_phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Work Phone'))
      ->setDescription(t('The work phone of this Person.'))
      ->setTranslatable(TRUE)
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
      ->setDisplayConfigurable('view', TRUE);

    // Mobile Phone.
    $fields['mobile_phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mobile Phone'))
      ->setDescription(t('The mobile phone of this Person.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    // Email.
    $fields['email'] = BaseFieldDefinition::create('string')
      ->setLabel(t('E-mail'))
      ->setDescription(t('The e-mail address of this Person.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 500,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
