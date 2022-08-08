<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'cntry_ste_dst_la_lb_wrd_widget' widget.
 *
 * @FieldWidget(
 *   id = "cntry_ste_dst_la_lb_wrd_widget",
 *   label = @Translation("Country state district ward widget"),
 *   field_types = {
 *     "cntry_ste_dst_la_lb_wrd_type"
 *   }
 * )
 */
class CountryStateDistrictWardWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  /**
   * File storage for files.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Construct a MyFormatter object.
   *
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   Defines an interface for entity field definitions.
   * @param array $settings
   *   The formatter settings.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);

    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      // Add any services you want to inject here.
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [] + parent::defaultSettings();
  }

  /**
   * Gets the initial values for the widget.
   *
   * This is a replacement for the disabled default values functionality.
   *
   * @return array
   *   The initial values, keyed by property.
   */
  protected function getInitialValues() {
    $initial_values = [
      'country' => '',
      'state' => '',
      'district' => '',
      'lac' => '',
      'localbody' => '',
      'ward' => '',
    ];

    return $initial_values;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function getStates($country_id) {
    if ($country_id) {
      $query = $this->entityTypeManager->getStorage('statelist')->getQuery()
        ->condition('country_id', $country_id)
        ->sort('name', 'asc');

      $ids = $query->execute();

      $states = [];
      if (count($ids) == 1) {
        $result = $this->entityTypeManager->getStorage('statelist')->load(key($ids));
        $states[$result->id()] = $result->getName();
      }
      elseif (count($ids) > 1) {
        $results = $this->entityTypeManager->getStorage('statelist')->loadMultiple($ids);
        foreach ($results as $result) {
          $states[$result->id()] = $result->getName();
        }
      }

      return $states;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getDistricts($state_id) {

    if ($state_id) {

      $query = $this->entityTypeManager->getStorage('districtlist')->getQuery()
        ->condition('state_id', $state_id, '=')
        ->sort('name', 'asc');

      $ids = $query->execute();

      $districts = [];
      if (count($ids) == 1) {
        $result = $this->entityTypeManager->getStorage('districtlist')->load(key($ids));
        $districts[$result->id()] = $result->getName();
      }
      elseif (count($ids) > 1) {
        $results = $this->entityTypeManager->getStorage('districtlist')->loadMultiple($ids);

        foreach ($results as $result) {
          $districts[$result->id()] = $result->getName();
        }
      }

      return $districts;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getLac($district_id) {

    if ($district_id) {

      $query = $this->entityTypeManager->getStorage('laclist')->getQuery()
        ->condition('district_id', $district_id, '=')
        ->sort('name', 'asc');

      $ids = $query->execute();

      $lac = [];
      if (count($ids) == 1) {
        $result = $this->entityTypeManager->getStorage('laclist')->load(key($ids));
        $lac[$result->id()] = $result->getName();
      }
      elseif (count($ids) > 1) {
        $results = $this->entityTypeManager->getStorage('laclist')->loadMultiple($ids);

        foreach ($results as $result) {
          $lac[$result->id()] = $result->getName();
        }
      }

      return $lac;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getLocalbody($lac_id) {

    if ($district_id) {

      $query = $this->entityTypeManager->getStorage('laclist')->getQuery()
        ->condition('district_id', $district_id, '=')
        ->sort('name', 'asc');

      $ids = $query->execute();

      $lac = [];
      if (count($ids) == 1) {
        $result = $this->entityTypeManager->getStorage('laclist')->load(key($ids));
        $lac[$result->id()] = $result->getName();
      }
      elseif (count($ids) > 1) {
        $results = $this->entityTypeManager->getStorage('laclist')->loadMultiple($ids);

        foreach ($results as $result) {
          $lac[$result->id()] = $result->getName();
        }
      }

      return $lac;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $item = $items[$delta];
    $value = $item->getEntity()->isNew() ? $this->getInitialValues() : $item->toArray();

    $field_name = $this->fieldDefinition->getName();

    if (isset($form_state->getUserInput()[$field_name][$delta])) {
      $country_id = $form_state->getUserInput()[$field_name][$delta]['country'];
      $state_id = $form_state->getUserInput()[$field_name][$delta]['state'];
      $district_id = $form_state->getUserInput()[$field_name][$delta]['district'];
      $lac_id = $form_state->getUserInput()[$field_name][$delta]['lac'];
      $localbody_id = $form_state->getUserInput()[$field_name][$delta]['localbody'];
      $ward_id = $form_state->getUserInput()[$field_name][$delta]['ward'];
    }

    $country_id = $country_id ?? $value['country'] ?? NULL;
    $state_id = $state_id ?? $value['state'] ?? NULL;
    $district_id = $district_id ?? $value['district'] ?? NULL;
    $lac_id = $district_id ?? $value['lac'] ?? NULL;
    $localbody_id = $district_id ?? $value['localbody'] ?? NULL;
    $ward_id = $district_id ?? $value['ward'] ?? NULL;

    $query = $this->entityTypeManager->getStorage('countrylist')->getQuery()
      ->sort('name', 'asc');

    $ids = $query->execute();

    $countries = [];
    if (count($ids) == 1) {
      $result = $this->entityTypeManager->getStorage('countrylist')->load(key($ids));
      $countries[$result->id()] = $result->getName();
    }
    elseif (count($ids) > 1) {
      $results = $this->entityTypeManager->getStorage('countrylist')->loadMultiple($ids);
      foreach ($results as $result) {
        $countries[$result->id()] = $result->getName();
      }
    }

    $div_id = 'state-wrapper-' . $field_name . '-' . $delta;
    if ($this->fieldDefinition->getFieldStorageDefinition()->getCardinality() == 1) {
      $element += [
        '#type' => 'fieldset',
        '#attributes' => ['id' => $div_id],
      ];
    }
    $element['#attached']['library'][] = 'cntry_ste_dst_la_lb_wrd/cntry_ste_dst_la_lb_wrd.search_option';
    $element['country'] = [
      '#type' => 'select',
      '#options' => $countries,
      '#default_value' => $country_id,
      '#empty_option' => $this->t('-- Select an option --'),
      '#required' => $this->fieldDefinition->isRequired(),
      '#title' => !empty($this->getFieldSetting('country_label')) ? $this->getFieldSetting('country_label') : $this->t('Country'),
      '#delta' => $delta,
      '#validated' => TRUE,
      '#attributes' => [
        'class' => [
          'csd-country-details',
        ],
      ],
      '#ajax' => [
        'callback' => [$this, 'ajaxFillState'],
        'event' => 'change',
        'wrapper' => $div_id,
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Searching states...'),
        ],
      ],
    ];

    if ($country_id) {
      $element['state'] = [
        '#type' => 'select',
        '#default_value' => $state_id,
        '#options' => $this->getStates($country_id),
        '#empty_option' => $this->t('-- Select an option --'),
        '#required' => $this->fieldDefinition->isRequired(),
        '#title' => !empty($this->getFieldSetting('state_label')) ? $this->getFieldSetting('state_label') : $this->t('State'),
        '#active' => FALSE,
        '#delta' => $delta,
        '#validated' => TRUE,
        '#attributes' => [
          'class' => [
            'csd-state-details',
          ],
        ],
        '#ajax' => [
          'callback' => [$this, 'ajaxFillState'],
          'event' => 'change',
          'wrapper' => $div_id,
          'progress' => [
            'type' => 'throbber',
            'message' => $this->t('Searching districts...'),
          ],
        ],
      ];
    }


    if ($state_id) {
      $element['district'] = [
        '#type' => 'select',
        '#default_value' => $district_id,
        '#options' => $this->getDistricts($state_id),
        '#empty_option' => $this->t('-- Select an option --'),
        '#required' => $this->fieldDefinition->isRequired(),
        '#title' => !empty($this->getFieldSetting('district_label')) ? $this->getFieldSetting('district_label') : $this->t('District'),
        '#active' => FALSE,
        '#delta' => $delta,
        '#validated' => TRUE,
        '#attributes' => [
          'class' => [
            'csd-district-details',
          ],
        ],
        '#ajax' => [
          'callback' => [$this, 'ajaxFillState'],
          'event' => 'change',
          'wrapper' => $div_id,
          'progress' => [
            'type' => 'throbber',
            'message' => $this->t('Searching LAC...'),
          ],
        ],
      ];
    }

    if ($district_id) {
      $element['lac'] = [
        '#type' => 'select',
        '#default_value' => $lac_id,
        '#options' => $this->getLac($district_id),
        '#empty_option' => $this->t('-- Select an option --'),
        '#required' => $this->fieldDefinition->isRequired(),
        '#title' => !empty($this->getFieldSetting('lac_label')) ? $this->getFieldSetting('lac_label') : $this->t('lac'),
        '#active' => FALSE,
        '#delta' => $delta,
        '#validated' => TRUE,
        '#attributes' => [
          'class' => [
            'csd-lac-details',
          ],
        ],
        '#ajax' => [
          'callback' => [$this, 'ajaxFillState'],
          'event' => 'change',
          'wrapper' => $div_id,
          'progress' => [
            'type' => 'throbber',
            'message' => $this->t('Searching Localbody...'),
          ],
        ],
      ];
    }

    if ($localbody_id) {
      $element['ward'] = [
        '#type' => 'select',
        '#default_value' => $ward_id,
        '#options' => $this->getLac($localbody_id),
        '#empty_option' => $this->t('-- Select an option --'),
        '#required' => $this->fieldDefinition->isRequired(),
        '#title' => !empty($this->getFieldSetting('district_label')) ? $this->getFieldSetting('district_label') : $this->t('District'),
        '#validated' => TRUE,
        '#attributes' => [
          'class' => [
            'csd-district-details',
          ],
        ],
      ];
    }

    return $element;
  }

  /**
   * Call the function that consume the webservice.
   *
   * @param array $form
   *   A form that be modified.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The values of the form.
   *
   * @return array
   *   The form modified
   */
  public function ajaxFillState(array $form, FormStateInterface $form_state) {
    $element = $form_state->getTriggeringElement();

    $delta = $element['#delta'];

    $field_name = $this->fieldDefinition->getName();
    $form = $form[$field_name];

    unset($form['widget'][$delta]['_weight']);

    return $form['widget'][$delta];
  }

}
