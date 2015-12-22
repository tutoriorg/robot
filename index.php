<?php

class Factory {

    public $types = [];

    public function addType($type) {
        $this->types[] = $type;
    }

    public function __call($method, $args)
    {
        foreach ($this->types as $type) {

            $class = get_class($type);



            if ($method == 'create'.$class) {

                $objects_count = intval($args[0]);

                $objects = [];
                for ($i = 1; $i <= $objects_count; $i++) {
                    // Якщо потрібно створити тільки простого робота (з одними роботом),
                    // тоді цей код:
                    /*$objects[] = new $class(); */

                    // Якщо попотрібно створити робота по вже готовому шаблону (може складитися з багатьох роботів),
                    // тоді цей код:
                    $objects[] = $type;
                }

                return $objects;
            }

        }
    }
}


abstract class Robot {
    public $robots = [];

    public $speed = 20;
    public $weight = 30;
    public $height = 40;

    function __construct() {
        if (empty($this->robots)) {
            $this->robots[] = $this;
        }
    }

    public function addRobot($robot) {
        if (is_array($robot)) {
            $this->robots = array_merge($this->robots, $robot);
        } else {
            $this->robots[] = $robot;
        }
    }

    public function getSpeed() {

        foreach ($this->robots as $robot) {
            if (!isset($speed)) {
                $speed = $robot->speed;
            } else
                if ($robot->speed < $speed) {
                    $speed = $robot->speed;
                }
        }

        return isset($speed) ? $speed : 0;
    }

    public function getWeight() {

        $weight = 0;
        foreach ($this->robots as $robot) {
            $weight += $robot->weight;
        }

        return $weight;
    }

    public function getHeight() {

        $height = 0;
        foreach ($this->robots as $robot) {
            $height += $robot->height;
        }

        return $height;
    }
}


class MyHydra1 extends Robot {
    public $speed = 10;
    public $weight = 20;
    public $height = 30;
}


class MyHydra2 extends Robot {

    public $speed = 20;
    public $weight = 30;
    public $height = 40;
}


class UnionRobot extends Robot {
    public $speed = 50;
    public $weight = 60;
    public $height = 70;
}



//Приклад використання:


echo '<pre>';

$factory = new Factory();

// myHydra1, myHydra2 типи роботів які може створювати фабрика
$factory->addType(new MyHydra1());
$factory->addType(new MyHydra2());

/**
 *
 * Результатом роботи метода createMyHydra1 буде масив з 5 об’єктів класу MyHydra1
 * Результатом роботи метода createMyHydra2 буде масив з 2 об’єктів класу MyHydra2
 */
var_dump($factory->createMyHydra1(5));
var_dump($factory->createMyHydra2(2));

$unionRobot = new UnionRobot();
$unionRobot->addRobot(new MyHydra2());
$unionRobot->addRobot($factory->createMyHydra2(2));

$factory->addType($unionRobot);

$res = reset($factory->createUnionRobot(1));

// Результатом роботи методу буде мінімальна швидкість з усіх об’єднаних роботів
echo $res->getSpeed();

// Результатом роботи методу буде сума всіх ваг об’єднаних роботів
echo $res->getWeight();

echo '</pre>';