<?php


namespace Recommendation;


class ProductsController
{
    public function __construct(Site $site,User $user, array $post)
    {
        $root = $site->getRoot();
        $itemid =strip_tags($post['id']);
        $rating =strip_tags($post['rate']);
        $review =strip_tags($post['review']);
        $userid = $user->getId();
        if(isset($post['update'])) {
            $p =new Products($site);
            if($rating>5||$rating<1)
            {
                $this->redirect = "$root/product.php?id=$itemid&rating=1";
                return;
            }
            else
                {

                $p->update($itemid,$userid,$rating,$review);
                $this->redirect = "$root/products.php?rated=1";
                return;
            }

        }

        else if(isset($post['cancel']))
            {

            $this->redirect = "$root/products.php";
            return;
        }



    }

    private $redirect;

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }	///< Page we will redirect the user to.

}