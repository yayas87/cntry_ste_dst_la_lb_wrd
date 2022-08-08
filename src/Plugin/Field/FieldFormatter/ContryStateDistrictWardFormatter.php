<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'contry_state_district_ward_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "contry_state_district_ward_formatter",
 *   label = @Translation("Contry state district ward formatter"),
 *   field_types = {
 *     "cntry_ste_dst_la_lb_wrd_type"
 *   }
 * )
 */
class ContryStateDistrictWardFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

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
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

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
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      // Add any services you want to inject here.
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $values = $item->getValue();

      $country = $this->entityTypeManager->getStorage('countrylist')->load($values['country']);
      $state = $this->entityTypeManager->getStorage('statelist')->load($values['state']);
      $district = $this->entityTypeManager->getStorage('districtlist')->load($values['district']);
      $lac = $this->entityTypeManager->getStorage('laclist')->load($values['lac']);
      $localbody = $this->entityTypeManager->getStorage('localbodylist')->load($values['localbody']);
      $ward = $this->entityTypeManager->getStorage('wardlist')->load($values['ward']);

      $elements[$delta] = [
        '#markup' => $this->viewValue($item),
        '#theme' => 'cntry_ste_dst_la_lb_wrd',
        '#country' => !is_null($country) ? !empty($country->hasTranslation($langcode)) ? $country->getTranslation($langcode)->getName() : $country->getName() : '',
        '#state' => !is_null($state) ? !empty($state->hasTranslation($langcode)) ? $state->getTranslation($langcode)->getName() : $state->getName() : '',
        '#district' => !is_null($district) ? !empty($district->hasTranslation($langcode)) ? $district->getTranslation($langcode)->getName() : $district->getName() : '',
        '#lac' => !is_null($lac) ? !empty($lac->hasTranslation($langcode)) ? $lac->getTranslation($langcode)->getName() : $lac->getName() : '',
        '#localbody' => !is_null($localbody) ? !empty($localbody->hasTranslation($langcode)) ? $localbody->getTranslation($langcode)->getName() : $localbody->getName() : '',
        '#ward' => !is_null($ward) ? !empty($ward->hasTranslation($langcode)) ? $ward->getTranslation($langcode)->getName() : $ward->getName() : '',
      ];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->countrylist));
  }

}
