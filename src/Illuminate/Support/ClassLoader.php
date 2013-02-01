<?php namespace Illuminate\Support;

class ClassLoader {

	/**
	 * The registered directories.
	 *
	 * @var array
	 */
	protected static $directories = array();

	/**
	 * Indicates if a ClassLoader has been registered.
	 *
	 * @var bool
	 */
	protected static $registered = false;

	/**
	 * Load the given class file.
	 *
	 * @param  string  $class
	 * @return void
	 */
	public static function load($class)
	{
		$class = static::normalizeClass($class);

		foreach (static::$directories as $directory)
		{
			if (file_exists($path = $directory.'/'.$class))
			{
				require_once $path;

				return true;
			}
		}
	}

	/**
	 * Get the normal file name for a class.
	 *
	 * @param  string  $class
	 * @return string
	 */
	public static function normalizeClass($class)
	{
		if ($class[0] == '\\') $class = substr($class, 1);

		return str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
	}

	/**
	 * Register the given class loader on the auto-loader stack.
	 *
	 * @return void
	 */
	public static function register()
	{
		if ( ! static::$registered)
		{
			spl_autoload_register(array('\Illuminate\Support\ClassLoader', 'load'));

			static::$registered = true;
		}
	}

	/**
	 * Add directories to the class loader.
	 *
	 * @param  array  $directories
	 * @return void
	 */
	public static function addDirectories(array $directories)
	{
		static::$directories = array_merge(static::$directories, $directories);
		
		static::$directories = array_unique(static::$directories);
	}

}