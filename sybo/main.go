package main

import (
	"flag"
	"github.com/LinMAD/workshops/sybo/api"
	"github.com/LinMAD/workshops/sybo/storage"
	"log"
	"net/http"
)

const tagMain = "Sybo:"

var apiPort string

func init() {
	flag.StringVar(&apiPort, "apiPort", "8042", "HTTP Port for API")
	flag.Parse()
}

func main() {
	// Create API and provide storage for data saving
	restApi := api.NewAPI(storage.Boot())

	// Listen HTTP Requests and handle requests
	log.Printf("%s: Running web server at: http://127.0.0.1:%s/", tagMain, apiPort)
	if serverErr := http.ListenAndServe(":"+apiPort, restApi.Router); serverErr != nil {
		log.Fatal(serverErr.Error())
	}
}
