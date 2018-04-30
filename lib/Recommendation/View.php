<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 2018/4/26
 * Time: 上午12:29
 */

namespace Recommendation;


class View
{
    public function head() {
        return <<<HTML
<meta charset="UTF-8">
  <title>$this->title</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">


HTML;
    }
    public function setTitle($title) {
        $this->title = $title;
    }

    private $title = "";	///< The page title
}