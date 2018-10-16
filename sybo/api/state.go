package api

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"strings"
)

const (
	tagGameState  = "GameState:"
	storagePrefix = "state"
)

// GameState
type GameState struct {
	// GamesPlayed
	GamesPlayed uint32 `json:"gamesPlayed"`
	// Score
	Score uint64 `json:"score"`
}

// gameState endpoint
func (api *API) gameState(w http.ResponseWriter, r *http.Request) {
	var uuid UUID
	var uuidErr error

	if r.Method == "PUT" || r.Method == "GET" {
		uuid, uuidErr = getUserUUIDFromPath(r)
		if uuidErr != nil {
			api.ErrorResponse(w, uuidErr, http.StatusServiceUnavailable)

			return
		}
	}

	switch r.Method {
	case "PUT":
		user := api.Storage.Get(string(uuid))
		if user == nil {
			api.ErrorResponse(w, fmt.Errorf("%s","Unable to save"), http.StatusNotFound)

			return
		}

		var gameState GameState
		if err := json.NewDecoder(r.Body).Decode(&gameState); err != nil {
			api.ErrorResponse(w, fmt.Errorf("%s", "Invalid request payload"), http.StatusBadRequest)

			return
		}

		api.Storage.Add(string(uuid) + storagePrefix, gameState)


		api.SuccessResponse(w, http.StatusCreated, SuccessResponse{Message: "Saved"})
	case "GET":
		gameState := api.Storage.Get(string(uuid) + storagePrefix)
		if gameState == nil {
			api.ErrorResponse(w, fmt.Errorf("%s", "Game state not found"), http.StatusNotFound)

			return
		}

		api.SuccessResponse(w, http.StatusOK, gameState)
	default:
		api.InvalidHTTPMethod(w)
	}
}

// getUserUUIDFromPath extract uuid from request
func getUserUUIDFromPath(r *http.Request) (UUID, error) {
	urlPart := strings.Split(r.URL.Path, "/")
	if len(urlPart) != 4 { // -> /user/{id}/state
		err := fmt.Errorf("%s", "Unexpected err")
		log.Printf("%s Url parsing error: %s", tagGameState, "Expected 3 part of url, returned less")

		return "", err
	}

	return UUID(urlPart[2]), nil
}