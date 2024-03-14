<?php

namespace Drupal\example\Plugin\Field\FieldFormatter;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceLabelFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implementation of an 'entity_reference_advanced_link_formatter' formatter.
 *
 * For an entity reference field, output the entity's label as a link with the
 * option to:
 * - Add classes to the <a> element
 * - Wrap the link text in custom HTML
 * - Append icon HTML inside the <a>, but after the link text
 *
 * @FieldFormatter(
 *   id = "entity_reference_advanced_link_formatter",
 *   label = @Translation("Entity Reference Advanced Link"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceAdvancedLinkFormatter extends EntityReferenceLabelFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'text_html' => '@text',
      'icon_html' => '',
      'link_classes' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary = parent::settingsSummary();

    if (!empty($settings['link_classes'])) {
      $summary[] = $this->t('Link classes: @classes', ['@classes' => $settings['link_classes']]);
    }
    if (!empty($settings['text_html'])) {
      $summary[] = $this->t('Link text: @text', ['@text' => $settings['text_html']]);
    }
    if (!empty($settings['icon_html'])) {
      $summary[] = $this->t('Icon: @icon', ['@icon' => $settings['icon_html']]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $elements = parent::settingsForm($form, $form_state);

    $elements['link_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link classes'),
      '#default_value' => $this->getSetting('link_classes'),
      '#description' => $this->t('Classes to add to the `<a>` element.'),
      '#placeholder' => 'Ex: icon-link icon-link--variant',
    ];

    $elements['text_html'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text element'),
      '#default_value' => $this->getSetting('text_html'),
      '#description' => $this->t('The full HTML to display the link text. Use "@text" to place the link text.'),
      '#placeholder' => 'Ex: <span class="icon-link__text">@text</span>',
      '#required' => TRUE,
    ];

    $elements['icon_html'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Icon element'),
      '#default_value' => $this->getSetting('icon_html'),
      '#description' => $this->t('The full HTML for an icon to display after the link text.'),
      '#placeholder' => 'Ex: <span class="icon-link__icon"></span>',
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = parent::viewElements($items, $langcode);

    return array_map([$this, 'updateLink'], $element);
  }

  /**
   * Update the link per the formatter's configuration.
   *
   * - Add configured classes to the <a> element.
   * - Update the link's '#title' to match the configured pattern.
   *
   * @param array $link
   *   A link represented as a render array.
   *
   * @return array
   *   The link with its '#title' replaced.
   */
  protected function updateLink(array $link): array {
    $settings = $this->getSettings();

    // Add the configured classes to the <a> element.
    $link['#attributes']['class'][] = $settings['link_classes'];

    // Update the link's text to match the configured pattern.
    $link_text_template = $settings['text_html'] . $settings['icon_html'];
    $original_link_title = $link['#title'];

    $link['#title'] = new FormattableMarkup($link_text_template, [
      '@text' => $original_link_title,
    ]);

    return $link;
  }

}
