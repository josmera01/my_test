<?php

namespace Drupal\my_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ViewsMyTestController.
 */
class ViewsMyTestController extends ControllerBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Get.
   *
   * @return string
   *   Return Hello string.
   */
  public function get() {
    $headers = [
      'id' => $this->t('id'),
      'title' => $this->t('Name'),
    ];
    // Build row.
    $data = $this->database->select('myusers', 'u')->fields('u', ['id', 'name'])->execute();;

    // Get all the results
    $results = $data->fetchAll(\PDO::FETCH_OBJ);

    foreach ($results as $row) {
      $rows[] = [
        'id' => [
          'data' => $row->id,
        ],
        'title' => [
          'data' => $row->name,
        ],
      ];
    };

    // Return render array for table.
    return array(
      '#theme' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
    );
  }

}
