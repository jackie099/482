<?php
/**
 * Created by PhpStorm.
 * User: duzengze
 * Date: 18/3/22
 * Time: 下午11:43
 */

namespace Recommendation;


class ProductView extends View
{
    public function __construct($site) {
        $this->setTitle("Rating products");
        $this->site=$site;
    }
    private $site;	///< The Site object
    public function PresentForm()
    {
        $p = new Products($this->site);
        $id =$_GET['id'];
        //print_r($id);
        $product = $p->get($id);
        $name = $product->getName();



        $html='';
        $html.='<p>'."Rating product:".$name.'</p>';
        $html .= <<<HTML
        <form method="post" action="post/products.php">
        <input type="hidden" name="id" value="$id">
        <input type="hidden" name="productname" value="$name">
		<p>
			<label for="rate">rate:</label>
			<input type="text" id="rate" name="rate" placeholder="rate"
				   >
		</p>
		
		<p>
			<label for="rate">review:</label>
			<input type="text" id="review" name="review" placeholder="review"
				   >
		</p>
		<p>
			<input type="submit" value="Update" name="update"> 
			<input type="submit" value="Cancel" name="cancel">	
		</p>
		
		</form>

				
HTML;
        if(isset($_GET['rating']))
        {
            $html.="<p>Invalid rating! please rate 1-5!</p>";
        }
        return $html;


    }
}