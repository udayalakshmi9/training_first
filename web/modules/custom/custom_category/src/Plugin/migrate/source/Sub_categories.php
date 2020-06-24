<?php

namespace Drupal\custom_category\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the sub_categories.
 *
 * @MigrateSource(
 *   id = "sub_categories"
 * )
 */
class Sub_categories extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('sub_categories', 'g')
      ->fields('g', ['id', 'category_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('sub category ID'),
      'category_id' => $this->t('category ID'),
      'name' => $this->t('category name'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}