<?php

namespace Drupal\Tests\photos\Functional;

use Drupal\node\Entity\Node;
use Drupal\photos\PhotosAlbum;
use Drupal\photos\PhotosImage;
use Drupal\Tests\BrowserTestBase;

/**
 * Test creating a new album, adding an image and updating the image.
 *
 * @group photos
 */
class AddPhotosAlbumImageTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'node',
    'file',
    'image',
    'comment',
    'photos',
  ];

  /**
   * The user account for testing.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Create user with permissions to edit own photos.
    $this->account = $this->drupalCreateUser([
      'view photo',
      'create photo',
      'edit own photo',
      'delete own photo',
    ]);
    $this->drupalLogin($this->account);
  }

  /**
   * Test adding an image to an album and accessing the image edit page.
   */
  public function testAccessPhotosImageEditForm() {

    // Create a test album node.
    $album = Node::create([
      'type' => 'photos',
      'title' => $this->randomMachineName(),
    ]);
    $album->save();

    // Get test image file.
    $testPhotoUri = drupal_get_path('module', 'photos') . '/tests/images/photos-test-picture.jpg';
    $fileSystem = \Drupal::service('file_system');

    // Post image upload form.
    $edit = [
      'files[images_0]' => $fileSystem->realpath($testPhotoUri),
      'title_0' => 'Test photo title',
      'des_0' => 'Test photos description',
    ];
    $this->drupalPostForm('node/' . $album->id() . '/photos', $edit, t('Confirm upload'));

    // Get album images.
    $photosAlbum = new PhotosAlbum($album->id());
    $albumImages = $photosAlbum->getImages(1);
    $imageFid = $albumImages[0]->fid;

    // Access image edit page.
    $this->drupalGet('photos/image/' . $imageFid . '/edit');
    $this->assertSession()->statusCodeEquals(200);

    // Post image edit form.
    $edit = [
      'title' => 'Test new title',
    ];
    $this->drupalPostForm(NULL, $edit, t('Confirm changes'));

    // Confirm that image title has been updated.
    $photosImage = new PhotosImage($imageFid);
    $photosImageData = $photosImage->load();
    $this->assertEquals($edit['title'], $photosImageData->title);

  }

}
