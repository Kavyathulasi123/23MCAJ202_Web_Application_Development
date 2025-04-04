<!DOCTYPE html>
<html>
    <head>
        <title>
            students
      </title>
    <style>
        body{
            font-size:30px;
            background-color:orange;
            margin-left:100px;
        }
     </style>
    </head>
<body>

<pre>

<?php  
//create an array of students
$students=array(             //we create an array called students,array is created using array() function
    "Kavya Thulasi",
    "Fathima Basheer",        //each names are stored as strings inside the array
    "Ananthalekshmi",          //php assigns a numeric index to each element
    "Athira"
);
//display the  original array using print_r 
echo"<pre>";  // to format the output in a readable way
print_r($students);   //print_r() is a built -in function used to print arrays
echo"</pre>";

//sort the array in ascending order  using asort function
asort($students);
echo "Array after sorting in ascending order (asort): <br><pre>";
print_r($students);
echo"</pre>";


//sort the array in descending order  using arsort function
arsort($students);
echo "Array after sorting in descending order (arsort): <br><pre>";
print_r($students);
echo"</pre>";

?>  

</pre>
 
</body>
</html>
