<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'alltests' => '/ludoDB/Tests/AllTests.php',
                'car' => '/ludoDB/Tests/classes/Car.php',
                'carcollection' => '/ludoDB/Tests/classes/CarCollection.php',
                'chesstests' => '/Tests/ChessTests.php',
                'city' => '/ludoDB/Tests/classes/City.php',
                'collectiontest' => '/ludoDB/Tests/CollectionTest.php',
                'country' => '/ludoDB/Tests/classes/Country.php',
                'dbtest' => '/ludoDB/Tests/DBTest.php',
                'findertest' => '/ludoDB/Tests/FinderTest.php',
                'gametest' => '/Tests/GameTest.php',
                'jsontest' => '/ludoDB/Tests/JSONTest.php',
                'ludodb' => '/ludoDB/LudoDB.php',
                'ludodbcollection' => '/ludoDB/LudoDbCollection.php',
                'ludodbtable' => '/ludoDB/LudoDbTable.php',
                'ludofinder' => '/ludoDB/LudoFinder.php',
                'person' => '/ludoDB/Tests/classes/Person.php',
                'player' => '/Player.php',
                'playerfinder' => '/PlayerFinder.php',
                'playertest' => '/Tests/PlayerTest.php',
                'seek' => '/Seek.php',
                'seektest' => '/Tests/SeekTest.php',
                'session' => '/Session.php',
                'sessiontest' => '/Tests/SessionTest.php',
                'testbase' => '/ludoDB/Tests/TestBase.php',
                'testtable' => '/ludoDB/Tests/classes/TestTable.php',
                'timecontrol' => '/TimeControl.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd