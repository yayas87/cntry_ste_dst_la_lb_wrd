<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'cntry_ste_dst_la_lb_wrd_type' field type.
 *
 * @FieldType(
 *   id = "cntry_ste_dst_la_lb_wrd_type",
 *   label = @Translation("Country state district type"),
 *   description = @Translation("Country ,state and district plugin"),
 *   default_widget = "cntry_ste_dst_la_lb_wrd_widget",
 *   default_formatter = "contry_state_district_formatter"
 * )
 */
class CountryStateDistrictType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'is_ascii' => FALSE,
      'case_sensitive' => FALSE,
      'country_lable' => '',
      'state_lable' => '',
      'district_lable' => '',
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['country'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Country'))
      ->setRequired(FALSE);

    $properties['state'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('State'))
      ->setRequired(FALSE);

    $properties['district'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('District'))
      ->setRequired(FALSE);

    $properties['locate'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Locate'))
      ->setRequired(FALSE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'country' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'state' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'district' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $values = [];

    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];
    $elements['country_lable'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for country'),
      '#description' => $this->t('Override default label of country'),
      '#default_value' => $this->getSetting('country_lable'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['state_lable'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for state'),
      '#description' => $this->t('Override default label of state'),
      '#default_value' => $this->getSetting('state_lable'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['district_lable'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for district'),
      '#description' => $this->t('Override default label of district'),
      '#default_value' => $this->getSetting('district_lable'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $country = empty($this->get('country')->getValue());
    $state = empty($this->get('state')->getValue());
    $district = empty($this->get('district')->getValue());

    return $country||$state||$district;
  }

}
