<?php

//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

//Instantiate the F3 Base Class
$f3 = Base::instance();

//Define a default route
//https://kcheng.greenriverdev.com/328/hello-fat-free/
$f3->route('GET /', function(){
    //echo below is used for testing before executing the template
//    echo '<h1>Hello Quiz</h1>';

    //Render a view page
    $view = new Template();
    echo $view->render('views/home.html');
});

//Order Page
$f3->route('GET|POST /survey', function($f3){

    $checkBox = "";

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get the data
        $name = $_POST['name'];


        if (isset($_POST['checkBoxes']) && is_array($_POST['checkBoxes'])) {
            $boxes = implode(", ", $_POST['checkBoxes']);
        }

//        $boxes = implode(", ", $_POST['checkBoxes']);
//        $boxes = $_POST['checkBoxes'];


        $f3->set('SESSION.name', $name);
        $f3->set('SESSION.checkBoxes', $boxes);


        if(empty($f3->get('errors'))){
            $f3->reroute('summary');
        }

    }

    $checkBoxes = getBoxes();
    $f3->set('checkBoxes', $checkBoxes);

    //Render a view page
    $view = new Template();
    echo $view->render('views/survey.html');
});

$f3->route('GET|POST /summary', function(){
    //echo below is used for testing before executing the template
//    echo '<h1>Hello Pets 2</h1>';

    $view = new Template();
    echo $view->render('views/summary.html');
});



//Run Fat-Free
$f3->run();