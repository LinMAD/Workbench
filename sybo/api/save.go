package api

import (
	"fmt"
	"net/http"
)

// GameState
type GameState struct {
	// GamePlayed
	GamePlayed uint32
	// Score
	Score uint64
}

// gameState endpoint
func (api *API) gameState(w http.ResponseWriter, r *http.Request) {
	switch r.Method {
	case "POST":
		fmt.Fprint(w, "POST")
	case "GET":
		fmt.Fprint(w, "GET")
	default:
		api.InvalidHTTPMethod(w)
	}
}
