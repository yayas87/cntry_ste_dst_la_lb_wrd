<?php

namespace Drupal\cntry_ste_dst_la_lb_wrd\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the wardlist entity edit forms.
 *
 * @ingroup cntry_ste_dst_la_lb_wrd
 */
class WardListForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\cntry_ste_dst_la_lb_wrd\Entity\WardList $entity */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    $form['langcode'] = [
      '#title' => $this->t('Language'),
      '#type' => 'language_select',
      '#default_value' => $entity->language()->getId(),
      '#languages' => Language::STATE_ALL,
      '#access' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.wardlist.collection');
    $entity = $this->getEntity();
    $entity->save();
  }

}
