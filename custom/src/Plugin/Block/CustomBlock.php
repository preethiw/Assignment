<?php

namespace Drupal\Custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a Custom Block.
 *
 * @Block(
 *   id = "custom_dynamic_block",
 *   admin_label = @Translation("Custom block which shows tiles"),
 *   category = @Translation("Custom"),
 * )
 */
class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new MyBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => isset($config['title']) ? $config['title'] : '',
      '#required' => TRUE,
    ];

    $form['image'] = [
      '#type' => 'managed_file',
      '#upload_location' => 'public://images/',
      '#title' => $this->t('Image'),
      '#description' => $this->t("Please upload an image"),
      '#default_value' => isset($config['image']) ? $config['image'] : '',
      '#required' => TRUE,
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
        'file_validate_size' => [25600000],
      ],
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => isset($config['description']) ? $config['description'] : '',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['title'] = $values['title'];
    $this->configuration['description'] = $values['description'];
    $fid = $values['image'][0];
    if (!empty($fid)) {
      // $file = File::load($fid);
      $fileStorage = $this->entityTypeManager->getStorage('file');
      $file = $fileStorage->load($fid);
      $file->setPermanent();
      $file->save();
    }
    $this->configuration['image'] = $values['image'];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();
    $title = isset($config['title']) ? $config['title'] : '';
    $description = isset($config['description']) ? $config['description'] : '';

    $image = $config['image'];
    if (!empty($image[0])) {
      // $file = File::load($image[0])
      $fileStorage = $this->entityTypeManager->getStorage('file');
      $file = $fileStorage->load($image[0]);
      // $file = $this->fileStorage->load($image[0]);.
      $image = [
        '#theme' => 'image',
        '#uri' => $file->getFileUri(),
      ];
    }

    return [
      '#theme' => 'custom_dy_block',
      '#title' => $title,
      '#description' => $description,
      '#image' => $image,
    ];
  }

}
