<?php

use Illuminate\Contracts\Translation\Translator;

if (! function_exists('trans')) {
		/**
		 * Translate the given message.
		 *
		 * @param  string  $key
		 * @param  array   $replace
		 * @param  string  $locale
		 * @return Translator|string|array|null
		 */
		function trans($id = null, $replace = [], $locale = null)
		{
			if (is_null($id)) {
				return app('translator');
			}
			
			$translated = app('translator')->trans($id, $replace, $locale);
			
			/*if (strpos($translated, 'admin.') === 0) {
				$translated = explode("admin.",$translated)[1];
			}
			else if (strpos($translated, 'frontend.') === 0) {
				$translated = explode("frontend.",$translated)[1];
			}
			else if (strpos($translated, 'validation.') === 0) {
				$translated = explode("validation.",$translated)[1];
			}*/
			
			return $translated;
		}
	}