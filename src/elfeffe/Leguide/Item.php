<?php
namespace elfeffe\Leguide;

use elfeffe\Leguide\Node;
use elfeffe\Leguide\Containers\Leguide;

class Item
{

    CONST INSTOCK = 'in stock';

    CONST OUTOFSTOCK = 'out of stock';

    CONST PREORDER = 'preorder';

    CONST BRANDNEW = 'new';

    CONST USED = 'used';

    CONST REFURBISHED = 'refurbished';

    CONST MALE = 'male';

    CONST FEMALE = 'female';

    CONST UNISEX = 'unisex';

    CONST NEWBORN = 'newborn';

    CONST INFANT = 'infant';

    CONST TODDLER = 'toddler';

    CONST KIDS = 'kids';

    CONST ADULT = 'adult';

    CONST EXTRASMALL = 'XS';

    CONST SMALL = 'S';

    CONST MEDIUM = 'M';

    CONST LARGE = 'L';

    CONST EXTRALARGE = 'XL';

    CONST EXTRAEXTRALARGE = 'XXL';

    /**
     * [$nodes - Stores all of the product nodes]
     * @var array
     */
    private $nodes = array();

    /**
     * [$index description]
     * @var null
     */
    private $index = null;

    /**
     * [$namespace - (g:) namespace definition]
     * @var string
     */
    protected $namespace = 'http://base.google.com/ns/1.0';

    /**
     * [__construct]
     */
    public function __construct()
    {
    }

    /**
     * [category - Set the category of the product]
     * @param  [type] $category [description]
     * @return [type]        [description]
     */
    public function category($category)
    {
        $node = new Node('category');
        $title = $this->safeCharEncodeText($category);
        $this->nodes['category'] = $node->value($category)->addCdata();
    }

    /**
     * [offer_id - Set the ID of the product]
     * @param  [type] $offer_id [description]
     * @return [type]     [description]
     */
    public function offer_id($offer_id)
    {
        $node = new Node('offer_id');
        $this->nodes['offer_id'] = $node->value($offer_id)->_namespace($this->namespace);
    }

    /**
     * [name - Set the name of the product]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function name($name)
    {
        $node = new Node('name');
        $name = $this->safeCharEncodeURL($name);
        $this->nodes['name'] = $node->value($name)->addCdata();
    }

    /**
     * [price - Set the price of the product, do not format before passing]
     * @param  [type] $price [description]
     * @return [type]        [description]
     */
    public function price($price)
    {
        $node = new Node('price');
        $this->nodes['price'] = $node->value(number_format($price, 2, '.', ''))->_namespace($this->namespace);
    }
    
    /**
     * [product_url - Set the link/URL of the product]
     * @param  [type] $product_url [description]
     * @return [type]       [description]
     */
    public function product_url($product_url)
    {
        $node = new Node('product_url');
        $product_url = $this->safeCharEncodeURL($product_url);
        $this->nodes['product_url'] = $node->value($product_url)->addCdata();
    }

    /**
     * [image_url description]
     * @param  [type] $image_url [description]
     * @return [type]             [description]
     */
    public function image_url($image_url)
    {
        $node = new Node('image_url');
        $image_url = $this->safeCharEncodeURL($image_url);
        $this->nodes['image_url'] = $node->value($image_url)->_namespace($this->namespace)->addCdata();
    }

    /**
     * [description - Set the description of the product]
     * @param  [type] $description [description]
     * @return [type]              [description]
     */
    public function description($description)
    {
        $node = new Node('description');
        $description = $this->safeCharEncodeText($description);
        $this->nodes['description'] = $node->value(substr($description, 0, 5000))->_namespace($this->namespace)->addCdata();
    }

    /**
     * [shipping description]
     * @param  [type] $shipping [description]
     * @return [type]               [description]
     */
    public function shipping($shipping)
    {
        $node = new Node('shipping');
        $this->nodes['shipping'] = $node->value($shipping)->_namespace($this->namespace);
    }

    /**
     * [availability description]
     * @param  [type] $availability [description]
     * @return [type]               [description]
     */
    public function availability($availability)
    {
        $node = new Node('availability');
        $this->nodes['availability'] = $node->value($availability)->_namespace($this->namespace);
    }

    /**
     * [brand description]
     * @param  [type] $brand [description]
     * @return [type]        [description]
     */
    public function brand($brand)
    {
        $node = new Node('brand');
        $brand = $this->safeCharEncodeText($brand);
        $this->nodes['brand'] = $node->value($brand)->_namespace($this->namespace)->addCdata();
    }

    /**
     * [guarantee description]
     * @param  [type] $guarantee [description]
     * @return [type]        [description]
     */
    public function guarantee($guarantee)
    {
        $node = new Node('guarantee');
        $guarantee = $this->safeCharEncodeText($guarantee);
        $this->nodes['guarantee'] = $node->value($guarantee)->_namespace($this->namespace)->addCdata();
    }

    /**
     * [list_price - Set the price of the product, do not format before passing]
     * @param  [type] $list_price [description]
     * @return [type]        [description]
     */
    public function list_price($list_price)
    {
        $node = new Node('list_price');
        $this->nodes['list_price'] = $node->value(number_format($list_price, 2, '.', ''))->_namespace($this->namespace);
    }


    /**
     * [model_number description]
     * @param  [type] $model_number [description]
     * @return [type]      [description]
     */
    public function mpn($model_number)
    {
        $node = new Node('model_number');
        $this->nodes['model_number'] = $node->value($model_number)->_namespace($this->namespace)->addCdata();
    }



    /**
     * [nodes description]
     * @return [type] [description]
     */
    public function nodes()
    {
        return $this->nodes;
    }

    /**
     * [setIndex description]
     * @param [type] $index [description]
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }


    /**
     * [clone description]
     * @return [type] [description]
     */
    public function cloneIt()
    {
        $item = GoogleShopping::createItem();
        $this->item_group_id($this->nodes['mpn']->get('value') . '_group');
        foreach ($this->nodes as $node) {
            if (is_array($node)) {
                $name = $node[0]->get('name');
                foreach ($node as $_node) {
                    if ($name == 'shipping') {
                        $xml = simplexml_load_string('<foo>' . trim(str_replace('g:', '',
                                $_node->get('value'))) . '</foo>');
                        $item->{$_node->get('name')}($xml->country, $xml->service, $xml->price);
                    } else {
                        $item->{$name}($_node->get('value'));
                    }
                }
                $item->{$node->get('name')}($node->get('value'));
            }
        }
        return $item;
    }

    /**
     * [variant description]
     * @return [type] [description]
     */
    public function variant()
    {
        $item = $this->cloneIt();
        $item->item_group_id($this->nodes['mpn']->get('value') . '_group');
        return $item;
    }

    /**
     * [safeCharEncode description]
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    private function safeCharEncodeURL($string)
    {
        return str_replace(
            array('%', '[', ']', '{', '}', '|', ' ', '"', '<', '>', '#', '\\', '^', '~', '`'),
            array(
                '%25',
                '%5b',
                '%5d',
                '%7b',
                '%7d',
                '%7c',
                '%20',
                '%22',
                '%3c',
                '%3e',
                '%23',
                '%5c',
                '%5e',
                '%7e',
                '%60'
            ),
            $string);
    }

    /**
     * [safeCharEncodeText description]
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    private function safeCharEncodeText($string)
    {
        return str_replace(
            array('•', '”', '“', '’', '‘', '™', '®', '°'),
            array('&#8226;', '&#8221;', '&#8220;', '&#8217;', '&#8216;', '&trade;', '&reg;', '&deg;'),
            $string);
    }

}
