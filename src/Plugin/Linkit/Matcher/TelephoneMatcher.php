<?php

namespace Drupal\linkit_telephone\Plugin\Linkit\Matcher;

use Drupal\Component\Utility\Html;
use Drupal\linkit\MatcherBase;
use Drupal\linkit\Suggestion\DescriptionSuggestion;
use Drupal\linkit\Suggestion\SuggestionCollection;
use Brick\PhoneNumber;

/**
 * Provides linkit matcher for telephone numbers.
 *
 * @Matcher(
 *   id = "telephone",
 *   label = @Translation("Telephone"),
 * )
 */
class TelephoneMatcher extends MatcherBase {

  /**
   * {@inheritdoc}
   */
  public function execute($string) {
    $suggestions = new SuggestionCollection();

    // Check for an e-mail address then return an e-mail match and create a
    // mail-to link if appropriate.
    if (PhoneNumber::parse($string)->isValidNumber()) {
      $suggestion = new DescriptionSuggestion();
      $suggestion->setLabel($this->t('Telephone @tel', ['@tel' => $string]))
        ->setPath('tel:' . Html::escape($string))
        ->setGroup($this->t('Telephone'))
        ->setDescription($this->t('Opens a telephone dialer to @tel', ['@tel' => $string]));

      $suggestions->addSuggestion($suggestion);
    }
    return $suggestions;
  }

}
