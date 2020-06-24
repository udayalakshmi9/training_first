<?php

namespace Drupal\custom_product\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the pro_categories.
 *
 * @MigrateSource(
 *   id = "pro_categories"
 * )
 */
class pro_categories extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('products_categories', 'g')
      ->fields('g', ['id', 'product_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('product category ID'),
      'movie_id' => $this->t('product ID'),
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