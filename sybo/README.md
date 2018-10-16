### Sybo

Project structure
```text
├── api         // endpoint handlers and routes
├── generator   // contains different implemented generators, like UUID
└── storage     // handlers to store date, database, cache etc
main.go         // Entry point
```

#### REST Endpoints

```
api
└── user
    └── POST, GET
    ├── state
    |       └── PUT, GET
    └── friend
            └── PUT, GET
```

User structure:
```go
type User struct {
    // ID unique identity number
    ID UUID `json:"id,omitempty"`
    // User nickname or name
    Name string `json:"name"`
}
```

State structure:
```go
// GameState
type GameState struct {
	// GamesPlayed
	GamesPlayed uint32 `json:"gamesPlayed"`
	// Score
	Score uint64 `json:"score"`
}
```

Friend
```go
type FriendList struct {
	// Friends list of friends
	Friends []User `json:"friends"`
}
```

How to build: `$: make build`


HTTP Port of API service can be changed via flag:
`$: ./sybo -apiPort 8080`

Example of output:
```text
$: ./sybo -apiPort 8008
2018/10/17 01:18:01 Sybo:: Running web server at: http://127.0.0.1:8008/

```