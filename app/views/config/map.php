<?php

$GLOBALS['assetsMap'] = ['js'=>['main'=>['http://localhost:8080/vendors~main.chunk.js','http://localhost:8080/main.490432fa.js'],'vue'=>['http://localhost:8080/vendors~vue.chunk.js','http://localhost:8080/vue.05d281b5.js']],'css'=>['main'=>['http://localhost:8080/style.57e3d9d6.css']]];

/**
* 根据 $assetsMap 插入css
* @access public
* @param string $entry css入口名
*/
function insertCSS($entry)
{
  global $assetsMap;
  $css = $assetsMap['css'];
  if (isset($css[$entry])) {
      foreach ($css[$entry] as $v) {
          echo '<link rel="stylesheet" href="' . $v . '">';
        }
    }
}
/**
* 根据 $assetsMap 插入js
* @access public
* @param string $entry js入口名
*/
function insertJS($entry)
{
  global $assetsMap;
  $js = $assetsMap['js'];
  if (is_array($entry)) {
    foreach ($entry as $key => $value) {
      if (isset($js[$value])) {
        foreach ($js[$value] as $v) {
          echo '<script src="' . $v . '"></script>';
        }
      }
    }
  } else {
    if (isset($js[$entry])) {
      foreach ($js[$entry] as $v) {
        echo '<script src="' . $v . '"></script>';
      }
    }
  }
}