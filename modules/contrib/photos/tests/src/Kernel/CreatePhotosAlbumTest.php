<?php

namespace Drupal\Tests\photos\Kernel;

use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\Entity\Node;
use Drupal\photos\PhotosAlbum;
use Drupal\user\Entity\User;

/**
 * Tests creating photo album node.
 *
 * @group photos
 */
class CreatePhotosAlbumTest extends EntityKernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'node',
    'file',
    'system',
    'field',
    'user',
    'photos',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installConfig(['system']);
    $this->installEntitySchema('file');
    $this->installEntitySchema('user');
    $this->installEntitySchema('node');
    $this->installSchema('file', ['file_usage']);
    $this->installSchema('photos', [
      'photos_album',
      'photos_image',
      'photos_comment',
      'photos_node',
      'photos_count',
    ]);

    // Make sure that a user with uid 1 exists.
    $user = User::create(['uid' => 1, 'name' => $this->randomMachineName()]);
    $user->enforceIsNew();
    $user->save();
    \Drupal::currentUser()->setAccount($user);
  }

  /**
   * Tests creating a photo album node.
   */
  public function testCreatePhotosAlbum() {
    $user = $this->createUser();

    $container = \Drupal::getContainer();
    $container->get('current_user')->setAccount($user);

    // Create a test node.
    $albumTitle = $this->randomMachineName();
    $album = Node::create([
      'type' => 'photos',
      'title' => $albumTitle,
      'language' => 'en',
    ]);
    $album->save();

    // Test PhotosAlbum::userAlbumOptions.
    $choice = new \stdClass();
    $choice->option = [$album->id() => $albumTitle];
    $testOutput[$album->id()] = $choice;
    $albumOptions = PhotosAlbum::userAlbumOptions($user->id(), 0);
    $this->assertSame($albumOptions[$album->id()]->option, $testOutput[$album->id()]->option);
  }

}
