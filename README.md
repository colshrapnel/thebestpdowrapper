The the best PDO wrapper
=================

Were written with three main goals in mind

- static singleton implementation
- fix for the problem with binding integers 
- fix for the execute() returning boolean disallowing method chaining

##Examples 

    <?php
    include 'bestpdo.php';
    echo DB::query("SELECT 'foo'")->fetchColumn();
    var_dump(DB::prepare("SELECT :foo a, :foo b , :foo c")->execute(['foo'=>1])->fetch());
    echo DB::lastInsertId();
    
as you can see it's most simple, concise and intuitive usage

