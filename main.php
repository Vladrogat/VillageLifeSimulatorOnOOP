<?php
/*
    Родительский класс животные
*/
class Animal{
    static $id  = 1; 
    public $idAnimal = 0;
    public $product;
    protected function GetProduct(){}
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
//создание нового объекта животкного по имени группы
function createAnimal($name){
    switch ($name) {
        case 'Коровы':
            return new Cow();
            break;
        case 'Куры':
            return new Chicken();
            break;
        /*
        *   добавить сюда новый case с названием животного 
        *   с генирацией соответсвующего класса этого животного
        */
        default:
            break;
    }
}
//класс нашей фермы
class Farm{
    //массив данных видов животных
    private $barn = [
        'Коровы' => [],
        'Куры' => [],
    ];
    private $result;

    // создание начального количества животных в хлеву
    function __construct()
    {
        for ($i = 0; $i < 10; $i++) { 
            $this->RegistrationAnimal('Коровы');
        }
        for ($i = 0; $i < 20; $i++) { 
            $this->RegistrationAnimal('Куры');
        }
    }

    // Метод Добавления животных
    public function RegistrationAnimal($name){
        array_push($this->barn[$name], createAnimal($name));
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
    public function AddAnimal($name){
        $this->barn[$name] = array();
    }

    //получаю все виды продукции животных из массива хлева 
    private function GetTypeProduct(){
        $sum = array();
        foreach($this->barn as $name => $animal)
        {
            $sum += [$animal[0]->product => 0];
        }
        return $sum;
    }
    public function GetProductionOnDay(){
        //Получение асоциативного массива с значениями продуктов для подсчета их в течении недели
        $this->result = $this->GetTypeProduct();
        //подсчет продукции за один день
        foreach ($this->barn as $nameanimal => $value) {
            //определяем тип продукта текущих животных
            $type = $value[0]->product;
            $sum = 0;

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

//в хлеве 10 коров и 20 кур
$farm->CountAnimals();

//произвели сбор продукции 
$farm->GetProductionOnWeek();

echo PHP_EOL."съездили на рынок, купили животных".PHP_EOL;

for ($i = 0; $i < 5; $i++) { 
    $farm->RegistrationAnimal('Куры');
}

$farm->RegistrationAnimal('Коровы');

$farm->CountAnimals();

$farm->GetProductionOnWeek();