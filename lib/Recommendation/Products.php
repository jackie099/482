<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 2018/3/28
 * Time: 下午5:49
 */

namespace Recommendation;


class Products extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "product");
    }


    public function get($id) {


        $sql =<<<SQL
SELECT * from $this->tableName
where id='$id'
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {

            return null;
        }

        return new Product($statement->fetch(\PDO::FETCH_ASSOC));

    }
    public function getAll() {

        $sql =<<<SQL
select *
from $this->tableName
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function update($itemid,$userid,$rating,$review) {
        $sql = <<<SQL
REPLACE INTO 482_rated(itemid,userid,rating,review)
VALUES ('$itemid','$userid','$rating','$review')
SQL;

        $statement = $this->pdo()->prepare($sql);


        $statement->execute();


    }
    public function getRated($userid) {

        $sql =<<<SQL
select 482_rated.rating as rating , 482_product.name as itemname, 482_rated.review as review
from 482_rated
INNER JOIN 482_product
ON  482_rated.itemid = 482_product.id
WHERE 482_rated.userid = ?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllRated() {

        $sql =<<<SQL
select *
from 482_rated
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function saveRecommendation($uid,$first,$second,$third) {

        $sql =<<<SQL
REPLACE INTO 482_recommendation(uid,first,second,third)
VALUES ('$uid','$first','$second','$third')
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($uid,$first,$second,$third));


    }

    public function getRecommendation($userid) {

        $sql =<<<SQL
select f.name as firstname,s.name as secondname, t.name as thirdname
from 482_recommendation
INNER JOIN 482_product  as f
ON first =  f.id
INNER JOIN 482_product  as s
ON second =  s.id
INNER JOIN 482_product  as t
ON third =  t.id
WHERE uid=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userid));

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

}