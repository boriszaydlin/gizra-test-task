<?php

declare(strict_types=1);

namespace Drupal\server_general\ThemeTrait;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\intl_date\IntlDate;
use Drupal\server_general\ThemeTrait\Enum\ColorEnum;
use Drupal\server_general\ThemeTrait\Enum\FontSizeEnum;
use Drupal\server_general\ThemeTrait\Enum\FontWeightEnum;
use Drupal\server_general\ThemeTrait\Enum\LineClampEnum;
use Drupal\server_general\ThemeTrait\Enum\TextColorEnum;

/**
 * Helper methods for rendering Group Teaser elements.
 */
trait GroupTeasersThemeTrait {

  use ButtonThemeTrait;
  use ElementLayoutThemeTrait;
  use InnerElementLayoutThemeTrait;
  use LinkThemeTrait;
  use TitleAndLabelsThemeTrait;

  /**
   * Build Group teasers element.
   *
   * @param string $title
   *   The title.
   * @param array $body
   *   The body render array.
   * @param array $items
   *   The group teasers array rendered with
   *   `ElementLayoutThemeTrait::buildElementLayoutTitleBodyAndItems`.
   *
   * @return array
   *   Render array.
   */
  protected function buildElementGroupTeasers(string $title, array $body, array $items): array {
    return $this->buildElementLayoutTitleBodyAndItems(
      $title,
      $body,
      $items,
    );
  }

  /**
   * Build "Group Teaser" element.
   *
   * @param array $image
   *   The image render array.
   * @param string $title
   *   The title.
   * @param \Drupal\Core\Url $url
   *   The URL to link to.
   * @param array $summary
   *   Summary of the search result.
   * @param int $timestamp
   *   The timestamp.
   *
   * @return array
   *   Render array.
   */
  protected function buildElementGroupTeaser(array $image, string $title, Url $url, array $summary, int $timestamp): array {
    $elements = [];

    // Labels.
    $element = $this->buildLabelsFromText([$this->t('Group')]);
    $elements[] = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::Sm);

    // Date.
    $element = IntlDate::formatPattern($timestamp, 'short');
    $element = $this->wrapTextColor($element, TextColorEnum::Gray);
    $elements[] = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::Sm);

    // Title as link.
    $element = $this->buildLink($title, $url, ColorEnum::DarkGray);
    $element = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::LG);
    $elements[] = $this->wrapTextFontWeight($element, FontWeightEnum::Bold);

    // Body teaser.
    $elements[] = $this->wrapTextLineClamp($summary, LineClampEnum::Four);

    return $this->buildInnerElementLayoutWithImage($url, $image, $elements);
  }

  /**
   * Build "Featured Group Teaser" element with image on the side.
   *
   * @param array $image
   *   The image render array.
   * @param string $title
   *   The title.
   * @param \Drupal\Core\Url $url
   *   The URL to link to.
   * @param array $summary
   *   Summary of the search result.
   * @param int $timestamp
   *   The timestamp.
   *
   * @return array
   *   Render array.
   */
  protected function buildElementGroupTeaserFeatured(array $image, string $title, Url $url, array $summary, int $timestamp): array {
    $elements = [];

    // Labels.
    $element = $this->buildLabelsFromText([$this->t('Group')]);
    $elements[] = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::Sm);

    // Date.
    $element = ['#markup' => IntlDate::formatPattern($timestamp, 'short')];
    $element = $this->wrapTextColor($element, TextColorEnum::Gray);
    $elements[] = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::Sm);

    // Title as link.
    $element = $this->buildLink($title, $url, ColorEnum::DarkGray);
    $element = $this->wrapTextResponsiveFontSize($element, FontSizeEnum::LG);
    $elements[] = $this->wrapTextFontWeight($element, FontWeightEnum::Bold);

    // Body teaser.
    $elements[] = $this->wrapTextLineClamp($summary, LineClampEnum::Four);

    // Read more button.
    $link = Link::fromTextAndUrl($this->t('Explore further'), $url);
    $elements[] = $this->buildButtonSecondary($link);

    return $this->buildInnerElementLayoutWithImageHorizontal($url, $image, $elements);
  }

}
