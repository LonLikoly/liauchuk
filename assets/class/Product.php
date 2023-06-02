<?php
class Product 
{
    private $title;
    public $id;
    private $price;
    private $discount;
    private $quantity;
    private $images;
    private $mysqli;
    public $research;

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
        $this->mysqli = new Database(); // присваиваем св-ву объект
        $sql = "Select * from product where id=".$this->id;
        $this->mysqli->runQuery($sql);
        if ($this->mysqli->num_rows == 1) 
        {
            $this->research = $this->mysqli->getRow();
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
        <div class="col-md-8 offset-md-2">
            <form action="" method="POST" name='form' enctype="multipart/form-data">
                 <div class="card mb-4 product-wap rounded-0">
                     <div class="card rounded-0">
                     <div>
                        <input type="number" id="id" name ="id" hidden value="<?= $this->research['id'] ?>"/> 
                    </div>
                    <div class = "mt-3">
                    <label for="title">Title of product</label>
                     <input type="text" id="title" name="title"  value="<?= $this->research['title'] ?>" required/>
                    </div>
                    

                    <div class = "mt-3">
                    <label for="price">Price</label>
                     <input  type="number"  id="price"  name="price" value="<?= $this->research['price'] ?>" step ="0.01" required/>
                    </div>
                    <div class = "mt-3">
                    <label for="discount">Discount (%)</label>
                     <input type="number" id="discount" name="discount" max='99' min='0' value="<?= $this->research['discount'] ?>" />
                    </div>
                    <div class = "mt-3">
                    <label for="price">Quantity</label>
                     <input type="number" id="quantity" name="quantity" value="<?= $this->research['quantity'] ?>" required/>
                    </div>
                    <div id='product_IMG'>
                        <?php
                        if ($this->research['image_URL'])
                        {
                        ?> 
                            <img src="<?=$this->research['image_URL']?>" height= '100px' />
                        <?php
                        }
                        ?>
                    </div>
                    <div>
                     <label for="images">Choose images to new upload (PNG, JPG)</label>
                     <input type="file" id="FILE" name="FILE" accept=".jpg, .jpeg, .png" multiple onclick = "document.getElementById('product_IMG').hidden=true;" />   
                    </div>
                     <div>
                        <input type="submit" id="submmit" name="Send" value="SAVE"/>
                     </div>

                     <div class="card-body">
                         <a href="shop-single.php" class="h3 text-decoration-none"></a>
                    </div>
                </div>
            </form>
           
                  
        </div>
    <?php
    }
    public function saveData($data)
    {
        if ($data['id'])
        {
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->research['image_URL']) && $_POST['image_URL']) // если у нас есть ссылка используемого изображения и одновременно есть ссылка на новое изобрпжение
            { 
                unlink($_SERVER['DOCUMENT_ROOT'].$this->research['image_URL']); //мы избавляемся от старой ссылки 
            }
            $sql = "UPDATE product set "; // создаем запрос на изменение старой записи
        }
        else 
        {
            $sql = "INSERT into product set "; // создаем запрос на создание новой записи 
        }
        foreach ($data as $key => $val) // ассоциотивному массиву задаем параметры с именами : $key - как ключь и $val как значение
        {
            if ($key != 'id' && $key != 'Send') //перебераем ключи и исключаем не нужные нам id,Send
            {
                $sql .= $key . "='".addslashes($val)."', "; // выбранные ключи слешируем
            }
        }
         $sql .= " userId=".$_SESSION['user_id']." "; // добавляем сессию id (кто делал)
        
       if ($data['id']) // проверяем существование
       {
         $sql .= ", updatedAt=now() where id=".$data['id'];
       }
       else $sql .= ", createdAt=now()";
      //echo $sql;
      // exit;
      $mysqli = new Database();
         $mysqli->runQuery($sql);
    }
    public function deleteData()
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->research['image_URL'])) // если у нас есть ссылка используемого изображения и одновременно есть ссылка на новое изобрпжение
        { 
            unlink($_SERVER['DOCUMENT_ROOT'].$this->research['image_URL']); //удаляет картинку 
        }
        $this->mysqli->runQuery('delete from product where id='.$this->research['id']);
        
    }
    public function displayCard($editKey = '')
    {
        ?>
          <div class="col-md-3">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" style="width:100%;height:300px" src="<?= $this->research['image_URL'] ?>">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                 <?php if($editKey == 'admin') 
                                 {?>
                                   <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white" onclick="window.open('/assets/delete.php?id=<?= $this->research['id'] ?>','tabDelete','left=100,top=100,width=10,height=10')"><i class="far fa-trash-alt"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2"  onclick="window.open('/assets/inputform.php?id=<?= $this->research['id'] ?>','tabEdit','left=100,top=100,width=600,height=450')"><i class="far fa-edit"></i></a></li>
                                    </ul>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <a  class="h3 text-decoration-none"><?= $this->research['title'] ?></a>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li><?= $this->research['quantity'] ?></li>
                                    
                                </ul>
                                
                                
                               <?php if ($this->research['discount'])
                               { ?>
                                <p class="text-center mb-0">$<?= round($this->research['price']*(100- $this->research['discount'])/100,2 )  ?></p>
                                <p class="text-center mb-0"><s>$<?=  $this->research['price'] ?></s></p>
                                <?php } else { ?>
                                <p style="margin-top:28px" class="text-center mb-0">$<?=  $this->research['price'] ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
    }
}

