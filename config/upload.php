<?php
return [
    'library' => env('UPLOAD_LIBRARY', 'gd'),

    'quality' => 90,

    /*
     * Upload directory.
     *
     * Default: public/uploads/images
     */
    'path' => storage_path() . '/app/public',

    'folder' => 'images',

    /*
      * Use original name. If set to false, will use hashed name.
      *
      * Options:
      *     - original (default): use original filename in "slugged" name
      *     - hash: use filename hash as new file name
      *     - random: use random generated new file name
      *     - timestamp: use uploaded timestamp as filename
      *     - custom: user must provide new name, if not will use original filename
      */
    'savename' => 'hash',

    /*
     * Dimension identifier. If TRUE will use dimension name as suffix, if FALSE use directory.
     *
     * Example:
     *     - TRUE (default): newname_square50.png, newname_size100.jpg
     *     - FALSE: square50/newname.png, size100/newname.jpg
     */
    'suffix' => FALSE,

    'dimensions' => array(

        '90x90' => array(90, 90, true),
        '160x160' => array(160, 160, true),
        '320x320' => array(320, 320, true),
        '640x640' => array(640, 640, true),

        '90x' => array(90, 90, false),
        '160x' => array(160, 160, false),
        '320x' => array(320, 320, false),
        '640x' => array(640, 640, false),
    ),
];
