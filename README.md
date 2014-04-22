The best PDO wrapper
=================

Were written with these main goals in mind:

- static singleton implementation to make DB layer available anywhere
- fix for the execute() returning boolean disallowing method chaining

Although for the heavily OO-designned application **such an approach considered rather wrong practice**, for the classical plain procedural PHP it is going to be the most reilable way, resembling old mysql_* style, making database calls incredible simple in use, combining simplicity of old mysql functions with power and safety of prepared statements. A quick example:

    $sql  = 'SELECT return, fields  FROM table WHERE search_field = ?';
    $data = DB:prepare($sql)->execute([$search_val])->fetchAll();

only two lines to get search results!

All you need is to edit configuration constants and include this file in some bootstrap file. **That's all.** And immediately it will let you use PDO as easy as mysql_* used to be (as long as you have this file included), yet with full power and safety of prepared statements. Or even simpler than old mysql ext, as most operations will be written in one-two lines.

There are yet some differences from old mysql ext:

- instead of calling `mysql_query` you have to call `DB::prepare()`
- instead of adding variables in the query directly you have to pass them in `execute()` and substitute them in the query with question marks.
- instead of just single fetch method use whatever suits you best:
 - if you need only single scalar value, use `fetchColumn()`
 - if you need one row, use `fetch()`
 - if you need multiple rows, use `fetchAll()` to get them into array to loop over afterwards

In short, you have to run your queries in three steps:

- prepare
- execute
- fetch

Here are some usage examples

    <?php
    include 'bestpdo.php';
    
    // with two variables and one row returned
    $sql  = "SELECT * FROM users WHERE name = ? AND password=?";
    $user = DB::prepare($sql)->execute([$_POST['name'],$_POST['pass']])->fetch();
    echo $user['name'];
    
    // with one variable and single value returned
    $sql   = "SELECT count(*) FROM users WHERE age > ?";
    $count = DB::prepare($sql)->execute([$age])->fetchColumn();
    echo $count;

    // without variables and getting more than one rows
    $sql  = "SELECT * FROM users ORDER BY id DESC";
    $data = DB::prepare($sql)->execute()->fetchAll();
    foreach($data as $row) {
        echo $user['name'];
    }

    //insert with getting insert id
    $sql  = "INSERT INTO users VALUES (NULL,?,?,?)";
    $user = DB::prepare($sql)->execute([$name,$pass,$email])->fetch();
    $id   = DB::lastInsertId();

as you can see it's most simple, concise and intuitive usage

And remember - you have to follow the main rule of creating SQL statements: **every variable should go into query via placeholder only**

Some technical notes and explanations (or, rather, excuses =).

### Static singleton implementation 

Well, singleton considered a test-killer. Okay, fair point.   
But see, there are *two* PHPs actually: Beside brave new shiny java-like PHP, there is still dirty old procedural spaghetti HTML-all-over-the-place PHP. And, judging by StackOverflow questions, users of the latter are innumerable. Struggling even with plain procedural mysql_*, they take mysqli and PDO as a disaster. Their attempts to use these two honest extensions would make one scream. So - better to supply them with a tool that they can use, avoiding all the pitfalls like multiple connections, lack of error reporting, and stuff.

### fix for the execute() returning boolean disallowing method chaining

This is an obvious fix. In exception mode, one don't need to check execute() results manually. Means we can make it return statement, which will allow us neat method caining. 
