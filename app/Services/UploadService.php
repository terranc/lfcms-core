<?php

namespace App\Services;

use \Config;
use \File;
use \Log;
use \Illuminate\Support\Str;

class UploadService
{
    protected $library;
    protected $upload;

    public $results = [];

    /**
     * UploadService constructor.
     */
    public function __construct()
    {
        $this->library = Config::get('upload.library', 'gd');
        $this->quality = Config::get('upload.quality', 90);
        $this->uploadpath = Config::get('upload.path', storage_path() . '/app/public');
        $this->savename = Config::get('upload.savename', 'original');
        $this->dimensions = Config::get('upload.dimensions');
        $this->suffix = Config::get('upload.suffix', true);

        if ($this->library === 'imagick') $this->imagine = new \Imagine\Imagick\Imagine();
        elseif ($this->library === 'gmagick') $this->imagine = new \Imagine\Gmagick\Imagine();
        elseif ($this->library === 'gd') $this->imagine = new \Imagine\Gd\Imagine();
        else $this->imagine = new \Imagine\Gd\Imagine();
    }

    public function upload($filesource, $dir = null, $savename = null)
    {
        $isExistPath = $this->checkExistPath($this->uploadpath, $dir);
        $isImage = $this->checkIsImage($filesource);

        if (!$isExistPath) {
            $this->results['error'] = 'Path "' . $this->uploadpath . '/' . $dir . '" is not exist.';
            Log::error('UploadService: ' . $this->results['error']);
        }
        if (!$isImage) {
            $this->results['error'] = 'File must is image.';
            Log::error('UploadService: ' . $this->results['error']);
        }
        if ($filesource) {
            $this->results['path'] = rtrim($this->uploadpath, '/') . ($dir ? '/' . trim($dir, '/') : '');
            $this->results['save_name'] = $filesource->getClientOriginalName();
            $this->results['extension'] = $filesource->getClientOriginalExtension();
            $this->results['size'] = $filesource->getSize();
            $this->results['mime'] = $filesource->getMimeType();

            switch ($this->savename) {
                case 'hash':
                    $this->results['save_name'] = md5($this->results['save_name'] . '.' . $this->results['extension'] . strtotime('now')) . '.' . $this->results['extension'];
                    break;
                case 'random':
                    $this->results['save_name'] = Str::random() . '.' . $this->results['extension'];
                    break;
                case 'timestamp':
                    $this->results['save_name'] = strtotime('now') . '.' . $this->results['extension'];
                    break;
                case 'custom':
                    $this->results['save_name'] = (!empty($savename) ? $savename . '.' . $this->results['extension'] : $this->results['save_name']);
                    break;
                default:
                    $this->results['save_name'] = $this->results['save_name'];
            }
            $uploaded = $filesource->move($this->results['path'], $this->results['save_name']);
            if ($uploaded) {
                $this->results['save_path'] = rtrim($this->results['path']) . '/' . $this->results['save_name'];
                $this->results['url'] = ($dir ? trim($dir, '/') . '/' : '') . $this->results['save_name'];
                $this->results['basename'] = pathinfo($this->results['save_path'], PATHINFO_FILENAME);
                list($width, $height) = getimagesize($this->results['save_path']);
                $this->results['width'] = $width;
                $this->results['height'] = $height;
                $this->createSizes($this->results['save_path']);
            } else {
                $this->results['error'] = 'File ' . $this->results['filename '] . ' is not uploaded.';
                Log::error('UploadService: ' . $this->results['error']);
            }
        } else {
            $this->results['error'] = 'File is required.';
            Log::error('UploadService: ' . $this->results['error']);
        }
        return $this->results;
    }

    public function getThumbUrl($url = '', $dimension = null)
    {
        if ($this->suffix) {
            if ($dimension) {
                $dimension_path = str_replace_last(pathinfo($url, PATHINFO_FILENAME), pathinfo($url, PATHINFO_FILENAME) . '_' . $dimension, $url);
            } else {
                $dimension_path = $url;
            }
        } else {
            if ($dimension) {
                $dimension_path = str_replace_last(basename($url), $dimension . '/' . basename($url), $url);
            } else {
                $dimension_path = $url;
            }
        }
        return $dimension_path;
    }

    private function checkExistPath($path, $dir = null)
    {
        $path = rtrim($path, '/') . ($dir ? '/' . trim($dir, '/') : '');
        if (File::isDirectory($path) && File::isWritable($path)) {
            return true;
        } else {
            try {
                @File::makeDirectory($path, 0777, true);
                return true;
            } catch (\Exception $e) {
                Log::error('UploadService: ' . $e->getMessage());
                $this->results['error'] = $e->getMessage();
                return false;
            }
        }
    }

    private function checkIsImage($filesource)
    {
        if (substr($filesource->getMimeType(), 0, 5) == 'image') {
            return true;
        } else {
            return false;
        }
    }

    protected function createSizes($filesource)
    {
        if (!empty($this->dimensions) && is_array($this->dimensions)) {
            foreach ($this->dimensions as $name => $dimension) {
                $width = (int)$dimension[0];
                $height = isset($dimension[1]) ? (int)$dimension[1] : $width;
                $crop = isset($dimension[2]) ? (bool)$dimension[2] : false;
                $this->resize($filesource, $name, $width, $height, $crop);
            }
        }
    }

    private function resize($filesource, $suffix, $width, $height, $crop)
    {
        if (!$height) $height = $width;
        $suffix = trim($suffix);
        $path = $this->results['path'] . ($this->suffix == false ? '/' . trim($suffix, '/') : '');
        $name = $this->results['basename'] . ($this->suffix == true ? '_' . trim($suffix, '/') : '') . '.' . $this->results['extension'];
        $pathname = $path . '/' . $name;
        try {
            $isExistPath = $this->checkExistPath($this->results['path'], ($this->suffix == false ? $suffix : ''));
            if ($isExistPath) {
                $size = new \Imagine\Image\Box($width, $height);
                $mode = $crop ? \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND : \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                $savename = $this->imagine->open($filesource)->thumbnail($size, $mode)->save($pathname, ['quality' => $this->quality]);

                list($nwidth, $nheight) = getimagesize($pathname);
                $size = filesize($pathname);
                $this->results['dimensions'][$suffix] = [
                    'path' => $path,
                    'save_name' => $name,
                    'save_path' => $pathname,
                    'url' => basename($this->results['path']) . '/' . ($this->suffix == false ? trim($suffix, '/') . '/' : '') . $name,
                    'basename' => pathinfo($this->results['save_path'], PATHINFO_FILENAME),
                    'width' => $nwidth,
                    'height' => $nheight,
                    'size' => $size,
                ];
            }
        } catch (\Exception $e) {
        }
    }
}
