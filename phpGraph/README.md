phpGraph
========

Writing svg histogram with php

How to use ?
------------

First, data must be in an php array (one or two dimensions). 
Then, an instance of phpGraph class have to be called after an inclusion of phpGraph.php file in your project.
Then, the main method called draw is used, with or withour options. It's up to you.

Add phpGraph_style.css to header of your page for display graph.

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>phpGraph</title>
        <link rel="stylesheet" type="text/css" href="phpGraph_style.css" media="all">
    </head>
    <body> (...)

By default, it's a line histogram which is displaying.

To resume :

    <?php 
    include(phpGraph.php);
  
    $data = array(
      'serie 1' => 10,
      'serie 2' => 38,
      'serie 3' => 23,
      'serie 4' => -15
     );
  
    $G = new phpGraph();
    
    echo $G->draw($data);
    ?>
  
Options available :
-------------------
  
     //All options available
    $options = array(
      'width' => null,// (int) width of grid
      'height' => null,// (int) height of grid
      'paddingTop' => 10,// (int)
      'type' => 'line',// (string) "bar" or "pie"
      'steps' => 5,// (int) 2 graduations on y-axis are separated by $steps units
      'filled' => true,// (bool) to fill lines/histograms/disks
      'tooltips' => false,// (bool) to show tooltips
      'circles' => true,// (bool) to show circles on graph (lines or histograms)
      'stroke' => '#3cc5f1',// (string) color of lines by default. Use an array to personalize each line
      'background' => "#ffffff",// (string) color of grid background. Don't use short notation (#fff) because of $this->__genColor();
      'gradient' => null,// (array) 2 colors from left to right
      'titleHeight' => 0,// (int) Height of main title
      'tooltipLegend' => '',// (string or array) Text display in tooltip with y value. Each text can be personalized using an array.
      'legends' => '',// (string or array) General legend for each line/histogram/disk displaying under diagram
      'title' => null,// (string) Main title. Title wil be displaying in a tooltip too.
      'radius' => 100,// (int) Radius of pie
      'diskLegends' => false,// (bool) to display legends around a pie
      'diskLegendsType' => 'label',// (string) "data", "pourcent" or "label" to display around a pie as legend
      'responsive' => true,// (bool) to avoid svg to be responsive (dimensions fixed)
    );
    
See [samples.php](http://www.ecyseo.net/?static8/phpgraph) for more details.

[Page of project on github](http://jerrywham.github.io/phpGraph/)

Licence :
---------
[CONTRAT DE LICENCE DE LOGICIEL LIBRE CeCILL version 2.1](http://www.cecill.info/licences/Licence_CeCILL_V2.1-fr.txt)
