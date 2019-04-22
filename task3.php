<?php 
    interface figure {
        public function __construct($m = NULL);
        public function area();
        public function get($s);
        public function getArray();
    }

    class rectangle implements figure {
        private $a;
        private $b;
        public function __construct($m = NULL) {
            if ($m != NULL) {
                $this->a = $m['a'];
                $this->b = $m['b'];
            }
            else 
                $this->a = random_int(1, 30);
                $this->b = random_int(1, 30);
        }

        public function area() {
            return $this->a * $this->b;
        }

        public function get($s) {
            echo "Прямоугольник, сторона a = $this->a, b = $this->b, площадь = $s<br>";
        }

        public function getArray() {
            return ['type' => 'rectangle', 'a' => $this->a, 'b' => $this->b];
        }
    }

    class circle implements figure {
        private $radius;
        public function __construct($m = NULL) {
            if ($m != NULL) 
                $this->radius = $m['radius'];
            else
                $this->radius = random_int(1, 30);
        }

        public function area() {
            return 2 * M_PI * $this->radius;
        }

        public function get($s) {
            echo "Круг, радиус = $this->radius, площадь = $s<br>";
        }   

        public function getArray() {
            return ['type' => 'circle', 'radius' => $this->radius];
        }
    }

    class pyramid implements figure {
        // Ребро равнобедренного треугольника
        private $edge;
        // Радиус описанной окружности об основание пирамиды
        private $radius;
        // Основание равнобедренного треугольника
        private $baseline;

        public function __construct($m = NULL) {
            if ($m != NULL) {
                $this->edge = $m['edge'];
                $this->radius = $m['radius'];
            }
            else {
                $this->edge = random_int(1, 30);
                $this->radius = random_int(1, 30);          
            }
            $this->baseline = 2 * $this->radius * sin(deg2rad(60));
        }

        public function area() {
            // Высчитываем площадь основания
            $square_base = pow($this->baseline, 2) * sqrt(3) / 4; 
            // Высчитываем площадь грани
            $square_side = 0.5 * pow($this->edge, 2) * sin(deg2rad(120)); 

            return $square_side * 3 + $square_base;
        }

        public function get($s) {
            echo "Пирамида, ребро = $this->edge, основание = $this->baseline, радиус описанной окружности об основание пирамиды = $this->radius, площадь = $s<br>";
        }

        public function getArray() {
            return ['type' => 'pyramid', 'edge' => $this->edge, 'radius' => $this->radius];
        }
    }

    // Создание десяти случайных объектов
    for ($i = 0; $i < 10; $i++) {
        $type = random_int(1, 3);
        switch ($type) {
            case 1: $figures[] = new rectangle(); break;    
            case 2: $figures[] = new circle();  break;
            case 3: $figures[] = new pyramid(); break;
        }
    }

    // Сохранение их в файл
    for ($i = 0; $i < 10; $i++) {
        $data[] = $figures[$i]->getArray();
    }
    file_put_contents('figures.json', json_encode($data));  
    for ($i = 0; $i < 10; $i++) 
        unset($figures[$i]);
    unset($figures);


    // Считывание из файла
    $decode = json_decode(file_get_contents('figures.json'), true);

    foreach ($decode as $k => $v) {
        $figures[] = new $v['type']($v);
        $areas[] = $figures[$k]->area(); 
    }

    // Сортировка по убыванию площадей
    array_multisort($areas, SORT_DESC, $figures);
    // Вывод на экран
    foreach ($decode as $k => $v) 
        $figures[$k]->get($areas[$k]);
    