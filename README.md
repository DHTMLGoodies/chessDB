LudoDB based resources and services for DHTML Chess

Available services:

__resource->services:__

```JSON
{
    "ChessDBInstaller":["install"],
    "ChessFS":["listOfGames", "getGame"],
    "ChessFSPgn":["read"],
    "Countries":["read"],
    "CurrentPlayer":["read","save"],
    "Database":["games", "read", "save", "randomGame"],
    "Databases":["read"],
    "Eco":["moves", "read"],
    "Folders":["read"],
    "Game":["read", "save", "delete"],
    "GameImport":["import"],
    "Player":["gravatar", "seeks", "games", "archive", "register"],
    "Seek":["save"],
    "Session":["authenticate", "signIn", "signOut"]
}
```