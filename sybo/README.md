### Sybo

Project structure
```text
├── api         // endpoint handlers and routes
├── generator   // contains different implemented generators, like UUID
└── storage     // handlers to store date, database, cache etc
main.go         // Entry point
```

#### Installation and configuration for Linux
- How to install go -> https://golang.org/doc/install
- How to build: `$: make build`
- How to IP forward on linux of game client: `iptables -t nat -A OUTPUT -p tcp --dport 8000 -d 10.19.82.157 -j DNAT --to-destination 127.0.0.1:8000`

HTTP Port of API service can be changed via flag:
`$: ./sybo -apiPort 8080`
Example of output:
```text
$: ./sybo -apiPort 8008
2018/10/17 01:18:01 Sybo:: Running web server at: http://127.0.0.1:8008/
```

REST API Endpoints
=================

Each user has unique UUID and it will be used to get related information, like high scores, friend list etc.

###### Request content
<!--ts-->
   * [User](#User)
   * [State](#State)
   * [Friend](#Friend)
   * [Response](#Response)
<!--te-->

Communication schema
```text
                   +----------------+
                   |  Game clients  |
                   +-----------^----+
                       |       |
                       |       |
                       |       |
                       |       |
                   +---v------------+
                   |                |
                   |   API Server   |
                   |                |
                   +----------------+
                           |
                   +-------v--------+
                   |                |
                   |Endpoint routing|
                   |                |
                   +----------------+
                           |
                           |
                     +-----v------+
                     |            |
                     |    User    |
                   +-+            +---+
                   | +------------+   |
                   |                  |
                   |                  |
             +-----v-------+   +------v------+
             |             |   |             |
             |    State    |   |    Friend   |
             |             |   |             |
             +-------------+   +-------------+
```

User
============
```text
Create user:
POST http://host:port/user
Payload: { "name": "Alpha" }
Response code: 201 (Created), 400 (Payload error)

Get list of users:
GET http://host:port/user
Response code: 200
Response data:
{
    "users":[
        {"id":"102529c3-d69c-4a39-a133-428ea955bc4f","name":"Alpha"},
        {"id":"28d9314c-c590-4127-9048-9f6feac91524","name":"Omega"}
    ]
}
```

State
============
```text
Add stats for user
PUT http://localhost:8000/user/fed56919-db51-44d0-ba67-c79c1e7cc3e0/state
Payload: {"gamesPlayed":5,"score":1500}
Response code: 202 (Updated), 400 (Payload error)
```

```text
Get stats of user
GET http://localhost:8000/user/102529c3-d69c-4a39-a133-428ea955bc4f/state
Response code: 200, 404 (If states not exist)
Response data: {"gamesPlayed":5,"score":1500}
```

Friend
============
```text
Add stats for user
PUT http://localhost:8000/user/beaded8f-e09a-4171-a358-82d91509417e/friends
Payload: {
    "friends":[
        "28d9314c-c590-4127-9048-9f6feac91524",
        "102529c3-d69c-4a39-a133-428ea955bc4f"
    ]
}
Response code: 202 (Updated), 400 (Payload error)
```

```text
Get user friends
GET http://localhost:8000/user/beaded8f-e09a-4171-a358-82d91509417e/friends
Response code: 200 (Found), 404 (If friend list not exist)
Response data: 
{
    "friends":[
        "28d9314c-c590-4127-9048-9f6feac91524",
        "102529c3-d69c-4a39-a133-428ea955bc4f"
    ]
}
```

Response
============
API has 2 types of responses by structure: successful and with error

Examples:

Success:`{"success":"Accept"}`

Error:`{"error":"User not found"}`
