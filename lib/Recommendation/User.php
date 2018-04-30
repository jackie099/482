<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 18/3/22
 * Time: 上午10:54
 */

namespace Recommendation;


class User
{
    private $id;		///< The internal ID for the user
    private $name; 		///< Name as last, first


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
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];

        $this->name = $row['username'];

    }



    const SESSION_NAME = 'user';
}