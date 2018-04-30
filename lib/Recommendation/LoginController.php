<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 18/3/22
 * Time: 下午9:59
 */

namespace Recommendation;


class LoginController
{
    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param array $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        // Create a Users object to access the table
        $users = new Users($site);

        $username = strip_tags($post['username']);
        $password = strip_tags($post['password']);
        $user = $users->login($username, $password);
        $session[User::SESSION_NAME] = $user;

        $root = $site->getRoot();
        if($user === null) {
            // Login failed
            $this->redirect = "$root/?f=1";
        } else {

                $this->redirect = "$root/products.php";

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