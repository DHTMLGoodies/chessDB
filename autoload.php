<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'accessortest' => '/ludoDB/Tests/AccessorTest.php',
                'achild' => '/ludoDB/Tests/classes/Dependencies/AChild.php',
                'acity' => '/ludoDB/Tests/classes/Dependencies/ACity.php',
                'allchesstests' => '/Tests/AllChessTests.php',
                'anotherchild' => '/ludoDB/Tests/classes/Dependencies/AnotherChild.php',
                'aparent' => '/ludoDB/Tests/classes/Dependencies/AParent.php',
                'asibling' => '/ludoDB/Tests/classes/Dependencies/ASibling.php',
                'author' => '/ludoDB/examples/mod_rewrite/Author.php',
                'book' => '/ludoDB/examples/mod_rewrite/Book.php',
                'bookauthor' => '/ludoDB/examples/mod_rewrite/BookAuthor.php',
                'bookauthors' => '/ludoDB/examples/mod_rewrite/BookAuthors.php',
                'brand' => '/ludoDB/Tests/classes/Brand.php',
                'cachetest' => '/ludoDB/Tests/CacheTest.php',
                'capital' => '/ludoDB/Tests/classes/JSONCaching/Capital.php',
                'capitals' => '/ludoDB/Tests/classes/JSONCaching/Capitals.php',
                'car' => '/ludoDB/Tests/classes/Car.php',
                'carcollection' => '/ludoDB/Tests/classes/CarCollection.php',
                'carproperties' => '/ludoDB/Tests/classes/CarProperties.php',
                'carproperty' => '/ludoDB/Tests/classes/CarProperty.php',
                'chat' => '/chat/Chat.php',
                'chatmessage' => '/chat/ChatMessage.php',
                'chatmessages' => '/chat/ChatMessages.php',
                'chessfileupload' => '/ChessFileUpload.php',
                'chessroles' => '/Roles.php',
                'chesssessiontest' => '/Tests/SessionTest.php',
                'chesstests' => '/Tests/ChessTests.php',
                'city' => '/ludoDB/Tests/classes/City.php',
                'client' => '/ludoDB/Tests/classes/Client.php',
                'collectiontest' => '/ludoDB/Tests/CollectionTest.php',
                'columnaliastest' => '/ludoDB/Tests/ColumnAliasTest.php',
                'configparsertest' => '/ludoDB/Tests/ConfigParserTest.php',
                'configparsertestjson' => '/ludoDB/Tests/ConfigParserTestJSON.php',
                'countries' => '/player/Countries.php',
                'country' => '/player/Country.php',
                'database' => '/Database.php',
                'databases' => '/Databases.php',
                'dhtmlchess\\ludodbrequesthandler' => '/ludoDB/LudoDBRequestHandler.php',
                'eco' => '/eco/Eco.php',
                'ecomoves' => '/eco/EcoMoves.php',
                'ecomovesdetailed' => '/eco/EcoMovesDetailed.php',
                'fen' => '/Fen.php',
                'fentest' => '/Tests/FenTest.php',
                'folder' => '/Folder.php',
                'folders' => '/Folders.php',
                'forsqltest' => '/ludoDB/Tests/classes/ForSQLTest.php',
                'game' => '/game/Game.php',
                'gameimport' => '/game/GameImport.php',
                'games' => '/game/Games.php',
                'gametest' => '/Tests/GameTest.php',
                'grandparent' => '/ludoDB/Tests/classes/Dependencies/GrandParent.php',
                'importtest' => '/Tests/ImportTest.php',
                'jsontest' => '/ludoDB/Tests/JSONTest.php',
                'ludodb' => '/ludoDB/LudoDB.php',
                'ludodbadapter' => '/ludoDB/LudoDBInterfaces.php',
                'ludodbcache' => '/ludoDB/LudoDBCache.php',
                'ludodbclassnotfoundexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbcollection' => '/ludoDB/LudoDBCollection.php',
                'ludodbcollectionconfigparser' => '/ludoDB/LudoDBCollectionConfigParser.php',
                'ludodbconfigparser' => '/ludoDB/LudoDBConfigParser.php',
                'ludodbconnectionexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbinvalidserviceexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbiterator' => '/ludoDB/LudoDBIterator.php',
                'ludodbmodel' => '/ludoDB/LudoDBModel.php',
                'ludodbmodeltests' => '/ludoDB/Tests/LudoDBModelTests.php',
                'ludodbmysql' => '/ludoDB/LudoDBMysql.php',
                'ludodbmysqli' => '/ludoDB/LudoDBMySqlI.php',
                'ludodbobject' => '/ludoDB/LudoDBObject.php',
                'ludodbobjectnotfoundexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbpdo' => '/ludoDB/LudoDBPDO.php',
                'ludodbregistry' => '/ludoDB/LudoDBRegistry.php',
                'ludodbservice' => '/ludoDB/LudoDBInterfaces.php',
                'ludodbservicenotimplementedexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbsql' => '/ludoDB/LudoDBSQL.php',
                'ludodbtreecollection' => '/ludoDB/LudoDBTreeCollection.php',
                'ludodbtreecollectiontest' => '/ludoDB/Tests/LudoDBTreeCollectionTest.php',
                'ludodbunauthorizedexception' => '/ludoDB/LudoDBExceptions.php',
                'ludodbutility' => '/ludoDB/LudoDBUtility.php',
                'ludodbutilitymock' => '/ludoDB/Tests/LudoDBUtilityTest.php',
                'ludodbutilitytest' => '/ludoDB/Tests/LudoDBUtilityTest.php',
                'manager' => '/ludoDB/Tests/classes/Manager.php',
                'metadata' => '/game/Metadata.php',
                'metadatacollection' => '/game/MetadataCollection.php',
                'metadatatest' => '/Tests/MetadataTest.php',
                'metadatavalue' => '/game/MetadataValue.php',
                'move' => '/game/Move.php',
                'moves' => '/game/Moves.php',
                'movie' => '/ludoDB/Tests/classes/Movie.php',
                'mysqlitests' => '/ludoDB/Tests/MysqlITests.php',
                'noludodbclass' => '/ludoDB/Tests/classes/Dependencies/NoLudoDBClass.php',
                'pdotests' => '/ludoDB/Tests/PDOTests.php',
                'people' => '/ludoDB/Tests/classes/People.php',
                'peopleplain' => '/ludoDB/Tests/classes/PeoplePlain.php',
                'performancetest' => '/ludoDB/Tests/PerformanceTest.php',
                'person' => '/ludoDB/Tests/classes/Person.php',
                'personforconfigparser' => '/ludoDB/Tests/classes/PersonForConfigParser.php',
                'phone' => '/ludoDB/Tests/classes/Phone.php',
                'phonecollection' => '/ludoDB/Tests/classes/PhoneCollection.php',
                'player' => '/player/Player.php',
                'playerbyname' => '/player/PlayerByName.php',
                'playerbyusernamepassword' => '/player/PlayerByUsernamePassword.php',
                'playertest' => '/Tests/PlayerTest.php',
                'requesthandlermock' => '/ludoDB/Tests/classes/RequestHandlerMock.php',
                'requesthandlertest' => '/ludoDB/Tests/RequestHandlerTest.php',
                'section' => '/ludoDB/Tests/classes/Section.php',
                'seek' => '/Seek.php',
                'seektest' => '/Tests/SeekTest.php',
                'session' => '/Session.php',
                'sqltest' => '/ludoDB/Tests/SQLTest.php',
                'testbase' => '/ludoDB/Tests/TestBase.php',
                'testcountry' => '/ludoDB/Tests/classes/TestCountry.php',
                'testgame' => '/ludoDB/Tests/classes/TestGame.php',
                'testnode' => '/ludoDB/Tests/classes/TestNode.php',
                'testnodes' => '/ludoDB/Tests/classes/TestNodes.php',
                'testtable' => '/ludoDB/Tests/classes/TestTable.php',
                'testtimer' => '/ludoDB/Tests/classes/TestTimer.php',
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