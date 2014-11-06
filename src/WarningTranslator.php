<?php namespace Tremby\WarningTranslator;

use Illuminate\Translation\Translator;

class WarningTranslator extends Translator {

	/**
	 * Get the translation for the given key. Log a warning if we have to fall 
	 * back to the fallback locale and log an error if the fallback doesn't 
	 * exist either.
	 *
	 * @param  string  $key
	 * @param  array   $replace
	 * @param  string  $locale
	 * @return string
	 */
	public function get($key, array $replace = array(), $locale = null) {
		list($namespace, $group, $item) = $this->parseKey($key);

		// Don't log issues if looking for custom validation messages
		$ignore = strpos($key, 'validation.custom.') === 0;

		$locales = $this->parseLocale($locale);
		$tried = array();
		foreach ($locales as $locale) {
			$this->load($namespace, $group, $locale);
			$line = $this->getLine(
				$namespace, $group, $locale, $item, $replace
			);
			if ($line !== null) {
				break;
			}
			$tried[] = $locale;
		}

		if ($line === null) {
			// Not found
			if (!$ignore) {
				\Log::error(
					"No translation found in any locale for key '$key'; "
					. "rendering the key instead "
					. "(tried " . implode(", ", $tried) . ")"
				);
			}
			return $key;
		}

		if (count($tried)) {
			if (!$ignore) {
				\Log::warning(
					"Fell back to $locale locale for translation key '$key' "
					. "(tried " . implode(", ", $tried) . ")"
				);
			}
		}

		return $line;
	}

}
