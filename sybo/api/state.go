package api

import (
	"encoding/json"
	"fmt"
	"net/http"
)

const (
	tagGameState        = "GameState:"
	storageStatePostfix = "state"
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
	// TODO Move that to method
	var uuid UUID
	var uuidErr error

	if r.Method == "PUT" || r.Method == "GET" {
		uuid, uuidErr = api.getUserUUIDFromPath(r)
		if uuidErr != nil {
			api.errorResponse(w, uuidErr, http.StatusServiceUnavailable)

			return
		}

		isUser := api.Storage.Get(string(uuid))
		if isUser == nil {
			api.errorResponse(w, fmt.Errorf("%s", "User not found"), http.StatusNotFound)

			return
		}
	}

	switch r.Method {
	case "PUT":
		var gameState GameState
		if err := json.NewDecoder(r.Body).Decode(&gameState); err != nil {
			api.errorResponse(w, fmt.Errorf("%s", "Invalid request payload"), http.StatusBadRequest)

			return
		}

		api.Storage.Add(string(uuid)+storageStatePostfix, gameState)
		api.successResponse(w, http.StatusAccepted, SuccessResponse{Message: "Accept"})
	case "GET":
		gameState := api.Storage.Get(string(uuid) + storageStatePostfix)
		if gameState == nil {
			api.errorResponse(w, fmt.Errorf("%s", "Game state not found"), http.StatusNotFound)

			return
		}

		api.successResponse(w, http.StatusOK, gameState)
	default:
		api.InvalidHTTPMethod(w)
	}
}
