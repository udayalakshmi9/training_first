<?php
namespace Drupal\custom_category\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the categories.
 *
 * @MigrateSource(
 *   id = "categories"
 * )
 */
class Categories extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('categories', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('category ID'),
      'name' => $this->t('category Name'),
      'description' => $this->t('category Description'),
      'sub_categories' => $this->t('sub_categories'),
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
    $genres = $this->select('sub_categories', 'g')
      ->fields('g', ['id'])
      ->condition('category_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('sub_categories', $genres);
    return parent::prepareRow($row);
  }
}