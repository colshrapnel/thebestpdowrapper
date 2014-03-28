The best PDO wrapper
=================

Were written with three main goals in mind

- static singleton implementation
- fix for the execute() returning boolean disallowing method chaining

## Static singleton implementation

Although for the heavily OO-designned application such approac considered rather wrong practice, for the classical plain procedural PHP it is going the most reilable way, resembling old mysql_* style making database calls incredible simple in use, combining simplicity of old mysql functions with power and safety of prepared statements.

    $sql  = 'SELECT return, fields  FROM table WHERE search_field = ?';
    $data = DB:prepare($sql)->execute([$search_val])->fetchAll();

- only two lines to get search results!

Just define five constants with your DB credentials somewhere and then you'll be able to use database anywhere in your code, just like with old mysql ext used to be.

## fix for the execute() returning boolean

It's quite irritating that you always have to add another line to the expression to get the query results. So, with slightly amended PDOSTatement class it;s no more a problem.


##Examples 

    <?php
    include 'bestpdo.php';
    echo DB::query("SELECT 'foo'")->fetchColumn();
    $row = DB::prepare("SELECT :foo a, :foo b , :foo c")->execute(['foo'=>1])->fetch();
    echo DB::lastInsertId();
    
as you can see it's most simple, concise and intuitive usage

