<?php
namespace Drupal\cutom_product\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the pro.
 *
 * @MigrateSource(
 *   id = "pro"
 * )
 */
class pro extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('products', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('product ID'),
      'name' => $this->t('product Name'),
      'description' => $this->t('product Description'),
      'products_categories' => $this->t('products_categories'),
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
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $genres = $this->select('products_categories', 'g')
      ->fields('g', ['id'])
      ->condition('product_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('products_categories', $genres);
    return parent::prepareRow($row);
  }
}