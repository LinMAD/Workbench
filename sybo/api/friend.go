package api

import (
	"encoding/json"
	"fmt"
	"net/http"
)

const storageFriendPostfix = "friend"

// FriendList
type FriendList struct {
	// Friends list of friends
	Friends []User `json:"friends"`
}

// friend list endpoint handler
func (api *API) friend(w http.ResponseWriter, r *http.Request) {
	// TODO Move that to method\function
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
		var friendList FriendList
		if err := json.NewDecoder(r.Body).Decode(&friendList); err != nil {
			api.errorResponse(w, fmt.Errorf("%s", "Invalid request payload"), http.StatusBadRequest)

			return
		}

		api.Storage.Add(string(uuid)+storageFriendPostfix, friendList)
		api.successResponse(w, http.StatusAccepted, SuccessResponse{Message: "Accepted"})
	case "GET":
		friendList := api.Storage.Get(string(uuid+storageFriendPostfix))
		if friendList == nil {
			api.errorResponse(w, fmt.Errorf("%s", "Friend list not found"), http.StatusNotFound)

			return
		}

		api.successResponse(w, http.StatusOK, friendList)
	default:
		api.InvalidHTTPMethod(w)
	}
}
