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
 *   label = @Translation("Country state district Ward type"),
 *   description = @Translation("Country,state, district to ward plugin"),
 *   default_widget = "cntry_ste_dst_la_lb_wrd_widget",
 *   default_formatter = "contry_state_district_ward_formatter"
 * )
 */
class CountryStateDistrictWardType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'is_ascii' => FALSE,
      'case_sensitive' => FALSE,
      'country_label' => '',
      'state_label' => '',
      'district_label' => '',
      'lac_label' => '',
      'localbody_label' => '',
      'ward_label' => '',
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

    $properties['lac'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('LAC'))
      ->setRequired(FALSE);

    $properties['localbody'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Local Body'))
      ->setRequired(FALSE);

    $properties['ward'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Ward'))
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
        'lac' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'localbody' => [
          'type' => 'varchar',
          'length' => 255,
        ],
        'ward' => [
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
    $elements['country_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for country'),
      '#description' => $this->t('Override default label of country'),
      '#default_value' => $this->getSetting('country_label'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['state_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for state'),
      '#description' => $this->t('Override default label of state'),
      '#default_value' => $this->getSetting('state_label'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['district_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for district'),
      '#description' => $this->t('Override default label of district'),
      '#default_value' => $this->getSetting('district_label'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['lac_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for lac'),
      '#description' => $this->t('Override default label of lac'),
      '#default_value' => $this->getSetting('lac_label'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['localbody_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for localbody'),
      '#description' => $this->t('Override default label of localbody'),
      '#default_value' => $this->getSetting('localbody_label'),
      '#attributes' => [
        'placeholder' => $this->t('Enter field label'),
      ],
    ];
    $elements['ward_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label for ward'),
      '#description' => $this->t('Override default label of ward'),
      '#default_value' => $this->getSetting('ward_label'),
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
    $lac = empty($this->get('lac')->getValue());
    $localbody = empty($this->get('localbody')->getValue());
    $ward = empty($this->get('ward')->getValue());

    return $country||$state||$district||$lac||$localbody||$ward;
  }

}
