# WriteMyData
Write data in a flexible way

# Propose
```php
$wmd_mysql = new WriteMyData(new MysqlWrite($pdo, new MysqlDefaultPersistence));

// Make the migration on the fly
$wmd_mysql->active();

$wmd_mysql
        ->collection('contacts')
        ->persists([
            'name' => 'Leonardo Tumadjian',
            'cel' => '5555-5555',
            'address' => '330th Eleven street'
        ]);

/* It should produce at first time:
//  CREATE TABLE `contacts`
    (
        `id` int not null auto_increment,
        `name` varchar(220) not null,
        `cel` varchar(220) not null,
        `address` varchar(220) not null,
        constraint `pk_contacts` primary key (id)
    );

    INSERT `contacts` (name, cel, address)
    VALUES ('Leonardo Tumadjian', '5555-5555', '330th Eleven street')
*/

$wmd_mysql
        ->collection('contacts')
        ->persists([
            'name' => 'Matt Miller',
            'cel' => '2222-2222',
            'address' => '11th Seven street'
        ]);

// Second insert
// It should produce:
/*
    INSERT `contacts` (name, cel, address)
    VALUES ('Matt Miller', '2222-2222', '11th Seven street')
*/

$wmd_mysql
        ->collection('contacts')
        ->persists([
            'name' => 'John Doe',
            'cel' => '3333-3333',
            'address' => '14th Quarter Street',
            'new_field' => 'Wow!!'
        ]);

// Second insert
// It should produce:
/*
    ALTER TABLE `contacts`
    ADD COLUMN `new_field` varchar(220) not null

    INSERT `contacts` (name, cel, address, new_field)
    VALUES ('John Doe', '3333-3333', '14th Quarter Street', 'Wow!!')
*/
```
Static migration:

```
wmd static-migration
```

Will stream: contacts_migration.php
```sql
CREATE TABLE `contacts`
(
    `id` int not null auto_increment,
    `name` varchar(220) not null,
    `cel` varchar(220) not null,
    `address` varchar(220) not null,
    `new_field` varchar(220) not null,
    constraint `pk_contacts` primary key (id)
);
```