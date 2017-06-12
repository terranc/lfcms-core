<?php
/**
 * QueryString.php
 *
 * A Singleton PHP Class to handle URL Query String
 * return the variables as a preformated query string.
 *
 * @author Bilal Ghouri <bilalghouri@live.com>
 * @copyright 2015 Bilal Ghouri
 * @license https://raw.githubusercontent.com/bilalghouri/QueryString/master/LICENSE
 */
namespace App\Libraries;

class QueryString
{
    /**
     * Main Class Instance
     * @var null
     */

    protected static $instance = null;
    /**
     * Query String
     * @var null
     */

    private static $QueryString = null;
    /**
     * Array of Query String
     * @var array
     */

    private static $QueryStringArray = array();

    /**
     * Initiates the Query String class
     * and sets the current Query String
     * from the URL
     */

    protected function __construct()
    {
        $this->setQueryString($_SERVER['QUERY_STRING']);
    }
    /**
     * Get class singleton instance
     * @return object
     */

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
    /**
     * Set the current Query String
     * @param string $querystring
     */

    public function setQueryString($querystring)
    {
        if (empty($querystring))
            return false;
        self::$QueryString = $querystring;
        parse_str(self::$QueryString, self::$QueryStringArray);
        return true;
    }
    /**
     * [add description]
     * @param string, array $elements query string or array of keys and values
     * @param boolean $overwrite overwrite the current value in the query string with the supplied value
     */

    public function add($elements, $overwrite = true)
    {
        if (empty($elements))
            return false;
        if (!is_array($elements))
            parse_str($elements, $elements);
        foreach($elements as $key => $value)
        {
            if (isset(self::$QueryStringArray[$key]) && !$overwrite)
                continue;
            self::$QueryStringArray[$key] = $value;
        }
        $this -> __buildQuery();
        return true;
    }
    /**
     * Remove elements from the Query String
     * Accepts multiple arguments as elements
     * @param  string element to remove from the Query String
     */

    public function remove()
    {
        $elements = func_get_args();

        if (count($elements) <= 0)
            return false;

        foreach ($elements as $key => $element)
            unset(self::$QueryStringArray[$element]);
        $this -> __buildQuery();
        return true;
    }
    /**
     * Get the Query String or the array of Query Strig
     * @param  boolean $array return as array or string
     * @return string, array
     */

    public function get($array = false)
    {
        if (!empty(self::$QueryString))
            return ($array) ? self::$QueryStringArray : '?' . self::$QueryString;
        return false;
    }
    private function __buildQuery()
    {
        self::$QueryString = http_build_query(self::$QueryStringArray, false, '&', PHP_QUERY_RFC3986);
    }
    protected function __clone()
    {
        // Nothing to see here bro...
    }
    protected function __wakeup()
    {
        // Nope.. Still nothing...
    }
}
?>
