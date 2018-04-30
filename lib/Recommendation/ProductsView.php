<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 18/3/22
 * Time: 下午11:43
 */

namespace Recommendation;


class ProductsView extends View
{
    public function __construct($site,$user) {
        $this->setTitle("Products List");
        $this->site=$site;
        $this->user =$user;
    }
    private $user;
    private $site;	///< The Site object
    ///
    public function PresentForm()
    {
        $products = new Products($this->site);
        $u=$this ->user;
        $userid =$u->getId();

        $username= $u->getName();
        $row = $products->getRecommendation($userid);
       // print_r($row);
        $f=$row['firstname'];
        $s=$row['secondname'];
        $t=$row['thirdname'];
        $html='';
        if(isset($_GET['rated']))
        {
            $html.="<p>Rated successfuly!</p>";

        }
        $html.="<h1>"."Welcom, ".$username.". Please select product item to rate the product". "</h1>";


        $html.='<p>Based on  products that you have rated below, We recommend you 3 itmes that are :</p>';
        $html.="<p>"."1. ".$f."</p>";
        $html.="<p>"."2. ".$s."</p>";
        $html.="<p>"."3. ".$t."</p>";

        $html .= <<<HTML
<form class="table">
<feildset>


<table>
<tr>
<th style="width:60%">Product Name</th>
<th style="width:20%">Rating</th>
<th style="width:20%">Review</th>
</tr>
HTML;





        $all = $products->getRated($userid);
        foreach ($all as $p) {
            $rating = $p['rating'];
            $name =$p['itemname'];
            $review = $p['review'];

            $html .= "
		<tr>
			
			<td>$name</td>	";

			$html.="<td>";
			for($i=0;$i<$rating;$i++)
            {
                $html.="<img src=\"images/star-green.png\" >";

            }
            $gray = 5-$rating;
            for($i=0;$i<$gray;$i++)
            {
                $html.="<img src=\"images/star-gray.png\" >";

            }
            $html.="</td>";

			$html.="
			<td>$review</td>
			<td></td>
			
		</tr>";


        }

        $html .= <<<HTML
		</table>
</fieldset>
</form>

HTML;



        $html .= <<<HTML
        <h2>Below are products that you can choose.</h2>
<form class="table">
<feildset>


<table>
<tr>
<th style="width:20%">Product Number</th>
<th style="width:60%">Product Name</th>
<th style="width:20%">Average rating</th>
</tr>
HTML;




        $products = new Products($this->site);
        $all = $products->getAll();
        foreach ($all as $p) {
            $id = $p['id'];
            $name =$p['name'];
            $avg = $p['avg'];




            $html .= "
		<tr>
			
			<td><a href=\"product.php?id=$id\">$id</a></td>	";



            $html.="
			<td>$name</td>
			
			
		";
            $round = round($avg);
            $avg =round($avg,2);
            $html.="<td>";
            for($i=0;$i<$round;$i++)
            {
                $html.="<img src=\"images/star-green.png\" >";

            }
            $gray = 5-$round;
            for($i=0;$i<$gray;$i++)
            {
                $html.="<img src=\"images/star-gray.png\" >";

            }
            $html.="<p>". "(" .$avg. ")" . "</p>";
            $html.="</td></tr>";


        }
        $html .= <<<HTML
		</table>
</fieldset>
</form>

HTML;







        return $html;


    }
}