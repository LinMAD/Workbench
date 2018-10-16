package main

import (
	"flag"
	"github.com/LinMAD/workshops/sybo/api"
	"github.com/LinMAD/workshops/sybo/storage"
	"log"
	"net/http"
)

var apiPort string

func init() {
	flag.StringVar(&apiPort, "apiPort", "8042", "HTTP Port for API")
	flag.Parse()
}

func main() {
	// Create API and provide storage for data saving
	restApi := api.NewAPI(storage.Boot())
	restApi.ServeAllEndpoints()

	// Listen HTTP Requests and handle requests
	if serverErr := http.ListenAndServe(":"+apiPort, nil); serverErr != nil {
		log.Fatal(serverErr.Error())
	}
}
