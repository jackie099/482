<?php

namespace Recommendation;

class product
{
    private $id;
    private $name;
    private $avg;

    public function __construct($row)
    {

        $this->id=$row['id'];
        $this->name = $row['name'];
        $this->avg =$row['avg'];

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getAvg()
    {
        return $this->avg;
    }


}