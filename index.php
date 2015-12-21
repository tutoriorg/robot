<?php class Factory {

    public $types = [];

    public function addType($type) {
        $this->types[] = $type;
    }

    public function __call($method, $args) {
        foreach ($this->types as $type) {

            $class = get_class($type);

            if ($method == 'create'.$class) {
                $objects_count = intval($args[0]);

                $objects = [];
                for ($i = 1; $i <= $objects_count; $i++) {
                $objects[] = new $class();
                }

                return $objects;
            }

        }
    }
}

class MyHydra1 {

}

class MyHydra2 {

}

$factory = new Factory();

$factory->addType(new MyHydra1);

$factory->addType(new MyHydra2);


var_dump($factory->createMyHydra1(5));
var_dump($factory->createMyHydra2(2));