<?php

if (php_sapi_name() != "cli") {
    exit;
}

$db = new SQLite3("database.db");

$query = <<<SQL
    CREATE TABLE "users" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `firstname` TEXT, `lastname` TEXT, `department` TEXT, qr_id TEXT UNIQUE, time INTEGER DEFAULT (unixepoch()));
    CREATE TABLE "attendance" (`id` INTEGER PRIMARY KEY AUTOINCREMENT, "user_id" INTEGER REFERENCES "users"(`id`), `time` INTEGER DEFAULT (unixepoch()));
SQL;

$db->query($query);
echo "Database initialized.\n";