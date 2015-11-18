<?php

/**
 * @file
 *  Field Formatter that exposes the option to make a link active.
 */

namespace Drupal\active_string_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\StringFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldFormatter(
 *   id = "active_string",
 *   label = @Translation("Plain text with active option"),
 *   field_types = {
 *     "string",
 *     "uri",
 *   },
 * )
 */
class ActiveStringFormatter extends StringFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $options = parent::defaultSettings();

    $options['set_active_class'] = FALSE;
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['set_active_class'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Set the active class'),
      '#description' => $this->t('If checked, the active class will be set on this link when the current page URL is the same as the href of the link.'),
      '#default_value' => $this->getSetting('set_active_class'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    if ($this->getSetting('set_active_class')) {
      $summary[] = $this->t('Set the active class');
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    if ($this->getSetting('link_to_entity') && $this->getSetting('set_active_class')) {
      foreach ($elements as $delta => &$element) {
        $element['#options']['set_active_class'] = TRUE;
      }
    }
    return $elements;
  }
}
