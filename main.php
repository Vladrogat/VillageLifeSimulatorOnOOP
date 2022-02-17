<?php
/*
    Родительский класс животные
*/
class Animal{
    static $id  = 1; 
    public $idAnimal = 0;
    public $product;
    protected function GetProduct(){}
    public function getNameOfClass()
    {
        return static::class;
    }
}
//Дочерний класс коровы 
class Cow extends Animal{
    //конструктор формирования значений
    function __construct(){
        //задание уникального идентификатора
        $this->idAnimal = parent::$id++;
        // определение типа продукта
        $this->product = "Молоко";
    }
    //выроботка продукции
    function GetProduct()
    {
        return rand(8,12);
    }
}

class Chicken extends Animal{
    function __construct()
    {
        //задание уникального идентификатора
        $this->idAnimal = parent::$id++;
        // определение типа продукта
        $this->product = "Яйца";
    }
    //выроботка продукции
    function GetProduct()
    {
        return rand(0,1);
    }
}
/*
class Sheep extends Animal{
    function __construct()
    {
        //задание уникального идентификатора
        $this->idAnimal = parent::$id++;
        // определение типа продукта
        $this->product = "Шерсть";
    }
    //выроботка продукции
    function GetProduct()
    {
        return rand(5,10);
    }
}*/

//класс нашей фермы
class Farm{

    //массив данных видов животных
    private $barn = array();
    private $result;
    // Метод Добавления животных
    public function RegistrationAnimal($animal){
        array_push($this->barn[$animal->getNameOfClass()], $animal);
    }
    //Метод подсчета животных
    public function CountAnimals(){
        echo "Количество животных по категориям: " . PHP_EOL;
        foreach ($this->barn as $animal => $value) {
            echo "$animal: " . count($value) . PHP_EOL;
        }
    }

    //Метод сбора продукции и вывода количества продукции 
    public function GetProductionOnWeek(){

        echo PHP_EOL . "Производим сбор продукции".PHP_EOL;
        //подсчет продукции за неделю
        for ($i=0; $i < 7; $i++) { 
            $this->GetProductionOnDay();
        }

        echo "Произведенная продукция за неделю(по категориям): ". PHP_EOL;
        //вывод проиведенной продукции по продуктам
        foreach ($this->result as $type => $count) {
            echo  $type . ": " . $count .PHP_EOL;
        }
       
    }
    //  Метод добавления нового вида животных
    public function AddAnimal($animal){
        $this->barn[$animal->getNameOfClass()] = array();
    }
    public function GetProductionOnDay(){

        //Получение асоциативного массива с значениями продуктов для подсчета их в течении недели
        //подсчет продукции за один день
        foreach ($this->barn as $nameanimal => $value) {
            //определяем тип продукта текущих животных
            $type = $value[0]->product;
            $sum = 0;
            //в цикле заношу новый тип продукта
            $this->result[$type] = $sum;
            //подсчет продукции по всем животным определенного типа
            foreach ($value as $animal) {

                $sum += $animal->GetProduct();
            }
            //суммирование произведенной продукции одного типа
            $this->result[$type] += $sum;
        }

    }
}

echo PHP_EOL."Cимулятор деревенской жизни". PHP_EOL. PHP_EOL;

//наша ферма 
$farm = new Farm();

$farm->addAnimal(new Cow);
for ($i = 0; $i < 10; $i++) { 
    $farm->RegistrationAnimal(new Cow);
}
$farm->AddAnimal(new Chicken);
for ($i = 0; $i < 20; $i++) { 
    $farm->RegistrationAnimal(new Chicken);
}
/////////////////////////
/*
$farm->AddAnimal(new Sheep);
for ($i=0; $i < 10; $i++) { 
    $farm->RegistrationAnimal(new Sheep);
}
*/
/////////////////////

//в хлеве 10 коров и 20 кур
$farm->CountAnimals();

//произвели сбор продукции 
$farm->GetProductionOnWeek();

echo PHP_EOL."съездили на рынок, купили животных".PHP_EOL;
for ($i = 0; $i < 5; $i++){ 
    $farm->RegistrationAnimal(new Chicken);
}
$farm->RegistrationAnimal(new Cow);

$farm->CountAnimals();

$farm->GetProductionOnWeek();