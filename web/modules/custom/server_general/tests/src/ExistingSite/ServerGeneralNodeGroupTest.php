<?php

namespace Drupal\Tests\server_general\ExistingSite;

use Symfony\Component\HttpFoundation\Response;

/**
 * Test 'group' content type.
 */
class ServerGeneralNodeGroupTest extends ServerGeneralNodeTestBase {

  /**
   * {@inheritdoc}
   */
  public function getEntityBundle(): string {
    return 'group';
  }

  /**
   * {@inheritdoc}
   */
  public function getRequiredFields(): array {
    return [
    ];
  }
  
  /**
   * {@inheritdoc}
  */
  public function getOptionalFields(): array {
    return [
      'field_featured_image',
      'field_tags',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function testGroup() {
    $author = $this->createUser();

    // Create Group node with image.
    $node = $this->createNode([
      'title' => 'Test Group',
      'type' => 'group',
      'uid' => $author->id(),
      'body' => 'This is the text of the body field.',
      'field_featured_image' => ['target_id' => 1],
      'moderation_state' => 'published',
    ]);
    $node->setPublished()->save();

    $url = $node->toUrl();

    $this->assertEquals($author->id(), $node->getOwnerId());

    // We can see the You are the manager when logged-in as group author.
    $this->drupalLogin($author);
    $this->drupalUserIsLoggedIn($author);
    $this->drupalGet($url);
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
    $this->assertSession()->elementExists('css', '.group');

    // We can see the Subscribe button.
    $user = $this->createUser();
    $user->save();
    $this->drupalLogin($user);
    $this->drupalGet($url);
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
    $this->assertSession()->linkByHrefExists("/group/node/{$node->id()}/subscribe");
  }

}
