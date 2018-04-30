<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 18/3/22
 * Time: 下午11:43
 */

namespace Recommendation;


class LoginView extends View
{
    public function presentForm() {
        $html = <<<HTML
<form method="post" action="post/login.php">
    <fieldset>
        <legend>Login</legend>
        <p>
            <label for="email">Username</label><br>
            <input type="text" id="username" name="username" placeholder="username">
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password">
        </p>
          <p>
            <input type="submit" value="Log in"> 
        </p>
      

    </fieldset>
</form>
HTML;
        if(isset($_GET['f']))
        {
            $html.="<p>Invalid login!</p>";

        }
        return $html;
    }
}