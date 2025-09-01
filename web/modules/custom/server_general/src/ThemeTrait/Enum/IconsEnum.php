<?php

declare(strict_types=1);

namespace Drupal\server_general\ThemeTrait\Enum;

/**
 * Enum for color options used in theme wrappers.
 */
enum IconsEnum: string
{
  case Email = 'email';
  case Phone = 'phone';
  case Default = 'default';
}
