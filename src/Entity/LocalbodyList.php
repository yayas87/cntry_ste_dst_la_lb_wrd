<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\cntry_ste_dst_la_lb_wrd\LocalbodyListInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the localbodylist entity.
 *
 * @ingroup localbodylist
 *
 * The following construct is the actual definition of the entity type which
 * is read and cached. Don't forget to clear cache after changes.
 *
 * @ContentEntityType(
 *   id = "localbodylist",
 *   label = @Translation("Localbody entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\cntry_ste_dst_la_lb_wrd\Entity\Controller\LocalbodyListBuilder",
 *     "translation" = "Drupal\cntry_ste_dst_la_lb_wrd\LocalbodyListTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\cntry_ste_dst_la_lb_wrd\Form\LocalbodyListForm",
 *       "delete" = "Drupal\cntry_ste_dst_la_lb_wrd\Form\LocalbodyListDeleteForm",
 *     },
 *     "access" = "Drupal\cntry_ste_dst_la_lb_wrd\LocalbodyListAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "localbodylist",
 *   data_table = "localbodylist_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer localbodylist entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/localbodylist/{localbodylist}",
 *     "edit-form" = "/localbodylist/{localbodylist}/edit",
 *     "delete-form" = "/localbodylist/{localbodylist}/delete",
 *     "collection" = "/localbodylist/list"
 *   },
 *   field_ui_base_route = "entity.localbodylist.edit_form",
 * )
 *
 * The 'links' above are defined by their path. For core to find the
 * corresponding route, the route name must follow the correct pattern:
 *
 * entity.<entity_type>.<link_name>
 *
 * Example: 'entity.localbodylist.canonical'.
 *
 * See the routing file at localbodylist.routing.yml for the
 * corresponding implementation.
 */
class LocalbodyList extends ContentEntityBase implements LocalbodyListInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
//  public function getLac() {
//    return $this->get('lac_id')->entity;
//  }

  /**
   * {@inheritdoc}
   */
  public function getLac() {
    $lac = $this->get('lac_id')->entity;
    return $lac->getLac();
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be
   * manipulated in the GUI. The behaviour of the widgets used can be
   * determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Localbody entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Localbody entity.'))
      ->setReadOnly(TRUE);

    // Name field for the slider.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit
    // configuration.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the localbody entity.'))
      ->setTranslatable(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['lac_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('LAC'))
      ->setDescription(t('The ID of LAC of the localbody entity.'))
      ->setSetting('target_type', 'laclist')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
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

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of Localbody entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
