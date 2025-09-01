<?php

declare(strict_types=1);

namespace Drupal\server_general\ThemeTrait;

use Drupal\server_general\ThemeTrait\Enum\AlignmentEnum;
use Drupal\server_general\ThemeTrait\Enum\FontSizeEnum;
use Drupal\server_general\ThemeTrait\Enum\FontWeightEnum;
use Drupal\server_general\ThemeTrait\Enum\TextColorEnum;
use Drupal\server_general\ThemeTrait\Enum\ColorEnum;
use Drupal\server_general\ThemeTrait\Enum\WidthEnum;
use Drupal\server_general\ThemeTrait\Enum\LineClampEnum;
use Drupal\server_general\ThemeTrait\Enum\UnderlineEnum;
use Drupal\server_general\ThemeTrait\Enum\IconsEnum;

/**
 * Helper methods for rendering People/Person Teaser elements.
*/
trait PersonCardsThemeTrait {
  
  use ElementLayoutThemeTrait;
  use ElementWrapThemeTrait;
  use InnerElementLayoutThemeTrait;
  use CardThemeTrait;
  use LineSeparatorThemeTrait;
  use LinkThemeTrait;

  /**
   * Build People cards element.
   *
   * @param string $title
   *   The title.
   * @param array $body
   *   The body render array.
   * @param array $items
   *   The render array built with
   *   `ElementLayoutThemeTrait::buildElementLayoutTitleBodyAndItems`.
   *
   * @return array
   *   The render array.
   */
  protected function buildElementPersonCards(string $title, array $body, array $items): array {
    return $this->buildElementLayoutTitleBodyAndItems(
      $title,
      $body,
      $this->buildCards($items),
    );
  }

  /**
   * Build a Person teaser.
   *
   * @param string $image_url
   *   The image Url.
   * @param string $alt
   *   The image alt.
   * @param string $name
   *   The name.
   * @param string|null $subtitle
   *   Optional; The subtitle (e.g. work title).
   *
   * @return array
   *   The render array.
   */
  protected function buildElementPersonCard(string $image_url, string $alt, string $name, ?string $subtitle = NULL, ?string $role = NULL, ?string $email = NULL, ?string $phone = NULL): array {
    $elements = [];
    $text_elements = [];
    $bottom_elements = [];

    $element = $this->buildLineSeparator();
    $elements[] = $this->wrapContainerMaxWidth($element, WidthEnum::Lg);
    
    // Image
    $element = [
      '#theme' => 'image',
      '#uri' => $image_url,
      '#alt' => $alt,
      '#width' => 100,
    ];

    $elements[] = $this->wrapRoundedCornersFull($element);


    $element = $this->wrapTextFontWeight($name, FontWeightEnum::Medium);
    $text_elements[] = $this->wrapTextCenter($element);

    if ($subtitle) {
      $element = $this->wrapTextResponsiveFontSize($subtitle, FontSizeEnum::Sm);
      $element = $this->wrapTextCenter($element);
      $text_elements[] = $this->wrapTextColor($element, TextColorEnum::Gray);
    } else {
      $element = $this->buildLineSeparator();
      $text_elements[] = $this->wrapContainerMaxWidth($element, WidthEnum::Lg);      
    }

    if ($role) {
      $element = $this->wrapTextResponsiveFontSize($role, FontSizeEnum::Sm);
      $element = $this->wrapTextCenter($element);
      $text_elements[] = $this->wrapTextColorBadge($element, TextColorEnum::Green);
    } else {
      $element = $this->buildLineSeparator();
      $text_elements[] = $this->wrapContainerMaxWidth($element, WidthEnum::Lg);
    }

    if ($email) {
      $bottom_elements[] = $this->buildLinkWithIcon(
        'Email',
        \Drupal\Core\Url::fromUri("mailto:$email"),
        $color = ColorEnum::DarkGray,
        $underline = UnderlineEnum::Hover,
        $icon = IconsEnum::Email);
    }
    if ($phone) {
      $bottom_elements[] = $this->buildLinkWithIcon(
        'Phone',
        \Drupal\Core\Url::fromUri("tel:$phone"),
        $color = ColorEnum::DarkGray,
        $underline = UnderlineEnum::Hover,
        $icon = IconsEnum::Phone
      );
    }
    
    // Combine all text elements in a vertical stack with small spacing.
    $elements[] = $this->wrapContainerVerticalSpacingTiny($text_elements, AlignmentEnum::Center);
    
    if (!empty($bottom_elements)) {
      $elements[] = $this->wrapContainerActions($bottom_elements);
    }

    return $this->buildInnerElementLayoutCentered($elements, $padding = false);
  }

}
