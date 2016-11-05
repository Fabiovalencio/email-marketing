<?php

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(function ($classname){
    return class_exists($classname);
});