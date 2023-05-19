<?php
class Product 
{
    private $title;
    private $id;
    private $price;
    private $discount;
    private $quantity;
    private $images;
    private $research;

    public function __construct($id='')
    {
        
        if ($id)
        {
            $this->id = $id;
            $this->getData();
        }
    }
    private function getData()
    {
        $mysqli = new Database();
        $sql = "Select * from product where id=".$this->id;
        $mysqli->getConnection();
        $mysqli->runQuery($sql);
        if ($mysqli->num_rows == 1)
        {
            $this->research = $mysqli->getRow();
            $this->price = $this->research['price'];
            $this->title = $this->research['title'];
            $this->discount = $this->research['discount'];
            $this->quantity = $this->research['quantity'];
            $this->images = $this->research['images'];
        }
        
    }
    public function displayInput()
    {
        ?>
        <div class="col-md-4">
        <div class="card mb-4 product-wap rounded-0">
            <div class="card rounded-0">
                <img class="card-img rounded-0 img-fluid" src="assets/img/shop_01.jpg">
               
            </div>
            <div class="card-body">
                <a href="shop-single.php" class="h3 text-decoration-none"><?= $this->title ?: ?></a>
                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                    <li>M/L/X/XL</li>
                    <li class="pt-2">
                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                    </li>
                </ul>
                <ul class="list-unstyled d-flex justify-content-center mb-1">
                    <li>
                        <i class="text-warning fa fa-star"></i>
                        <i class="text-warning fa fa-star"></i>
                        <i class="text-warning fa fa-star"></i>
                        <i class="text-muted fa fa-star"></i>
                        <i class="text-muted fa fa-star"></i>
                    </li>
                </ul>
                <p class="text-center mb-0">$250.00</p>
            </div>
        </div>
    </div>
   <?php }
}
